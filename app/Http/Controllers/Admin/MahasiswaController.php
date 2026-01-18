<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mengambil data mahasiswa dengan pagination (misal: 10 data per halaman)
        $query = Mahasiswa::with(['user', 'dosenPembimbing']);

        // Filter berdasarkan search
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                })->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan angkatan
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->get('angkatan'));
        }

        $mahasiswa = $query->paginate(10)->appends($request->query());

        // Mengirimkan variabel $mahasiswa ke view
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dosens = User::whereHas('role', function ($query) {
            $query->where('name', 'dosen');
        })->get();
        
        return view('admin.mahasiswa.form', compact('dosens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'nim' => 'required|string|unique:mahasiswa,nim',
            'angkatan' => 'required|string',
            'prodi' => 'required|string',
            'status' => 'required|in:aktif,cuti,non-aktif,lulus',
            'dosen_pembimbing_id' => 'nullable|exists:users,id',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role_id' => 3, // Assuming 3 is the student role
        ]);

        // Create mahasiswa
        Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => $validated['nim'],
            'nama' => $validated['name'],
            'angkatan' => $validated['angkatan'],
            'prodi' => $validated['prodi'],
            'status' => $validated['status'],
            'dosen_pembimbing_id' => $validated['dosen_pembimbing_id'],
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        $dosens = User::whereHas('role', function ($query) {
            $query->where('name', 'dosen');
        })->get();
        
        return view('admin.mahasiswa.form', compact('mahasiswa', 'dosens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $mahasiswa->user_id,
            'nim' => 'required|string|unique:mahasiswa,nim,' . $mahasiswa->id,
            'angkatan' => 'required|string',
            'prodi' => 'required|string',
            'status' => 'required|in:aktif,cuti,non-aktif,lulus',
            'dosen_pembimbing_id' => 'nullable|exists:users,id',
        ]);

        // Update user
        $mahasiswa->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update mahasiswa
        $mahasiswa->update([
            'nim' => $validated['nim'],
            'nama' => $validated['name'],
            'angkatan' => $validated['angkatan'],
            'prodi' => $validated['prodi'],
            'status' => $validated['status'],
            'dosen_pembimbing_id' => $validated['dosen_pembimbing_id'],
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $user = $mahasiswa->user;
        $mahasiswa->delete();
        $user->delete();

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }

    /**
     * Import mahasiswa from CSV file
     */
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        try {
            $file = $request->file('file');
            
            // Validasi file bisa dibaca
            if (!$file || !is_readable($file->getPathname())) {
                return redirect()->route('admin.mahasiswa.index')->with('error', 'File tidak bisa dibaca atau tidak valid.');
            }
            
            $path = $file->getPathname();
            
            // Baca CSV
            if (($handle = fopen($path, 'r')) === false) {
                return redirect()->route('admin.mahasiswa.index')->with('error', 'Gagal membuka file CSV.');
            }
            
            $headers = null;
            $headerMap = null;
            $imported = 0;
            $errors = [];
            $rowNumber = 0;
            
            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;
                
                // Get headers from first row
                if ($headers === null) {
                    $headers = $row;
                    $headerMap = array_flip($headers);
                    continue;
                }
                
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }
                
                try {
                    // Extract data from row based on header positions
                    $data = [
                        'name' => isset($headerMap['name']) && isset($row[$headerMap['name']]) ? trim($row[$headerMap['name']]) : null,
                        'email' => isset($headerMap['email']) && isset($row[$headerMap['email']]) ? trim($row[$headerMap['email']]) : null,
                        'nim' => isset($headerMap['nim']) && isset($row[$headerMap['nim']]) ? trim($row[$headerMap['nim']]) : null,
                        'angkatan' => isset($headerMap['angkatan']) && isset($row[$headerMap['angkatan']]) ? trim($row[$headerMap['angkatan']]) : null,
                        'prodi' => isset($headerMap['prodi']) && isset($row[$headerMap['prodi']]) ? trim($row[$headerMap['prodi']]) : null,
                        'status' => isset($headerMap['status']) && isset($row[$headerMap['status']]) ? trim($row[$headerMap['status']]) : 'aktif',
                    ];
                    
                    // Validate data
                    if (empty($data['name']) || empty($data['email']) || empty($data['nim'])) {
                        $errors[] = "Baris $rowNumber: Data name, email, atau NIM tidak boleh kosong";
                        continue;
                    }
                    
                    // Validate email format
                    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Baris $rowNumber: Format email tidak valid: {$data['email']}";
                        continue;
                    }
                    
                    // Check if user already exists
                    $userExists = User::where('email', $data['email'])->exists();
                    if ($userExists) {
                        $errors[] = "Baris $rowNumber: Email {$data['email']} sudah terdaftar";
                        continue;
                    }
                    
                    // Check if mahasiswa already exists
                    $mahasiswaExists = Mahasiswa::where('nim', $data['nim'])->exists();
                    if ($mahasiswaExists) {
                        $errors[] = "Baris $rowNumber: NIM {$data['nim']} sudah terdaftar";
                        continue;
                    }
                    
                    // Create user with random password
                    $password = str_pad(mt_rand(0, 99999), 6, '0', STR_PAD_LEFT);
                    $user = User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'password' => bcrypt($password),
                        'role_id' => 3, // Assuming 3 is student role
                    ]);
                    
                    // Create mahasiswa
                    Mahasiswa::create([
                        'user_id' => $user->id,
                        'nim' => $data['nim'],
                        'nama' => $data['name'],
                        'angkatan' => $data['angkatan'],
                        'prodi' => $data['prodi'],
                        'status' => $data['status'],
                    ]);
                    
                    $imported++;
                    
                } catch (\Exception $e) {
                    $errors[] = "Baris $rowNumber: " . $e->getMessage();
                }
            }
            
            fclose($handle);
            
            if ($imported === 0 && !empty($errors)) {
                $message = "Gagal mengimport data. Errors: " . implode("; ", array_slice($errors, 0, 3));
                if (count($errors) > 3) {
                    $message .= "... dan " . (count($errors) - 3) . " error lainnya.";
                }
                return redirect()->route('admin.mahasiswa.index')->with('error', $message);
            }
            
            $message = "Berhasil mengimport $imported data mahasiswa.";
            if (!empty($errors)) {
                $message .= " Namun terdapat " . count($errors) . " error: " . implode("; ", array_slice($errors, 0, 3));
                if (count($errors) > 3) {
                    $message .= "... dan " . (count($errors) - 3) . " error lainnya.";
                }
                return redirect()->route('admin.mahasiswa.index')->with('warning', $message);
            }
            
            return redirect()->route('admin.mahasiswa.index')->with('success', $message);
            
        } catch (\Exception $e) {
            return redirect()->route('admin.mahasiswa.index')->with('error', 'Gagal mengimport file: ' . $e->getMessage());
        }
    }

    /**
     * Download CSV template
     */
    public function downloadTemplate()
    {
        $headers = ['name', 'email', 'nim', 'angkatan', 'prodi', 'status'];
        
        // Sample data
        $sampleData = [
            ['Budi Santoso', 'budi@kampus.ac.id', '20240001', '2024', 'Teknik Informatika', 'aktif'],
            ['Siti Nurhaliza', 'siti@kampus.ac.id', '20240002', '2024', 'Sistem Informasi', 'aktif'],
            ['Ahmad Hidayat', 'ahmad@kampus.ac.id', '20230001', '2023', 'Teknik Elektro', 'aktif'],
        ];
        
        $filename = "template_mahasiswa_" . date('Y-m-d') . ".csv";
        
        $handle = fopen('php://memory', 'w');
        
        // Add headers
        fputcsv($handle, $headers);
        
        // Add sample data
        foreach ($sampleData as $row) {
            fputcsv($handle, $row);
        }
        
        rewind($handle);
        
        $content = stream_get_contents($handle);
        fclose($handle);
        
        return response($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Export all mahasiswa to CSV
     */
    public function export()
    {
        $mahasiswa = Mahasiswa::with('user')->get();
        
        $headers = ['NIM', 'Nama', 'Email', 'Program Studi', 'Angkatan', 'Status', 'Tanggal Terdaftar'];
        
        $filename = "mahasiswa_" . date('Y-m-d_H-i-s') . ".csv";
        
        $handle = fopen('php://memory', 'w');
        
        // Add headers
        fputcsv($handle, $headers);
        
        // Add data
        foreach ($mahasiswa as $m) {
            fputcsv($handle, [
                $m->nim,
                $m->user->name,
                $m->user->email,
                $m->prodi,
                $m->angkatan,
                $m->status,
                $m->created_at->format('Y-m-d H:i:s'),
            ]);
        }
        
        rewind($handle);
        
        $content = stream_get_contents($handle);
        fclose($handle);
        
        return response($content, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
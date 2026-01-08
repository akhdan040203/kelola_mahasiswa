<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KrsController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        if (!$mahasiswa) {
            return redirect()->route('dashboard')->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        $krs = Krs::where('mahasiswa_id', $mahasiswa->id)->latest()->paginate(10);
        return view('student.krs.index', compact('krs'));
    }

    public function create()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        // Check if there is already an active/pending KRS for this semester (simple logic for demo)
        
        $mataKuliah = MataKuliah::orderBy('semester')->orderBy('kode_mk')->get();
        return view('student.krs.form', compact('mataKuliah', 'mahasiswa'));
    }

    public function store(Request $request)
    {
        $mahasiswa = Auth::user()->mahasiswa;
        
        $request->validate([
            'semester' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'mata_kuliah_ids' => 'required|array|min:1',
            'mata_kuliah_ids.*' => 'exists:mata_kuliah,id',
        ]);

        $krs = Krs::create([
            'mahasiswa_id' => $mahasiswa->id,
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'status' => $request->submit_action == 'submit' ? 'submitted' : 'draft',
            'submitted_at' => $request->submit_action == 'submit' ? now() : null,
        ]);

        $krs->mataKuliah()->sync($request->mata_kuliah_ids);

        $message = $request->submit_action == 'submit' ? 'KRS berhasil diajukan.' : 'KRS berhasil disimpan sebagai draft.';
        return redirect()->route('student.krs.index')->with('success', $message);
    }

    public function show($id)
    {
        $krs = Krs::with(['mataKuliah.dosen'])->findOrFail($id);
        
        // Authorization check
        if ($krs->mahasiswa_id != Auth::user()->mahasiswa->id) {
            abort(403);
        }

        return view('student.krs.show', compact('krs'));
    }

    public function edit($id)
    {
        $krs = Krs::with('mataKuliah')->findOrFail($id);
        
        if ($krs->mahasiswa_id != Auth::user()->mahasiswa->id || $krs->status != 'draft') {
            return redirect()->route('student.krs.index')->with('error', 'Anda tidak dapat mengubah KRS ini.');
        }

        $mataKuliah = MataKuliah::orderBy('semester')->orderBy('kode_mk')->get();
        $selectedIds = $krs->mataKuliah->pluck('id')->toArray();
        
        return view('student.krs.form', compact('krs', 'mataKuliah', 'selectedIds'));
    }

    public function update(Request $request, $id)
    {
        $krs = Krs::findOrFail($id);
        
        if ($krs->mahasiswa_id != Auth::user()->mahasiswa->id || $krs->status != 'draft') {
            return redirect()->route('student.krs.index')->with('error', 'Anda tidak dapat mengubah KRS ini.');
        }

        $request->validate([
            'semester' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'mata_kuliah_ids' => 'required|array|min:1',
            'mata_kuliah_ids.*' => 'exists:mata_kuliah,id',
        ]);

        $krs->update([
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'status' => $request->submit_action == 'submit' ? 'submitted' : 'draft',
            'submitted_at' => $request->submit_action == 'submit' ? now() : $krs->submitted_at,
        ]);

        $krs->mataKuliah()->sync($request->mata_kuliah_ids);

        $message = $request->submit_action == 'submit' ? 'KRS berhasil diajukan.' : 'KRS berhasil diperbarui.';
        return redirect()->route('student.krs.index')->with('success', $message);
    }

    public function submit($id)
    {
        $krs = Krs::findOrFail($id);
        
        if ($krs->mahasiswa_id != Auth::user()->mahasiswa->id || $krs->status != 'draft') {
            return redirect()->route('student.krs.index')->with('error', 'KRS tidak dapat disubmit.');
        }

        $krs->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return redirect()->route('student.krs.index')
            ->with('success', 'KRS berhasil diajukan untuk review.');
    }

    public function destroy($id)
    {
        $krs = Krs::findOrFail($id);
        
        if ($krs->mahasiswa_id != Auth::user()->mahasiswa->id || $krs->status != 'draft') {
            return redirect()->route('student.krs.index')->with('error', 'Hanya KRS draft yang dapat dihapus.');
        }

        $krs->delete();

        return redirect()->route('student.krs.index')
            ->with('success', 'Draft KRS berhasil dihapus.');
    }
}

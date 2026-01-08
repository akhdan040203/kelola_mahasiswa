<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AbsensiPertemuan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        
        // Find all meeting sessions for courses this student takes
        $sessions = AbsensiPertemuan::with(['mataKuliah', 'absensi' => function($q) use ($mahasiswa) {
                $q->where('mahasiswa_id', $mahasiswa->id);
            }])
            ->whereHas('mataKuliah.krsMataKuliah.krs', function($q) use ($mahasiswa) {
                $q->where('mahasiswa_id', $mahasiswa->id)
                  ->where('status', 'approved');
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('pertemuan_ke', 'desc')
            ->paginate(10);

        return view('student.absensi.index', compact('sessions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'absensi_pertemuan_id' => 'required|exists:absensi_pertemuan,id',
        ]);

        $mahasiswa = Auth::user()->mahasiswa;
        $pertemuan = AbsensiPertemuan::findOrFail($request->absensi_pertemuan_id);

        if (!$pertemuan->is_open) {
            return redirect()->back()->with('error', 'Maaf, sesi absensi ini sudah ditutup.');
        }

        // Check if student is enrolled in this course
        $isEnrolled = $mahasiswa->krs()
            ->where('status', 'approved')
            ->whereHas('mataKuliah', function($q) use ($pertemuan) {
                $q->where('mata_kuliah.id', $pertemuan->mata_kuliah_id);
            })->exists();

        if (!$isEnrolled) {
            abort(403, 'Anda tidak terdaftar di mata kuliah ini.');
        }

        // Update or create attendance record
        // Status is 'hadir' since they are filling it themselves
        $absensi = Absensi::updateOrCreate(
            [
                'absensi_pertemuan_id' => $pertemuan->id,
                'mahasiswa_id' => $mahasiswa->id,
            ],
            [
                'mata_kuliah_id' => $pertemuan->mata_kuliah_id,
                'status' => 'hadir',
                'tanggal_absen' => now(), // Optional, could add this column if needed for audit
            ]
        );

        return redirect()->back()->with('success', 'Absensi berhasil! Anda telah ditandai Hadir.');
    }
}

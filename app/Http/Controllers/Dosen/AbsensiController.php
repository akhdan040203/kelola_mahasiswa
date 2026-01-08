<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $courseId = $request->get('mata_kuliah_id');
        $course = MataKuliah::with(['absensiPertemuan' => function($q) {
            $q->orderBy('pertemuan_ke', 'desc');
        }])->findOrFail($courseId);
        
        if ($course->dosen_id != Auth::id()) {
            abort(403);
        }

        return view('dosen.absensi.index', compact('course'));
    }

    public function create(Request $request)
    {
        $courseId = $request->get('mata_kuliah_id');
        $course = MataKuliah::findOrFail($courseId);
        
        if ($course->dosen_id != Auth::id()) {
            abort(403);
        }

        // Suggest the next meeting number
        $nextMeeting = \App\Models\AbsensiPertemuan::where('mata_kuliah_id', $courseId)->max('pertemuan_ke') + 1;

        return view('dosen.absensi.create', compact('course', 'nextMeeting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'pertemuan_ke' => 'required|integer|min:1|max:16',
            'tanggal' => 'required|date',
        ]);

        $course = MataKuliah::findOrFail($request->mata_kuliah_id);
        if ($course->dosen_id != Auth::id()) abort(403);

        // 1. Create Meeting Session
        $pertemuan = \App\Models\AbsensiPertemuan::create([
            'mata_kuliah_id' => $request->mata_kuliah_id,
            'pertemuan_ke' => $request->pertemuan_ke,
            'tanggal' => $request->tanggal,
            'is_open' => true,
        ]);

        // 2. Pre-populate attendance records for ALL students in this course
        $students = Mahasiswa::whereHas('krs', function($q) use ($request) {
            $q->where('status', 'approved')
              ->whereHas('mataKuliah', function($q2) use ($request) {
                  $q2->where('mata_kuliah.id', $request->mata_kuliah_id);
              });
        })->get();

        foreach ($students as $student) {
            Absensi::create([
                'mata_kuliah_id' => $request->mata_kuliah_id,
                'absensi_pertemuan_id' => $pertemuan->id,
                'mahasiswa_id' => $student->id,
                'status' => null, // Waiting for student or teacher input
            ]);
        }

        return redirect()->route('dosen.absensi.show', $pertemuan->id)
            ->with('success', 'Sesi absensi berhasil dibuka. Mahasiswa sekarang dapat mengisi absen.');
    }

    public function show($id)
    {
        $pertemuan = \App\Models\AbsensiPertemuan::with(['mataKuliah', 'absensi.mahasiswa'])->findOrFail($id);
        if ($pertemuan->mataKuliah->dosen_id != Auth::id()) abort(403);

        return view('dosen.absensi.show', compact('pertemuan'));
    }

    public function update(Request $request, $id)
    {
        $pertemuan = \App\Models\AbsensiPertemuan::with('mataKuliah')->findOrFail($id);
        if ($pertemuan->mataKuliah->dosen_id != Auth::id()) abort(403);

        $request->validate([
            'absensi' => 'required|array',
            'absensi.*.id' => 'required|exists:absensi,id',
            'absensi.*.status' => 'required|in:hadir,izin,sakit,alpha',
            'absensi.*.keterangan' => 'nullable|string',
            'is_open' => 'nullable|boolean',
        ]);

        // Close/Open registration
        $pertemuan->update(['is_open' => $request->has('is_open')]);

        // Update bulk statuses
        foreach ($request->absensi as $data) {
            Absensi::where('id', $data['id'])->update([
                'status' => $data['status'],
                'keterangan' => $data['keterangan'] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Data absensi berhasil diperbarui.');
    }
}

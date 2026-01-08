<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MataKuliahController extends Controller
{
    public function index()
    {
        $dosenId = Auth::id();
        $assignedCourses = MataKuliah::where('dosen_id', $dosenId)->get();
            
        return view('dosen.mata-kuliah.index', compact('assignedCourses'));
    }

    public function show($id)
    {
        // Find the course where the lecturer is assigned
        $course = MataKuliah::with(['absensi', 'tugas'])->findOrFail($id);
            
        if ($course->dosen_id != Auth::id()) {
            abort(403);
        }

        // Get all students who have this course in their APPROVED KRS
        $students = Mahasiswa::whereHas('krs', function($q) use ($id) {
            $q->where('status', 'approved')
              ->whereHas('mataKuliah', function($q2) use ($id) {
                  $q2->where('mata_kuliah.id', $id);
              });
        })->get();

        return view('dosen.mata-kuliah.show', compact('course', 'students'));
    }

    public function edit($id)
    {
        $course = MataKuliah::findOrFail($id);

        if ($course->dosen_id != Auth::id()) {
            abort(403);
        }

        return view('dosen.mata-kuliah.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = MataKuliah::findOrFail($id);

        if ($course->dosen_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'required|string|max:50',
        ]);

        $course->update($validated);

        return redirect()->route('dosen.mata-kuliah.show', $id)
            ->with('success', 'Jadwal perkuliahan berhasil diperbarui!');
    }
}

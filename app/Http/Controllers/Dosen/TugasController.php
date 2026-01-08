<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $courseId = $request->get('mata_kuliah_id');
        $course = MataKuliah::findOrFail($courseId);
        
        if ($course->dosen_id != Auth::id()) {
            abort(403);
        }

        $tugas = Tugas::where('mata_kuliah_id', $courseId)->latest()->get();
        return view('dosen.tugas.index', compact('tugas', 'course'));
    }

    public function create(Request $request)
    {
        $courseId = $request->get('mata_kuliah_id');
        $course = MataKuliah::findOrFail($courseId);
        
        if ($course->dosen_id != Auth::id()) {
            abort(403);
        }

        return view('dosen.tugas.form', compact('course'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'deadline' => 'required|date_format:Y-m-d\TH:i',
        ]);

        Tugas::create($validated);

        return redirect()->route('dosen.mata-kuliah.show', $request->mata_kuliah_id)
            ->with('success', 'Tugas berhasil dibuat.');
    }

    public function edit($id)
    {
        $tugas = Tugas::with('mataKuliah')->findOrFail($id);
        
        if ($tugas->mataKuliah->dosen_id != Auth::id()) {
            abort(403);
        }

        return view('dosen.tugas.form', compact('tugas'));
    }

    public function update(Request $request, $id)
    {
        $tugas = Tugas::findOrFail($id);
        
        if ($tugas->mataKuliah->dosen_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'deadline' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $tugas->update($validated);

        return redirect()->route('dosen.mata-kuliah.show', $tugas->mata_kuliah_id)
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);
        $courseId = $tugas->mata_kuliah_id;
        
        if ($tugas->mataKuliah->dosen_id != Auth::id()) {
            abort(403);
        }

        $tugas->delete();

        return redirect()->route('dosen.mata-kuliah.show', $courseId)
            ->with('success', 'Tugas berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\User;
use Illuminate\Http\Request;

class KrsController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'submitted');
        $krs = Krs::with('mahasiswa')
            ->when($status != 'all', function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('admin.krs.index', compact('krs', 'status'));
    }

    public function show($id)
    {
        $krs = Krs::with(['mahasiswa', 'mataKuliah.dosen'])->findOrFail($id);
        return view('admin.krs.show', compact('krs'));
    }

    public function approve($id)
    {
        $krs = Krs::findOrFail($id);
        $krs->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'KRS mahasiswa berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string',
        ]);

        $krs = Krs::findOrFail($id);
        $krs->update([
            'status' => 'rejected',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->back()->with('success', 'KRS mahasiswa telah ditolak.');
    }
}

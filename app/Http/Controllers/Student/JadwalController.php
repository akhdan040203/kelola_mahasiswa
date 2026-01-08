<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        // Get all approved KRS
        $approvedKrs = $mahasiswa->krs()->where('status', 'approved')->get();

        if ($approvedKrs->isEmpty()) {
            return view('student.jadwal.index', [
                'groupedSchedule' => [],
                'message' => 'Anda belum memiliki KRS yang disetujui untuk semester ini.'
            ]);
        }

        // Aggregate all subjects from all approved KRS
        $subjects = collect();
        foreach ($approvedKrs as $krs) {
            $krsSubjects = $krs->mataKuliah()
                ->with(['dosen', 'absensi' => function($q) use ($mahasiswa) {
                    $q->where('mahasiswa_id', $mahasiswa->id);
                }, 'tugas'])
                ->get();
            $subjects = $subjects->merge($krsSubjects);
        }

        // Ensure unique subjects by ID just in case
        $subjects = $subjects->unique('id')->map(function($subject) use ($mahasiswa) {
            // Enrich subject with attendance summary
            $totalMeetings = $subject->absensiPertemuan()->count();
            $attendedMeetings = $subject->absensi()->where('mahasiswa_id', $mahasiswa->id)->where('status', 'hadir')->count();
            
            $subject->attendance_summary = [
                'total' => $totalMeetings,
                'attended' => $attendedMeetings,
                'percent' => $totalMeetings > 0 ? round(($attendedMeetings / $totalMeetings) * 100) : 0
            ];

            // Enrich subject with assignment summary
            $subject->assignment_count = $subject->tugas()->count();
            
            return $subject;
        });

        // Check if there are any subjects at all
        if ($subjects->isEmpty()) {
            return view('student.jadwal.index', [
                'groupedSchedule' => [],
                'message' => 'Tidak ada mata kuliah dalam KRS Anda.'
            ]);
        }

        // Group by day
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $groupedSchedule = [];
        
        foreach ($days as $day) {
            $groupedSchedule[$day] = $subjects->where('hari', $day)->sortBy('jam_mulai');
        }

        // Add unscheduled subjects
        $unscheduled = $subjects->whereNull('hari');
        if ($unscheduled->count() > 0) {
            $groupedSchedule['Belum Terjadwal'] = $unscheduled;
            $days[] = 'Belum Terjadwal';
        }

        return view('student.jadwal.index', compact('groupedSchedule', 'days'));
    }
}

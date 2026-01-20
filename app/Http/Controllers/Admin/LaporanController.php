<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Area;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data untuk filter dropdown
        $areas = Area::orderBy('name')->get();
        $shifts = Shift::all();
        $departments = User::select('department')->distinct()->pluck('department');

        // Query dasar
        $query = Attendance::with(['employee', 'session.supervisor', 'session.area', 'session.shift']);

        // Filter berdasarkan input
        if ($request->filled('tanggal_dari')) {
            $query->whereHas('session', function($q) use ($request) {
                $q->where('session_date', '>=', $request->tanggal_dari);
            });
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereHas('session', function($q) use ($request) {
                $q->where('session_date', '<=', $request->tanggal_sampai);
            });
        }

        if ($request->filled('shift_id')) {
            $query->whereHas('session', function($q) use ($request) {
                $q->where('shift_id', $request->shift_id);
            });
        }

        if ($request->filled('area_id')) {
            $query->whereHas('session', function($q) use ($request) {
                $q->where('area_id', $request->area_id);
            });
        }

        if ($request->filled('department')) {
            $query->whereHas('employee', function($q) use ($request) {
                $q->where('department', $request->department);
            });
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Hitung statistik
        $statistik = [
            'total' => (clone $query)->count(),
            'hadir' => (clone $query)->where('status', 'HADIR')->count(),
            'sakit' => (clone $query)->where('status', 'SAKIT')->count(),
            'izin' => (clone $query)->where('status', 'IZIN')->count(),
            'cuti' => (clone $query)->where('status', 'CUTI')->count(),
            'alfa' => (clone $query)->where('status', 'ALFA')->count(),
        ];

        // Pagination (20 per halaman)
        $attendances = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.laporan.index', [
            'attendances' => $attendances,
            'areas' => $areas,
            'shifts' => $shifts,
            'departments' => $departments,
            'statistik' => $statistik,
            'filters' => $request->all(),
        ]);
    }
}
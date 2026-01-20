<?php

namespace App\Http\Controllers\Pengawas;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    /**
     * Tampilkan form absensi
     */
    public function create()
    {
        $pengawas = auth()->user();
        
        // Ambil karyawan yang sesuai dengan area pengawas
        // Jika pengawas punya area, ambil karyawan di area tersebut
        // Jika pengawas non-area, ambil semua karyawan non-area
        
        if ($pengawas->area_id) {
            // Pengawas area-based: ambil karyawan di area yang sama
            $karyawanList = User::role('Karyawan')
                ->where('area_id', $pengawas->area_id)
                ->where('shift_id', $pengawas->shift_id)
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        } else {
            // Pengawas non-area: ambil karyawan non-area
            $karyawanList = User::role('Karyawan')
                ->where('employee_type', 'NON_AREA')
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        }

        return view('pengawas.absensi.create', [
            'pengawas' => $pengawas,
            'karyawanList' => $karyawanList,
        ]);
    }

    /**
     * Simpan data absensi
     */
    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'shift_id' => 'required|exists:shifts,id',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'karyawan_ids' => 'required|array|min:1',
        'karyawan_ids.*' => 'exists:users,id',
        'karyawan_hadir' => 'nullable|array',
        'status.*' => 'nullable|in:SAKIT,IZIN,CUTI,ALFA',
        'notes.*' => 'nullable|string|max:500',
    ]);

    DB::beginTransaction();

    try {
        $pengawas = auth()->user();

      // Upload foto (jika ada)
$photoPath = null;
if ($request->hasFile('photo')) {
    $photoPath = $request->file('photo')->store('attendance-photos', 'public');
}

// Buat attendance session
$session = AttendanceSession::create([
    'supervisor_id' => $pengawas->id,
    'area_id' => $pengawas->area_id,
    'shift_id' => $request->shift_id,
    'photo_path' => $photoPath, // nullable, bisa NULL jika tidak upload
    'latitude' => $request->latitude ?? 0,
    'longitude' => $request->longitude ?? 0,
    'session_date' => now()->toDateString(),
    'session_time' => now()->toTimeString(),
]);

        // Loop semua karyawan yang ada di form
        foreach ($request->karyawan_ids as $employeeId) {
            
            // Cek apakah karyawan ini dicentang HADIR
            $isHadir = isset($request->karyawan_hadir[$employeeId]);

            if ($isHadir) {
                // Karyawan HADIR
                Attendance::create([
                    'attendance_session_id' => $session->id,
                    'employee_id' => $employeeId,
                    'status' => 'HADIR',
                    'notes' => null,
                ]);
            } else {
                // Karyawan TIDAK HADIR
                // Ambil status dari dropdown (SAKIT/IZIN/CUTI/ALFA)
                $status = $request->input("status.{$employeeId}", 'ALFA');
                $notes = $request->input("notes.{$employeeId}");

                Attendance::create([
                    'attendance_session_id' => $session->id,
                    'employee_id' => $employeeId,
                    'status' => $status,
                    'notes' => $notes,
                ]);
            }
        }

        DB::commit();

        return redirect()->route('pengawas.dashboard')
            ->with('success', 'Absensi berhasil disimpan! Total karyawan: ' . count($request->karyawan_ids));

    } catch (\Exception $e) {
        DB::rollBack();

        // Hapus foto jika ada error
        if (isset($photoPath)) {
            Storage::disk('public')->delete($photoPath);
        }

        return back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
}
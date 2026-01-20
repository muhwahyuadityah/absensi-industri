<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        $karyawan = auth()->user();
        
        // Ambil riwayat absensi karyawan ini (pagination 20 per halaman)
        $riwayat = $karyawan->attendances()
            ->with(['session.supervisor', 'session.area', 'session.shift'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('karyawan.riwayat', [
            'karyawan' => $karyawan,
            'riwayat' => $riwayat,
        ]);
    }
}
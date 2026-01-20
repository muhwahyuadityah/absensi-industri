<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Redirect ke dashboard sesuai role
        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('Manager')) {
            return redirect()->route('manager.dashboard');
        } elseif ($user->hasRole('Pengawas')) {
            return redirect()->route('pengawas.dashboard');
        } elseif ($user->hasRole('Karyawan')) {
            return redirect()->route('karyawan.dashboard');
        }

        // Jika tidak punya role apapun
        abort(403, 'Anda tidak memiliki role yang valid.');
    }

    public function admin()
    {
        return view('dashboard.admin');
    }

    public function manager()
    {
        return view('dashboard.manager');
    }

    public function pengawas()
    {
        return view('dashboard.pengawas');
    }

    public function karyawan()
    {
        return view('dashboard.karyawan');
    }
}
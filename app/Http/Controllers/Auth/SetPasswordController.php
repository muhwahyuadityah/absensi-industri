<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SetPasswordController extends Controller
{
    /**
     * Tampilkan form set password
     */
    public function show(Request $request, $id)
    {
        // Validasi signature URL (dari email verification link)
        if (!$request->hasValidSignature()) {
            abort(403, 'Link verifikasi tidak valid atau sudah kadaluarsa.');
        }

        $user = User::findOrFail($id);

        // Jika sudah terverifikasi, redirect ke login
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('info', 'Email Anda sudah terverifikasi. Silakan login.');
        }

        return view('auth.set-password', compact('user'));
    }

    /**
     * Proses set password
     */
    public function store(Request $request, $id)
    {
        // Validasi signature URL
        if (!$request->hasValidSignature()) {
            abort(403, 'Link verifikasi tidak valid atau sudah kadaluarsa.');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);

        // Set password & mark email as verified
        $user->password = Hash::make($request->password);
        $user->email_verified_at = now();
        $user->save();

        // Trigger verified event
        event(new Verified($user));

        return redirect()->route('login')->with('success', 'Akun Anda telah diaktifkan! Silakan login dengan email & password yang baru dibuat.');
    }
}
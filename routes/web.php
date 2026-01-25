<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Route set password (setelah klik link verifikasi email)
Route::get('/set-password/{id}', [App\Http\Controllers\Auth\SetPasswordController::class, 'show'])
    ->name('password.set');
Route::post('/set-password/{id}', [App\Http\Controllers\Auth\SetPasswordController::class, 'store'])
    ->name('password.set.store');

// Route setelah login
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard utama (redirect otomatis sesuai role)
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/profile/photo', [App\Http\Controllers\ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile/photo', [App\Http\Controllers\ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');

    // Dashboard per role
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/admin/dashboard', [App\Http\Controllers\DashboardController::class, 'admin'])->name('admin.dashboard');

        Route::get('/admin/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('admin.laporan');
        Route::get('/admin/laporan/export', [App\Http\Controllers\Admin\LaporanController::class, 'export'])->name('admin.laporan.export');

     Route::resource('admin/users', App\Http\Controllers\Manager\UserManagementController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    Route::post('/admin/users/{id}/restore', [App\Http\Controllers\Manager\UserManagementController::class, 'restore'])->name('admin.users.restore');

    Route::post('/admin/users/{id}/resend-verification', function($id) {
        $user = \App\Models\User::findOrFail($id);
        
        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'User ini sudah terverifikasi.');
        }
        
        $user->sendEmailVerificationNotification();
        
        return back()->with('success', 'Email verifikasi berhasil dikirim ulang ke ' . $user->email);
    })->name('verification.resend.manual');

});

    Route::middleware(['role:Manager'])->group(function () {
        Route::get('/manager/dashboard', [App\Http\Controllers\DashboardController::class, 'manager'])->name('manager.dashboard');

        // Manager bisa akses laporan (menggunakan controller yang sama dengan Admin)
    Route::get('/manager/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('manager.laporan');
    Route::get('/manager/laporan/export', [App\Http\Controllers\Admin\LaporanController::class, 'export'])->name('manager.laporan.export');
    // User Management
    Route::resource('manager/users', App\Http\Controllers\Manager\UserManagementController::class)->names([
        'index' => 'manager.users.index',
        'create' => 'manager.users.create',
        'store' => 'manager.users.store',
        'edit' => 'manager.users.edit',
        'update' => 'manager.users.update',
        'destroy' => 'manager.users.destroy',
    ]);
    Route::post('/manager/users/{id}/restore', [App\Http\Controllers\Manager\UserManagementController::class, 'restore'])->name('manager.users.restore');

    Route::post('/manager/users/{id}/resend-verification', function($id) {
        $user = \App\Models\User::findOrFail($id);
        
        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'User ini sudah terverifikasi.');
        }
        
        $user->sendEmailVerificationNotification();
        
        return back()->with('success', 'Email verifikasi berhasil dikirim ulang ke ' . $user->email);
    })->name('verification.resend.manual');
    });

    Route::middleware(['role:Pengawas'])->group(function () {
        Route::get('/pengawas/dashboard', [App\Http\Controllers\DashboardController::class, 'pengawas'])->name('pengawas.dashboard');

        Route::get('/pengawas/absensi/create', [App\Http\Controllers\Pengawas\AbsensiController::class, 'create'])->name('pengawas.absensi.create');
        Route::post('/pengawas/absensi/store', [App\Http\Controllers\Pengawas\AbsensiController::class, 'store'])->name('pengawas.absensi.store');
    });

    Route::middleware(['role:Karyawan'])->group(function () {
        Route::get('/karyawan/dashboard', [App\Http\Controllers\DashboardController::class, 'karyawan'])->name('karyawan.dashboard');

         // Route riwayat absensi
    Route::get('/karyawan/riwayat', [App\Http\Controllers\Karyawan\RiwayatController::class, 'index'])->name('karyawan.riwayat');
    });
});


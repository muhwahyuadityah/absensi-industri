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

// Route setelah login
Route::middleware(['auth'])->group(function () {
    // Dashboard utama (redirect otomatis sesuai role)
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Dashboard per role
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/admin/dashboard', [App\Http\Controllers\DashboardController::class, 'admin'])->name('admin.dashboard');
    });

    Route::middleware(['role:Manager'])->group(function () {
        Route::get('/manager/dashboard', [App\Http\Controllers\DashboardController::class, 'manager'])->name('manager.dashboard');
    });

    Route::middleware(['role:Pengawas'])->group(function () {
        Route::get('/pengawas/dashboard', [App\Http\Controllers\DashboardController::class, 'pengawas'])->name('pengawas.dashboard');
    });

    Route::middleware(['role:Karyawan'])->group(function () {
        Route::get('/karyawan/dashboard', [App\Http\Controllers\DashboardController::class, 'karyawan'])->name('karyawan.dashboard');
    });
});

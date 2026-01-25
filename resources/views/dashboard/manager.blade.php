<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Manager') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Selamat Datang, Manager!</h3>
                    <p class="mb-2">Anda login sebagai: <strong>{{ auth()->user()->name }}</strong></p>
                    <p class="mb-2">Email: <strong>{{ auth()->user()->email }}</strong></p>
                    <p class="mb-2">Role: <strong>{{ auth()->user()->roles->first()->name }}</strong></p>
                    
                    <div class="mt-6 p-4 bg-green-50 rounded">
                        <p class="text-sm text-gray-600">
                            Sebagai Manager, Anda dapat:
                        </p>
                        <ul class="list-disc list-inside mt-2 text-sm text-gray-700">
                            <li>Lihat laporan absensi semua area</li>
                            <li>Export data ke Excel</li>
                            <li>Monitoring performa karyawan</li>
                            <li>Approve koreksi absensi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Notifikasi User Pending Verification -->
@php
    $pendingUsers = \App\Models\User::whereNull('email_verified_at')->count();
@endphp

@if($pendingUsers > 0)
    <div class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 rounded">
        <p class="font-bold">⚠️ Ada {{ $pendingUsers }} user yang belum verifikasi email</p>
        <p class="text-sm mt-1">Klik "Kelola User" untuk melihat detail & kirim ulang email verifikasi.</p>
    </div>
@endif

<div class="mt-6 flex gap-4">
        <div class="mt-6 flex gap-4">
    <a href="{{ route('manager.laporan') }}" 
       class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
        📊 Lihat Laporan Absensi
    </a>
    <a href="{{ route('manager.users.index') }}" 
       class="inline-block px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition">
        👥 Kelola User
    </a>
</div>
    </div>
</x-app-layout>
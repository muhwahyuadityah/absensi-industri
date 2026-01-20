<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Selamat Datang, {{ auth()->user()->name }}!</h3>
                    <p class="mb-2">Email: <strong>{{ auth()->user()->email }}</strong></p>
                    <p class="mb-2">NIK: <strong>{{ auth()->user()->employee_number }}</strong></p>
                    <p class="mb-2">Jabatan: <strong>{{ auth()->user()->position }}</strong></p>
                    <p class="mb-2">Departemen: <strong>{{ auth()->user()->department }}</strong></p>
                    <p class="mb-2">Area: <strong>{{ auth()->user()->area ? auth()->user()->area->name : 'Non-Area (Mobile)' }}</strong></p>
                    <p class="mb-2">Shift: <strong>{{ auth()->user()->shift ? auth()->user()->shift->name : '-' }}</strong></p>
                    
                    <div class="mt-6 p-4 bg-gray-50 rounded">
                        <p class="text-sm text-gray-600">
                            Anda dapat:
                        </p>
                        <ul class="list-disc list-inside mt-2 text-sm text-gray-700">
                            <li>Melihat riwayat absensi Anda</li>
                            <li>Melihat detail waktu check-in</li>
                            <li>Melihat foto absensi</li>
                            <li>Download laporan kehadiran bulanan</li>
                        </ul>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('karyawan.riwayat') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Lihat Riwayat Absensi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
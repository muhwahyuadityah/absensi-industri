<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Pengawas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- PESAN SUCCESS -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow" role="alert">
                    <div class="flex items-center">
                        <div class="py-1">
                            <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">Berhasil!</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- PESAN ERROR -->
            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow" role="alert">
                    <div class="flex items-center">
                        <div class="py-1">
                            <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 5h2v6H9V5zm0 8h2v2H9v-2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">Error!</p>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- KONTEN DASHBOARD -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Selamat Datang, Pengawas!</h3>
                    <p class="mb-2">Anda login sebagai: <strong>{{ auth()->user()->name }}</strong></p>
                    <p class="mb-2">Email: <strong>{{ auth()->user()->email }}</strong></p>
                    <p class="mb-2">Role: <strong>{{ auth()->user()->roles->first()->name }}</strong></p>
                    <p class="mb-2">Area: <strong>{{ auth()->user()->area ? auth()->user()->area->name : 'Non-Area' }}</strong></p>
                    <p class="mb-2">Shift: <strong>{{ auth()->user()->shift ? auth()->user()->shift->name : '-' }}</strong></p>
                    
                    <div class="mt-6 p-4 bg-yellow-50 rounded">
                        <p class="text-sm text-gray-600">
                            Sebagai Pengawas, tugas Anda:
                        </p>
                        <ul class="list-disc list-inside mt-2 text-sm text-gray-700">
                            <li>Melakukan absensi karyawan di area Anda</li>
                            <li>Foto grup karyawan yang hadir</li>
                            <li>Tandai karyawan yang tidak hadir (Sakit/Izin/Cuti/Alfa)</li>
                            <li>Lihat riwayat absensi area Anda</li>
                        </ul>
                    </div>

                    <!-- TOMBOL BUAT ABSENSI -->
                    <div class="mt-6">
                        <a href="{{ route('pengawas.absensi.create') }}" 
                           class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition duration-150">
                            <span class="text-xl mr-2">📋</span>
                            <span>Buat Absensi Baru</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
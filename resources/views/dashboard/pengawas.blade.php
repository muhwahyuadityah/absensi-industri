<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pengawas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

                    <div class="mt-6">
                        <a href="{{ route('pengawas.absensi.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Buat Absensi Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
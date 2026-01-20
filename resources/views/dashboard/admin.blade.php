<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Selamat Datang, Admin!</h3>
                    <p class="mb-2">Anda login sebagai: <strong>{{ auth()->user()->name }}</strong></p>
                    <p class="mb-2">Email: <strong>{{ auth()->user()->email }}</strong></p>
                    <p class="mb-2">Role: <strong>{{ auth()->user()->roles->first()->name }}</strong></p>
                    
                    <div class="mt-6 p-4 bg-blue-50 rounded">
                        <p class="text-sm text-gray-600">
                            Sebagai Admin, Anda memiliki akses penuh ke sistem:
                        </p>
                        <ul class="list-disc list-inside mt-2 text-sm text-gray-700">
                            <li>Kelola semua user</li>
                            <li>Kelola master data</li>
                            <li>Lihat semua laporan absensi</li>
                            <li>Koreksi data absensi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
    <div class="mt-6">
    <a href="{{ route('admin.laporan') }}" 
       class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
        Lihat Laporan Absensi
    </a>
</div>
    </div>

</x-app-layout>
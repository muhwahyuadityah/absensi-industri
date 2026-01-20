<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Absensi Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Info Karyawan -->
                    <div class="mb-6 p-4 bg-gray-50 rounded">
                        <h3 class="font-bold mb-2">Informasi Karyawan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                            <p>Nama: <strong>{{ $karyawan->name }}</strong></p>
                            <p>NIK: <strong>{{ $karyawan->employee_number }}</strong></p>
                            <p>Jabatan: <strong>{{ $karyawan->position }}</strong></p>
                            <p>Departemen: <strong>{{ $karyawan->department }}</strong></p>
                            <p>Area: <strong>{{ $karyawan->area ? $karyawan->area->name : 'Non-Area (Mobile)' }}</strong></p>
                            <p>Shift: <strong>{{ $karyawan->shift ? $karyawan->shift->name : '-' }}</strong></p>
                        </div>
                    </div>

                    <!-- Statistik Singkat -->
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-green-50 p-4 rounded">
                            <p class="text-sm text-gray-600">Total Hadir</p>
                            <p class="text-2xl font-bold text-green-700">{{ $karyawan->attendances()->where('status', 'HADIR')->count() }}</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded">
                            <p class="text-sm text-gray-600">Sakit</p>
                            <p class="text-2xl font-bold text-yellow-700">{{ $karyawan->attendances()->where('status', 'SAKIT')->count() }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded">
                            <p class="text-sm text-gray-600">Izin/Cuti</p>
                            <p class="text-2xl font-bold text-blue-700">{{ $karyawan->attendances()->whereIn('status', ['IZIN', 'CUTI'])->count() }}</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded">
                            <p class="text-sm text-gray-600">Alfa</p>
                            <p class="text-2xl font-bold text-red-700">{{ $karyawan->attendances()->where('status', 'ALFA')->count() }}</p>
                        </div>
                    </div>

                    <!-- Tabel Riwayat -->
                    @if($riwayat->count() == 0)
                        <div class="p-8 text-center bg-gray-50 rounded">
                            <p class="text-gray-600">📋 Belum ada riwayat absensi.</p>
                            <p class="text-sm text-gray-500 mt-2">Riwayat absensi akan muncul setelah pengawas melakukan absensi.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Shift
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jam Absen
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pengawas
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Area
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Catatan
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($riwayat as $absen)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $absen->session->session_date->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <div>{{ $absen->session->shift->name }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ \Carbon\Carbon::parse($absen->session->shift->start_time)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($absen->session->shift->end_time)->format('H:i') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                {{ \Carbon\Carbon::parse($absen->session->session_time)->format('H:i:s') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($absen->status == 'HADIR')
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        ✅ {{ $absen->status }}
                                                    </span>
                                                @elseif($absen->status == 'SAKIT')
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        🤒 {{ $absen->status }}
                                                    </span>
                                                @elseif($absen->status == 'IZIN')
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        📝 {{ $absen->status }}
                                                    </span>
                                                @elseif($absen->status == 'CUTI')
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                        🏖️ {{ $absen->status }}
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        ❌ {{ $absen->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $absen->session->supervisor->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $absen->session->area ? $absen->session->area->name : 'Non-Area' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                {{ $absen->notes ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if($absen->session->photo_path)
                                                    <a href="{{ asset('storage/' . $absen->session->photo_path) }}" 
                                                       target="_blank"
                                                       class="text-blue-600 hover:text-blue-800 font-medium">
                                                        📷 Lihat Foto
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $riwayat->links() }}
                        </div>
                    @endif

                    <!-- Tombol Kembali -->
                    <div class="mt-6">
                        <a href="{{ route('karyawan.dashboard') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            ← Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Absensi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- FORM FILTER -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Filter Laporan</h3>
                    
                    <form method="GET" action="{{ route('admin.laporan') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            
                            <!-- Tanggal Dari -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dari</label>
                                <input type="date" name="tanggal_dari" value="{{ $filters['tanggal_dari'] ?? '' }}" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Tanggal Sampai -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Sampai</label>
                                <input type="date" name="tanggal_sampai" value="{{ $filters['tanggal_sampai'] ?? '' }}" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Shift -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Shift</label>
                                <select name="shift_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Shift</option>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}" {{ ($filters['shift_id'] ?? '') == $shift->id ? 'selected' : '' }}>
                                            {{ $shift->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Area -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Area IMIP</label>
                                <select name="area_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Area</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}" {{ ($filters['area_id'] ?? '') == $area->id ? 'selected' : '' }}>
                                            {{ $area->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Departemen -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Departemen</label>
                                <select name="department" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Departemen</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept }}" {{ ($filters['department'] ?? '') == $dept ? 'selected' : '' }}>
                                            {{ $dept }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Status</option>
                                    <option value="HADIR" {{ ($filters['status'] ?? '') == 'HADIR' ? 'selected' : '' }}>Hadir</option>
                                    <option value="SAKIT" {{ ($filters['status'] ?? '') == 'SAKIT' ? 'selected' : '' }}>Sakit</option>
                                    <option value="IZIN" {{ ($filters['status'] ?? '') == 'IZIN' ? 'selected' : '' }}>Izin</option>
                                    <option value="CUTI" {{ ($filters['status'] ?? '') == 'CUTI' ? 'selected' : '' }}>Cuti</option>
                                    <option value="ALFA" {{ ($filters['status'] ?? '') == 'ALFA' ? 'selected' : '' }}>Alfa</option>
                                </select>
                            </div>
                        </div>

                       <div class="flex gap-4">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition shadow-lg">
                        🔍 Filter Data
                    </button>
                    <a href="{{ route('admin.laporan') }}" class="px-6 py-3 bg-gray-400 text-white rounded-lg font-bold hover:bg-gray-500 transition shadow-lg">
                        🔄 Reset Filter
                    </a>
                </div>
                    </form>
                </div>
            </div>

            <!-- STATISTIK -->
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-sm text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $statistik['total'] }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg shadow">
                    <p class="text-sm text-gray-600">Hadir</p>
                    <p class="text-2xl font-bold text-green-700">{{ $statistik['hadir'] }}</p>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg shadow">
                    <p class="text-sm text-gray-600">Sakit</p>
                    <p class="text-2xl font-bold text-yellow-700">{{ $statistik['sakit'] }}</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg shadow">
                    <p class="text-sm text-gray-600">Izin</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $statistik['izin'] }}</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg shadow">
                    <p class="text-sm text-gray-600">Cuti</p>
                    <p class="text-2xl font-bold text-purple-700">{{ $statistik['cuti'] }}</p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg shadow">
                    <p class="text-sm text-gray-600">Alfa</p>
                    <p class="text-2xl font-bold text-red-700">{{ $statistik['alfa'] }}</p>
                </div>
            </div>

            <!-- TABEL DATA -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Data Absensi ({{ $attendances->total() }} record)</h3>
                        <button class="px-6 py-3 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 transition shadow-lg">
                            📊 Export Excel
                        </button>
                    </div>

                    @if($attendances->count() == 0)
                        <p class="text-center text-gray-600 py-8">Tidak ada data absensi. Gunakan filter untuk mencari data.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Shift</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Karyawan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIK</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Departemen</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Area</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengawas</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($attendances as $att)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $att->session->session_date->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $att->session->shift->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                {{ $att->employee->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $att->employee->employee_number }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $att->employee->department }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $att->session->area ? $att->session->area->name : 'Non-Area' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ \Carbon\Carbon::parse($att->session->session_time)->format('H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($att->status == 'HADIR')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">HADIR</span>
                                                @elseif($att->status == 'SAKIT')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">SAKIT</span>
                                                @elseif($att->status == 'IZIN')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">IZIN</span>
                                                @elseif($att->status == 'CUTI')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">CUTI</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">ALFA</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $att->session->supervisor->name }}
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                {{ $att->notes ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $attendances->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
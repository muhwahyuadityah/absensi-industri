<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Absensi Baru
        </h2>
    </x-slot>

   <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 p-4 bg-blue-50 rounded">
                        <h3 class="font-bold mb-2">Informasi Pengawas</h3>
                        <p class="text-sm">Nama: <strong>{{ $pengawas->name }}</strong></p>
                        <p class="text-sm">Area: <strong>{{ $pengawas->area ? $pengawas->area->name : 'Non-Area' }}</strong></p>
                        <p class="text-sm">Shift Default: <strong>{{ $pengawas->shift ? $pengawas->shift->name : '-' }}</strong></p>
                        <p class="text-sm">Jumlah Karyawan: <strong>{{ $karyawanList->count() }} orang</strong></p>
                    </div>

                    @if($karyawanList->count() == 0)
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded">
                            <p class="text-yellow-800">Tidak ada karyawan di area/shift Anda saat ini.</p>
                        </div>
                    @else
                        <form action="{{ route('pengawas.absensi.store') }}" method="POST" enctype="multipart/form-data" id="formAbsensi">
                            @csrf

                            <!-- Pilih Shift -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Shift</label>
                                <select name="shift_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Pilih Shift --</option>
                                    @foreach(\App\Models\Shift::all() as $shift)
                                        <option value="{{ $shift->id }}" {{ old('shift_id', $pengawas->shift_id) == $shift->id ? 'selected' : '' }}>
                                            {{ $shift->name }} ({{ $shift->start_time }} - {{ $shift->end_time }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Daftar Karyawan -->
                            <div class="mb-6">
                                <h3 class="text-lg font-bold mb-4">Tandai Karyawan yang Hadir</h3>
                                
                               <div class="space-y-2 max-h-96 overflow-y-auto border border-gray-200 rounded p-4">
                                    @foreach($karyawanList as $karyawan)
                                        <div class="flex items-center p-3 hover:bg-gray-50 rounded" x-data="{ hadir: true }">
                                            <!-- Hidden input untuk ID karyawan (SELALU DIKIRIM) -->
                                            <input type="hidden" name="karyawan_ids[]" value="{{ $karyawan->id }}">
                                            
                                            <!-- Checkbox untuk tandai HADIR -->
                                            <input 
                                                type="checkbox" 
                                                name="karyawan_hadir[{{ $karyawan->id }}]"
                                                value="1"
                                                x-model="hadir"
                                                class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                checked
                                            >
                                            
                                            <label class="ml-3 flex-1">
                                                <span class="block font-medium text-gray-900">{{ $karyawan->name }}</span>
                                                <span class="block text-sm text-gray-500">{{ $karyawan->employee_number }} - {{ $karyawan->position }}</span>
                                            </label>

                                            <!-- Form untuk yang TIDAK HADIR -->
                                            <div x-show="!hadir" class="ml-4 flex-1" x-cloak>
                                                <select name="status[{{ $karyawan->id }}]" class="text-sm border-gray-300 rounded mr-2" required>
                                                    <option value="SAKIT">Sakit</option>
                                                    <option value="IZIN">Izin</option>
                                                    <option value="CUTI">Cuti</option>
                                                    <option value="ALFA">Alfa</option>
                                                </select>
                                                <input 
                                                    type="text" 
                                                    name="notes[{{ $karyawan->id }}]" 
                                                    placeholder="Catatan (opsional)"
                                                    class="text-sm border-gray-300 rounded w-48"
                                                >
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                           <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Foto Grup Karyawan yang Hadir 
                                <span class="text-sm text-gray-500 font-normal">(Opsional jika semua tidak hadir)</span>
                            </label>
                            <input 
                                type="file" 
                                name="photo" 
                                accept="image/*"
                                capture="environment"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                onchange="previewImage(event)"
                            >
                            <img id="preview" class="mt-4 max-w-md rounded hidden">
                            <p class="mt-2 text-xs text-gray-600">
                                💡 Foto wajib jika ada karyawan yang hadir. Jika semua tidak hadir (Sakit/Izin/Cuti/Alfa), foto tidak wajib.
                            </p>
                        </div>

                            <!-- GPS Location (Hidden, auto-detect) -->
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">

                            <div id="gps-status" class="mb-6 p-4 bg-gray-50 rounded">
                                <p class="text-sm text-gray-600">🔍 Mendeteksi lokasi GPS...</p>
                            </div>

                            <!-- Submit Button -->
                           <div class="flex gap-4">
                                <button 
                                    type="submit" 
                                    id="btnSubmit"
                                    class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow font-semibold hover:bg-blue-700 transition duration-150" >
                                    <span class="text-xl mr-2">💾</span>
                                    <span>Simpan Absensi</span>
                                </button>
                                <a href="{{ route('pengawas.dashboard') }}" 
                                class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg shadow font-semibold hover:bg-gray-400 transition duration-150">
                                    <span class="text-xl mr-2">❌</span>
                                    <span>Batal</span>
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

   <script>
    // Preview gambar
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    // Auto-detect GPS (OPTIONAL - tidak memblokir submit)
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
                
                document.getElementById('gps-status').innerHTML = `
                    <p class="text-sm text-green-700">
                        ✅ Lokasi terdeteksi: ${position.coords.latitude.toFixed(6)}, ${position.coords.longitude.toFixed(6)}
                    </p>
                `;
            },
            function(error) {
                // Jika GPS gagal, pakai koordinat default (untuk testing)
                document.getElementById('latitude').value = 0;
                document.getElementById('longitude').value = 0;
                
                document.getElementById('gps-status').innerHTML = `
                    <p class="text-sm text-yellow-700">
                        ⚠️ GPS tidak terdeteksi. Menggunakan koordinat default untuk testing.
                    </p>
                    <p class="text-xs text-gray-600 mt-2">
                        Error: ${error.message}
                    </p>
                `;
            }
        );
    } else {
        // Browser tidak support GPS, pakai koordinat default
        document.getElementById('latitude').value = 0;
        document.getElementById('longitude').value = 0;
        
        document.getElementById('gps-status').innerHTML = `
            <p class="text-sm text-yellow-700">
                ⚠️ Browser tidak mendukung GPS. Menggunakan koordinat default untuk testing.
            </p>
        `;
    }
</script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- ERROR VALIDATION -->
            @if($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow">
                    <p class="font-bold mb-2">Terdapat kesalahan:</p>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ auth()->user()->hasRole('Manager') ? route('manager.users.update', $user) : route('admin.users.update', $user) }}" x-data="userForm()">
                        @csrf
                        @method('PUT')

                        <!-- Informasi Dasar -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4 pb-2 border-b">Informasi Dasar</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Nama Lengkap -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @if(!$user->email_verified_at)
                                        <p class="text-xs text-yellow-600 mt-1">⚠️ Email belum diverifikasi</p>
                                    @else
                                        <p class="text-xs text-green-600 mt-1">✓ Email sudah diverifikasi</p>
                                    @endif
                                </div>

                                <!-- NIK -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">NIK (Nomor Induk Karyawan) *</label>
                                    <input type="text" name="employee_number" value="{{ old('employee_number', $user->employee_number) }}" required
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <!-- Role (read-only) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                    <input type="text" value="{{ $user->roles->first()->name ?? '-' }}" disabled
                                           class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100">
                                    <p class="text-xs text-gray-500 mt-1">Role tidak dapat diubah</p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Pekerjaan -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4 pb-2 border-b">Informasi Pekerjaan</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Departemen -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Departemen *</label>
                                    <input type="text" name="department" value="{{ old('department', $user->department) }}" required
                                           list="departments"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <datalist id="departments">
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept }}">
                                        @endforeach
                                    </datalist>
                                </div>

                                <!-- Jabatan -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan *</label>
                                    <input type="text" name="position" value="{{ old('position', $user->position) }}" required
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <!-- Tipe Employee -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Karyawan *</label>
                                    <select name="employee_type" x-model="employeeType" required
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="AREA_BASED" {{ old('employee_type', $user->employee_type) == 'AREA_BASED' ? 'selected' : '' }}>
                                            Area Based (Produksi)
                                        </option>
                                        <option value="NON_AREA" {{ old('employee_type', $user->employee_type) == 'NON_AREA' ? 'selected' : '' }}>
                                            Non-Area (Mobile/Support)
                                        </option>
                                    </select>
                                </div>

                                <!-- Area -->
                                <div x-show="employeeType === 'AREA_BASED'">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Area IMIP *</label>
                                    <select name="area_id" :required="employeeType === 'AREA_BASED'"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">-- Pilih Area --</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}" {{ old('area_id', $user->area_id) == $area->id ? 'selected' : '' }}>
                                                {{ $area->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Shift -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Shift Default</label>
                                    <select name="shift_id"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">-- Pilih Shift (Opsional) --</option>
                                        @foreach($shifts as $shift)
                                            <option value="{{ $shift->id }}" {{ old('shift_id', $user->shift_id) == $shift->id ? 'selected' : '' }}>
                                                {{ $shift->name }} ({{ $shift->start_time }} - {{ $shift->end_time }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status Aktif -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Akun *</label>
                                    <select name="is_active" required
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">User tidak aktif tidak dapat login</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-4">
                            <button type="submit" 
                                    class="px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition shadow">
                                💾 Update User
                            </button>
                            <a href="{{ auth()->user()->hasRole('Manager') ? route('manager.users.index') : route('admin.users.index') }}" 
                               class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg font-bold hover:bg-gray-400 transition shadow">
                                ❌ Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function userForm() {
            return {
                employeeType: '{{ old("employee_type", $user->employee_type) }}'
            }
        }
    </script>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- PESAN SUCCESS -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ERROR VALIDATION -->
            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow">
                    <p class="font-bold mb-2">Terdapat kesalahan:</p>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- FOTO PROFIL -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 pb-2 border-b">Foto Profil</h3>
                    
                    <div class="flex items-center gap-6">
                        <!-- Preview Foto -->
                        <div class="flex-shrink-0">
                            @if($user->photo_path)
                                <img src="{{ asset('storage/' . $user->photo_path) }}" 
                                     alt="Foto Profil"
                                     class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                            @else
                                <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center border-4 border-gray-300">
                                    <span class="text-4xl font-bold text-gray-500">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Upload Form -->
                        <div class="flex-1">
                            <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Foto Baru</label>
                                    <input type="file" name="photo" accept="image/*" required
                                           class="w-full border-gray-300 rounded-md shadow-sm">
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max 2MB.</p>
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700">
                                        📤 Upload Foto
                                    </button>
                                    
                                    @if($user->photo_path)
                                        <button type="button" onclick="document.getElementById('deletePhotoForm').submit()" 
                                                class="px-4 py-2 bg-red-600 text-white rounded-md font-semibold hover:bg-red-700">
                                            🗑️ Hapus Foto
                                        </button>
                                    @endif
                                </div>
                            </form>

                            @if($user->photo_path)
                                <form id="deletePhotoForm" method="POST" action="{{ route('profile.photo.delete') }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- INFORMASI PROFIL -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 pb-2 border-b">Informasi Profil</h3>
                    
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- NIK (Read-only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                                <input type="text" value="{{ $user->employee_number }}" disabled
                                       class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100">
                            </div>

                            <!-- Role (Read-only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                <input type="text" value="{{ $user->roles->first()->name ?? '-' }}" disabled
                                       class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100">
                            </div>

                            <!-- Departemen (Read-only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Departemen</label>
                                <input type="text" value="{{ $user->department }}" disabled
                                       class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100">
                            </div>

                            <!-- Jabatan (Read-only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                                <input type="text" value="{{ $user->position }}" disabled
                                       class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100">
                            </div>

                            <!-- Area (Read-only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Area</label>
                                <input type="text" value="{{ $user->area ? $user->area->name : 'Non-Area' }}" disabled
                                       class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100">
                            </div>

                            <!-- Shift (Read-only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Shift</label>
                                <input type="text" value="{{ $user->shift ? $user->shift->name : '-' }}" disabled
                                       class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100">
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" 
                                    class="px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition shadow">
                                💾 Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- GANTI PASSWORD -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 pb-2 border-b">Ganti Password</h3>
                    
                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="max-w-md space-y-4">
                            <!-- Password Lama -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
                                <input type="password" name="current_password" required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Password Baru -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                <input type="password" name="password" required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <button type="submit" 
                                        class="px-6 py-3 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700 transition shadow">
                                    🔐 Ganti Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
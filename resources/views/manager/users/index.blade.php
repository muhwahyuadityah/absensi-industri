<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola User
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- PESAN SUCCESS/ERROR -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow">
                    {{ session('error') }}
                </div>
            @endif

            <!-- FILTER & SEARCH -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Filter User</h3>
                        <a href="{{ auth()->user()->hasRole('Manager') ? route('manager.users.create') : route('admin.users.create') }}" 
                           class="px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition shadow">
                            ➕ Tambah User
                        </a>
                    </div>

                    <form method="GET" action="{{ auth()->user()->hasRole('Manager') ? route('manager.users.index') : route('admin.users.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email/NIK..." 
                                       class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <select name="role" class="w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Semua Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select name="status" class="w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700">
                                    🔍 Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TABEL USER -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Daftar User ({{ $users->total() }} user)</h3>

                    @if($users->count() == 0)
                        <p class="text-center text-gray-600 py-8">Tidak ada user.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIK</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Departemen</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Area</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Verifikasi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($users as $user)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->position }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->employee_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    {{ $user->roles->first()->name ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->department }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $user->area ? $user->area->name : 'Non-Area' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($user->is_active)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                                @endif
                                            </td>
                                           <td class="px-6 py-4 whitespace-nowrap">
                                                @if($user->email_verified_at)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">✓ Verified</span>
                                                @else
                                                    <div class="flex flex-col gap-1">
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">⏳ Pending</span>
                                                        <form action="{{ route('verification.resend.manual', $user->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="text-xs text-blue-600 hover:text-blue-800 underline">
                                                                📧 Kirim Ulang
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ auth()->user()->hasRole('Manager') ? route('manager.users.edit', $user) : route('admin.users.edit', $user) }}" 
                                                   class="text-blue-600 hover:text-blue-800 font-medium mr-3">
                                                    ✏️ Edit
                                                </a>
                                                
                                                @if(!$user->trashed())
                                                    <form action="{{ auth()->user()->hasRole('Manager') ? route('manager.users.destroy', $user) : route('admin.users.destroy', $user) }}" 
                                                          method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus user ini?')" 
                                                                class="text-red-600 hover:text-red-800 font-medium">
                                                            🗑️ Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $users->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
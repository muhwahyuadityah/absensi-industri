<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Set Password & Aktivasi Akun</h2>
        <p>Halo, <strong>{{ $user->name }}</strong>!</p>
        <p class="mt-2">Silakan buat password untuk akun Anda. Password ini akan digunakan untuk login ke sistem.</p>
    </div>

    <!-- Validation Errors -->
    @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.set.store', $user->id) . '?' . http_build_query(request()->query()) }}">
        @csrf

        <!-- Email (read-only) -->
        <div class="mb-4">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" :value="$user->email" disabled class="mt-1 block w-full bg-gray-100" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" value="Password Baru" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" class="mt-1 block w-full" />
            <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="mt-1 block w-full" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <x-primary-button>
                Aktivasi Akun & Set Password
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
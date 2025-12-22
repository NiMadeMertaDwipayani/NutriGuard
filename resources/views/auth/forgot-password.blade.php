<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Lupa password Anda? Tidak masalah. Beri tahu kami alamat email Anda dan kami akan mengirimkan tautan pengaturan ulang password.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 underline decoration-emerald-500 decoration-2 underline-offset-4 font-medium transition">
                &larr; Kembali ke Login
            </a>

            <x-primary-button>
                {{ __('Kirim Link Reset') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>


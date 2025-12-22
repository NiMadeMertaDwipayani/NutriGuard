<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="avatar" :value="__('Foto Profil')" />
            
            <div class="flex items-start gap-4 mt-2">
                <div class="shrink-0">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-2 border-emerald-500 shadow-sm">
                    @else
                        <div class="w-20 h-20 rounded-full bg-gray-100 border-2 border-gray-300 flex items-center justify-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <input id="avatar" name="avatar" type="file" 
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-white focus:outline-none
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-l-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-emerald-600 file:text-white
                        hover:file:bg-emerald-700"
                        accept="image/*" />
                    
                    @if($user->avatar)
                        <div class="mt-2">
                            <button type="submit" form="delete-avatar-form" 
                                    class="text-sm text-red-600 hover:text-red-800 underline font-medium transition"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus foto profil ini? Tindakan ini tidak dapat dibatalkan.');">
                                Hapus Foto Profil
                            </button>
                        </div>
                    @endif

                    <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                </div>
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <form id="delete-avatar-form" method="POST" action="{{ route('profile.avatar.destroy') }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>
    
    @if (session('status') === 'avatar-deleted')
        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-red-600 mt-2">{{ __('Foto profil berhasil dihapus.') }}</p>
    @endif

</section>


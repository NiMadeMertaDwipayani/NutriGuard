<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">{{ __('Edit User') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-gray-300 text-sm font-bold mb-2">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                            class="w-full bg-gray-900 text-white rounded focus:ring-emerald-500 focus:border-emerald-500 
                            @error('name') border-red-500 @else border-gray-600 @enderror" 
                            required>
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-300 text-sm font-bold mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                            class="w-full bg-gray-900 text-white rounded focus:ring-emerald-500 focus:border-emerald-500
                            @error('email') border-red-500 @else border-gray-600 @enderror" 
                            required>
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-300 text-sm font-bold mb-2">Role</label>
                        <select name="role" 
                            class="w-full bg-gray-900 text-white rounded focus:ring-emerald-500 focus:border-emerald-500
                            @error('role') border-red-500 @else border-gray-600 @enderror">
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User Biasa</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="border-gray-700 my-6">

                    <div class="mb-4">
                        <label class="block text-gray-300 text-sm font-bold mb-2">Password Baru (Opsional)</label>
                        <input type="password" name="password" 
                            class="w-full bg-gray-900 text-white rounded focus:ring-emerald-500 focus:border-emerald-500
                            @error('password') border-red-500 @else border-gray-600 @enderror" 
                            placeholder="Biarkan kosong jika tidak ingin mengganti">
                        
                        <p class="text-gray-500 text-xs mt-1">
                            *Kosongkan jika password masih sama. Jika diisi, minimal 8 karakter.
                        </p>

                        @error('password')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-300 text-sm font-bold mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" 
                            class="w-full bg-gray-900 text-white rounded focus:ring-emerald-500 focus:border-emerald-500
                            @error('password_confirmation') border-red-500 @else border-gray-600 @enderror" 
                            placeholder="Ulangi Password Baru">
                        
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2 mt-6 pt-4 border-t border-gray-700">
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500 transition">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 transition font-bold shadow-lg">Update Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>


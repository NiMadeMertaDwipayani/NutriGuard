<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">{{ __('Tambah User') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-300 text-sm font-bold mb-2">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                            class="w-full bg-gray-900 text-white rounded focus:ring-emerald-500 focus:border-emerald-500 
                            @error('name') border-red-500 @else border-gray-600 @enderror" 
                            required placeholder="Nama Lengkap">
                        
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-300 text-sm font-bold mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="w-full bg-gray-900 text-white rounded focus:ring-emerald-500 focus:border-emerald-500
                            @error('email') border-red-500 @else border-gray-600 @enderror" 
                            required placeholder="email@contoh.com">
                        
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-300 text-sm font-bold mb-2">Role</label>
                        <select name="role" 
                            class="w-full bg-gray-900 text-white rounded focus:ring-emerald-500 focus:border-emerald-500
                            @error('role') border-red-500 @else border-gray-600 @enderror">
                            <option value="user">User Biasa</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-300 text-sm font-bold mb-2">Password</label>
                        <input type="password" name="password" 
                            class="w-full bg-gray-900 text-white rounded focus:ring-emerald-500 focus:border-emerald-500
                            @error('password') border-red-500 @else border-gray-600 @enderror" 
                            required placeholder="********">
                        
                        <p class="text-gray-500 text-xs mt-1">
                            *Password harus memiliki minimal 8 karakter.
                        </p>

                        @error('password')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-300 text-sm font-bold mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" 
                            class="w-full bg-gray-900 text-white rounded focus:ring-emerald-500 focus:border-emerald-500
                            @error('password') border-red-500 @else border-gray-600 @enderror" 
                            required placeholder="Ulangi Password">
                    </div>

                    <div class="flex justify-end gap-2 mt-6 border-t border-gray-700 pt-4">
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500 transition">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 transition font-bold shadow-lg">Simpan User</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>


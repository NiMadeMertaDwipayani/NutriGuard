<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">{{ __('Edit Bahan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                
                <form method="POST" action="{{ route('admin.ingredients.update', $ingredient->id) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-gray-300 text-sm font-bold mb-2">Nama Bahan</label>
                        <input type="text" name="name" value="{{ old('name', $ingredient->name) }}" class="w-full bg-gray-900 border-gray-600 text-white rounded focus:ring-emerald-500 focus:border-emerald-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-300 text-sm font-bold mb-2">Ganti Foto (Opsional)</label>
                        
                        @if($ingredient->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $ingredient->image) }}" class="h-20 w-20 rounded object-cover border border-gray-600">
                            </div>
                        @endif

                        <input type="file" name="image" class="w-full text-gray-300 bg-gray-900 border border-gray-600 rounded cursor-pointer">
                    </div>

                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('admin.ingredients.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>


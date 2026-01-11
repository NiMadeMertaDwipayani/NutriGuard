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

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-300 text-sm font-bold mb-2">Kalori (kkal/100g)</label>
                            <input type="number" name="calories" value="{{ old('calories', $ingredient->calories) }}" min="0"
                                class="w-full bg-gray-900 border-gray-600 text-white rounded focus:ring-emerald-500 focus:border-emerald-500"
                                required>
                        </div>

                        <div>
                            <label class="block text-gray-300 text-sm font-bold mb-2">Protein (g/100g)</label>
                            <input type="number" step="0.1" name="protein" value="{{ old('protein', $ingredient->protein) }}" min="0"
                                class="w-full bg-gray-900 border-gray-600 text-white rounded focus:ring-emerald-500 focus:border-emerald-500"
                                required>
                        </div>

                        <div>
                            <label class="block text-gray-300 text-sm font-bold mb-2">Karbohidrat (g/100g)</label>
                            <input type="number" step="0.1" name="carbs" value="{{ old('carbs', $ingredient->carbs) }}" min="0"
                                class="w-full bg-gray-900 border-gray-600 text-white rounded focus:ring-emerald-500 focus:border-emerald-500"
                                required>
                        </div>

                        <div>
                            <label class="block text-gray-300 text-sm font-bold mb-2">Lemak (g/100g)</label>
                            <input type="number" step="0.1" name="fat" value="{{ old('fat', $ingredient->fat) }}" min="0"
                                class="w-full bg-gray-900 border-gray-600 text-white rounded focus:ring-emerald-500 focus:border-emerald-500"
                                required>
                        </div>
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


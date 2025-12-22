<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">{{ __('Edit Penyakit') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                
                <form method="POST" action="{{ route('admin.diseases.update', $disease->id) }}">
                    @csrf @method('PUT')
                    
                    <div class="mb-6 border-b border-gray-700 pb-6">
                        <h3 class="text-lg font-bold text-emerald-400 mb-4">Informasi Dasar</h3>
                        
                        <div class="mb-4">
                            <label class="block text-gray-300 text-sm font-bold mb-2">Nama Penyakit</label>
                            <input type="text" name="name" value="{{ old('name', $disease->name) }}" class="w-full bg-gray-900 border-gray-600 text-white rounded focus:ring-emerald-500 focus:border-emerald-500" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-300 text-sm font-bold mb-2">Deskripsi Singkat</label>
                            <textarea name="description" rows="3" class="w-full bg-gray-900 border-gray-600 text-white rounded focus:ring-emerald-500 focus:border-emerald-500">{{ old('description', $disease->description) }}</textarea>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex flex-col sm:flex-row justify-between items-end mb-4 gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-emerald-400 mb-1">Atur Pantangan Makanan</h3>
                                <p class="text-gray-400 text-sm">Tentukan apakah bahan makanan berikut Aman atau Berbahaya.</p>
                            </div>
                            
                            <div class="w-full sm:w-64 relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                
                                <input type="text" id="searchIngredient" 
                                    class="block w-full p-2.5 pl-10 text-sm text-gray-200 border border-gray-600 rounded-lg bg-gray-700 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 placeholder-gray-400 transition-colors" 
                                    placeholder="Cari bahan...">
                            </div>
                        </div>

                        <div id="ingredientGrid" class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($ingredients as $ingredient)
                                @php
                                    $currentRel = $disease->ingredients->find($ingredient->id);
                                    $currentStatus = $currentRel ? $currentRel->pivot->status : '';
                                @endphp

                                <div class="ingredient-item flex items-center justify-between bg-gray-900 p-3 rounded border border-gray-600 hover:border-gray-500 transition">
                                    <div class="flex items-center overflow-hidden">
                                        @if($ingredient->image)
                                            <img src="{{ asset('storage/' . $ingredient->image) }}" class="h-8 w-8 rounded object-cover mr-3 flex-shrink-0">
                                        @endif
                                        <span class="ingredient-name text-gray-200 font-medium truncate">{{ $ingredient->name }}</span>
                                    </div>

                                    <select name="ingredients[{{ $ingredient->id }}]" class="bg-gray-800 border-gray-600 text-sm rounded focus:ring-emerald-500 focus:border-emerald-500 ml-2
                                        {{ $currentStatus == 'danger' ? 'text-red-400 font-bold border-red-900' : '' }}
                                        {{ $currentStatus == 'safe' ? 'text-emerald-400 font-bold border-emerald-900' : '' }}
                                        {{ $currentStatus == 'warning' ? 'text-yellow-400 font-bold border-yellow-900' : '' }}
                                    ">
                                        <option value="" class="text-gray-500">-- Netral --</option>
                                        <option value="safe" {{ $currentStatus == 'safe' ? 'selected' : '' }}>✅ Aman</option>
                                        <option value="warning" {{ $currentStatus == 'warning' ? 'selected' : '' }}>⚠️ Batasi</option>
                                        <option value="danger" {{ $currentStatus == 'danger' ? 'selected' : '' }}>⛔ Bahaya</option>
                                    </select>
                                </div>
                            @endforeach
                        </div>
                        
                        <div id="noIngredientsFound" class="hidden py-4 text-center text-gray-500 text-sm">
                            Tidak ditemukan bahan makanan dengan nama tersebut.
                        </div>

                        @if($ingredients->isEmpty())
                            <p class="text-red-400 text-sm mt-2">*Belum ada Data Bahan Makanan. Silakan input bahan dulu.</p>
                        @endif
                    </div>

                    <div class="flex justify-end gap-2 mt-6 border-t border-gray-700 pt-4">
                        <a href="{{ route('admin.diseases.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 font-bold shadow-lg">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchIngredient').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let items = document.querySelectorAll('.ingredient-item');
            let foundCount = 0;

            items.forEach(function(item) {
                let name = item.querySelector('.ingredient-name').textContent.toLowerCase();
                if (name.includes(filter)) {
                    item.style.display = "flex";
                    foundCount++;
                } else {
                    item.style.display = "none";
                }
            });

            let noResultMsg = document.getElementById('noIngredientsFound');
            if (foundCount === 0) {
                noResultMsg.classList.remove('hidden');
            } else {
                noResultMsg.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>



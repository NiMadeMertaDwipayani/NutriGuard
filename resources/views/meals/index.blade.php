<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Daily Nutrition Tracker') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-emerald-900 border border-emerald-400 text-emerald-100 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('warning'))
                <div class="bg-red-900 border border-red-400 text-red-100 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Hati-hati!</strong>
                    <span class="block sm:inline">{{ session('warning') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                    <h3 class="text-lg font-bold mb-4 text-white">Catat Makanan Hari Ini</h3>
                    <form action="{{ route('meals.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-300 text-sm font-bold mb-2">Tanggal</label>
                            <input type="date" name="consumed_at" value="{{ date('Y-m-d') }}" 
                                class="w-full bg-gray-900 border-gray-600 text-white rounded focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-300 text-sm font-bold mb-2">Pilih Menu</label>
                            <select name="ingredient_id" 
                                class="w-full bg-gray-900 border-gray-600 text-white rounded focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                                @foreach($ingredients as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }} ({{ $item->calories }} kkal/100g)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-300 text-sm font-bold mb-2">Berat (Gram)</label>
                            <input type="number" name="grams" placeholder="Contoh: 200" 
                                class="w-full bg-gray-900 border-gray-600 text-white rounded focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" required>
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                            Hitung & Simpan
                        </button>
                    </form>
                </div>

                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                    <h3 class="text-lg font-bold mb-4 text-white">Ringkasan Hari Ini</h3>
                    
                    <div class="mb-6 text-center bg-gray-900 rounded-lg p-4 border border-gray-700">
                        <span class="text-gray-400 uppercase text-xs font-semibold tracking-wider">Total Kalori Masuk</span>
                        <h1 class="text-4xl font-extrabold mt-2 {{ $totalCaloriesToday > Auth::user()->calorie_limit ? 'text-red-500' : 'text-emerald-500' }}">
                            {{ number_format($totalCaloriesToday, 0) }} kkal
                        </h1>
                        <p class="text-sm text-gray-400 mt-1">Target Batas: <span class="text-white">{{ Auth::user()->calorie_limit }} kkal</span></p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Menu</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Porsi</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Kalori</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-700 bg-gray-700"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todayMeals as $log)
                                <tr>
                                    <td class="px-5 py-4 border-b border-gray-700 bg-gray-800 text-sm text-white">{{ $log->ingredient->name }}</td>
                                    <td class="px-5 py-4 border-b border-gray-700 bg-gray-800 text-sm text-gray-300">{{ $log->grams }}g</td>
                                    <td class="px-5 py-4 border-b border-gray-700 bg-gray-800 text-sm font-bold text-emerald-400">{{ number_format($log->total_calories, 0) }}</td>
                                    <td class="px-5 py-4 border-b border-gray-700 bg-gray-800 text-sm text-right">
                                        <form action="{{ route('meals.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 text-sm font-medium">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-4 border-b border-gray-700 bg-gray-800 text-sm text-center text-gray-500 italic">
                                        Belum ada data makan hari ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
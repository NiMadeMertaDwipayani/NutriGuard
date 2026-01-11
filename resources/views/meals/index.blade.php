<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Meal Tracker & Statistik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-emerald-900 border border-emerald-400 text-emerald-100 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('warning'))
                <div class="bg-red-900 border border-red-400 text-red-100 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Hati-hati!</strong> {{ session('warning') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                    <h3 class="text-lg font-bold mb-4 text-white">Catat Makanan</h3>
                    <form action="{{ route('meals.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-300 text-sm font-bold mb-2">Tanggal</label>
                            <input type="date" name="consumed_at" value="{{ date('Y-m-d') }}" 
                                class="w-full bg-gray-900 border-gray-600 text-white rounded focus:ring-emerald-500 shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-300 text-sm font-bold mb-2">Menu</label>
                            <select name="ingredient_id" 
                                class="w-full bg-gray-900 border-gray-600 text-white rounded focus:ring-emerald-500 shadow-sm">
                                @foreach($ingredients as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->calories }} kkal)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-300 text-sm font-bold mb-2">Berat (Gram)</label>
                            <input type="number" name="grams" placeholder="Contoh: 200" 
                                class="w-full bg-gray-900 border-gray-600 text-white rounded focus:ring-emerald-500 shadow-sm" required>
                        </div>
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded transition">
                            Simpan Data
                        </button>
                    </form>
                </div>

                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                    <h3 class="text-lg font-bold mb-4 text-white">List Hari Ini</h3>
                    <div class="text-center bg-gray-900 rounded-lg p-4 mb-4 border border-gray-700">
                        <span class="text-xs text-gray-400 uppercase">Total Kalori</span>
                        <h1 class="text-3xl font-bold {{ $totalCaloriesToday > Auth::user()->calorie_limit ? 'text-red-500' : 'text-emerald-500' }}">
                            {{ number_format($totalCaloriesToday, 0) }} kkal
                        </h1>
                    </div>
                    <div class="overflow-y-auto max-h-64">
                        <table class="min-w-full text-sm text-left text-gray-300">
                            <thead class="text-xs uppercase bg-gray-700 text-gray-300">
                                <tr>
                                    <th class="px-4 py-2">Menu</th>
                                    <th class="px-4 py-2">Kalori</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todayMeals as $log)
                                <tr class="border-b border-gray-700">
                                    <td class="px-4 py-3">{{ $log->ingredient->name }} ({{ $log->grams }}g)</td>
                                    <td class="px-4 py-3 font-bold text-emerald-400">{{ number_format($log->total_calories, 0) }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <form action="{{ route('meals.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Hapus?');">
                                            @csrf @method('DELETE')
                                            <button class="text-red-400 hover:text-red-300">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="px-4 py-3 text-center italic text-gray-500">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700 flex flex-col items-center">
                    <h3 class="text-lg font-bold mb-4 text-white">🥗 Nutrisi Hari Ini</h3>
                    <div class="relative h-64 w-full md:w-3/4">
                        <canvas id="nutritionChart"></canvas>
                    </div>
                    <div class="mt-4 flex space-x-4 text-xs text-gray-300">
                        <span class="flex items-center"><span class="w-3 h-3 bg-blue-500 rounded-full mr-1"></span>Pro: {{ number_format($totalProtein, 1) }}g</span>
                        <span class="flex items-center"><span class="w-3 h-3 bg-yellow-500 rounded-full mr-1"></span>Carb: {{ number_format($totalCarbs, 1) }}g</span>
                        <span class="flex items-center"><span class="w-3 h-3 bg-red-500 rounded-full mr-1"></span>Fat: {{ number_format($totalFat, 1) }}g</span>
                    </div>
                </div>

                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                    <h3 class="text-lg font-bold mb-4 text-white">📅 Riwayat 7 Hari Terakhir</h3>
                    <div class="relative h-64 w-full">
                        <canvas id="historyChart"></canvas>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // 1. Config Grafik Donat (Nutrisi)
        const ctxNutri = document.getElementById('nutritionChart').getContext('2d');
        new Chart(ctxNutri, {
            type: 'doughnut',
            data: {
                labels: ['Protein', 'Karbo', 'Lemak'],
                datasets: [{
                    data: [{{ $totalProtein }}, {{ $totalCarbs }}, {{ $totalFat }}],
                    backgroundColor: ['#3b82f6', '#eab308', '#ef4444'], 
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // 2. Config Grafik Batang (History)
        const ctxHist = document.getElementById('historyChart').getContext('2d');
        new Chart(ctxHist, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Kalori (kkal)',
                    data: {!! json_encode($chartValues) !!},
                    backgroundColor: '#10b981',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, grid: { color: '#374151' }, ticks: { color: '#9ca3af' } },
                    x: { grid: { display: false }, ticks: { color: '#9ca3af' } }
                },
                plugins: { legend: { display: false } }
            }
        });
    </script>
</x-app-layout>
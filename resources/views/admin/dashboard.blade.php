<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg mb-6 border border-gray-700">
                <div class="p-6 text-gray-100">
                    Halo, <strong class="text-emerald-400">{{ Auth::user()->name }}</strong>! Selamat datang di Panel Admin NutriGuard.
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg p-6 border-l-4 border-l-blue-500 border-y border-r border-gray-700">
                    <div class="text-gray-400 text-sm font-bold uppercase tracking-wider">Total Pasien</div>
                    <div class="text-3xl font-extrabold text-white mt-2">{{ $totalUsers }}</div>
                </div>

                <div class="bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg p-6 border-l-4 border-l-red-500 border-y border-r border-gray-700">
                    <div class="text-gray-400 text-sm font-bold uppercase tracking-wider">Data Penyakit</div>
                    <div class="text-3xl font-extrabold text-white mt-2">{{ $totalDiseases }}</div>
                </div>

                <div class="bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg p-6 border-l-4 border-l-emerald-500 border-y border-r border-gray-700">
                    <div class="text-gray-400 text-sm font-bold uppercase tracking-wider">Bahan Makanan</div>
                    <div class="text-3xl font-extrabold text-white mt-2">{{ $totalIngredients }}</div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>


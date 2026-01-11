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

               <div class="mt-8">
                    <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-700">
                        
                        <div class="px-6 py-4 border-b border-gray-700 flex justify-between items-center bg-gray-800">
                            <div>
                                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                    🕵️ Log Aktivitas Admin (CCTV)
                                </h3>
                                <p class="text-sm text-gray-400 mt-1">Memantau 10 aktivitas terbaru dalam sistem</p>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-300">
                                <thead class="text-xs uppercase bg-gray-900 text-gray-400">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold tracking-wider">Waktu</th>
                                        <th class="px-6 py-4 font-semibold tracking-wider">Pelaku</th>
                                        <th class="px-6 py-4 font-semibold tracking-wider text-center">Aksi</th>
                                        <th class="px-6 py-4 font-semibold tracking-wider">Detail Perubahan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700">
                                    @forelse($activities as $log)
                                    <tr class="hover:bg-gray-700/50 transition duration-150">
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-400">
                                            {{ $log->created_at->format('d M Y') }} 
                                            <span class="text-xs ml-1 text-gray-500">({{ $log->created_at->format('H:i') }})</span>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap font-bold text-emerald-400">
                                            {{ $log->user ? $log->user->name : 'System' }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @php
                                                $color = 'gray';
                                                if(str_contains($log->action, 'Create')) $color = 'blue';
                                                if(str_contains($log->action, 'Update')) $color = 'yellow';
                                                if(str_contains($log->action, 'Delete')) $color = 'red';
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-bold shadow-sm
                                                @if($color == 'blue') bg-blue-900/50 text-blue-200 border border-blue-700 
                                                @elseif($color == 'yellow') bg-yellow-900/50 text-yellow-200 border border-yellow-700 
                                                @elseif($color == 'red') bg-red-900/50 text-red-200 border border-red-700 
                                                @else bg-gray-700 text-gray-300 border-gray-600 @endif">
                                                {{ $log->action }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-gray-300 leading-relaxed">
                                            {{ $log->description }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 italic bg-gray-800">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                Belum ada aktivitas terekam.
                                            </div>
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
    </div>
</x-app-layout>


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Data Penyakit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h3 class="text-lg font-bold text-gray-100">List Penyakit</h3>
                    
                    <div class="flex gap-2 w-full md:w-auto">
                        <form method="GET" action="{{ route('admin.diseases.index') }}" class="flex w-full md:w-auto">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                class="bg-gray-900 text-gray-300 text-sm rounded-l border border-gray-600 focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5" 
                                placeholder="Cari penyakit...">
                            <button type="submit" class="p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </button>
                        </form>

                        <a href="{{ route('admin.diseases.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow-lg transition whitespace-nowrap flex items-center">
                            + Tambah
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-emerald-900/50 border border-emerald-500 text-emerald-200 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-800 text-gray-300">
                        <thead>
                            <tr class="bg-gray-700 text-gray-200 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left w-10">No</th>
                                <th class="py-3 px-6 text-left">Nama Penyakit</th>
                                <th class="py-3 px-6 text-left">Deskripsi</th>
                                <th class="py-3 px-6 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-light">
                            @forelse ($diseases as $index => $disease)
                                <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                    <td class="py-3 px-6">{{ $index + 1 }}</td>
                                    <td class="py-3 px-6 font-bold text-white">{{ $disease->name }}</td>
                                    <td class="py-3 px-6">{{ Str::limit($disease->description, 50) }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center gap-2">
                                            <a href="{{ route('admin.diseases.edit', $disease->id) }}" class="text-blue-400 hover:text-blue-300">
                                                Edit
                                            </a>
                                            <span class="text-gray-600">|</span>
                                            <form action="{{ route('admin.diseases.destroy', $disease->id) }}" method="POST" onsubmit="return confirm('Yakin hapus penyakit ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-gray-500">Belum ada data penyakit.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>


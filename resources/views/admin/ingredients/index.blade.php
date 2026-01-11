<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">{{ __('Bahan Makanan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-100">List Bahan</h3>
                    <a href="{{ route('admin.ingredients.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow-lg transition">
                        + Tambah Bahan
                    </a>
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
                                <th class="py-3 px-6 text-center w-24">Gambar</th>
                                <th class="py-3 px-6 text-left">Nama Bahan</th>
                                <th class="py-3 px-6 text-left">Kalori</th>
                                <th class="py-3 px-6 text-left">Protein</th>
                                <th class="py-3 px-6 text-left">Karbo</th>
                                <th class="py-3 px-6 text-left">Lemak</th>
                                <th class="py-3 px-6 text-center w-32">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="text-sm font-light">
                            @forelse ($ingredients as $index => $item)
                                <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                    <td class="py-3 px-6">{{ $index + 1 }}</td>
                                    <td class="py-3 px-6 text-center">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" class="h-12 w-12 rounded object-cover mx-auto border border-gray-600">
                                        @else
                                            <span class="text-xs text-gray-500">No Image</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 font-bold text-white">{{ $item->name }}</td>
                                    <td class="py-3 px-6 font-bold text-white">{{ $item->calories }} kkal</td>
                                    <td class="py-3 px-6 font-bold text-white">{{ $item->protein }} g</td>
                                    <td class="py-3 px-6 font-bold text-white">{{ $item->carbs }} g</td>
                                    <td class="py-3 px-6 font-bold text-white">{{ $item->fat }} g</td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center gap-2">
                                            <a href="{{ route('admin.ingredients.edit', $item->id) }}" class="text-blue-400 hover:text-blue-300">Edit</a>
                                            <span class="text-gray-600">|</span>
                                            <form action="{{ route('admin.ingredients.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus bahan ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-6 text-center text-gray-500">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


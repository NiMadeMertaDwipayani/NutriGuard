<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Profil Kesehatan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                
                <h3 class="text-lg font-medium text-emerald-400 mb-4">Pilih Kondisi Kesehatan Anda</h3>
                <p class="text-gray-400 text-sm mb-6">
                    Informasi ini digunakan untuk memfilter bahan makanan yang aman atau berbahaya bagi Anda. 
                    Data ini bersifat pribadi.
                </p>

                <form method="POST" action="{{ route('health.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        @foreach($diseases as $disease)
                            <label class="flex items-center p-4 bg-gray-900 border border-gray-700 rounded-lg cursor-pointer hover:border-emerald-500 transition">
                                <input type="checkbox" name="diseases[]" value="{{ $disease->id }}" 
                                    class="w-5 h-5 text-emerald-600 bg-gray-700 border-gray-600 rounded focus:ring-emerald-500 focus:ring-2"
                                    {{ $user->diseases->contains($disease->id) ? 'checked' : '' }}>
                                
                                <div class="ml-3">
                                    <span class="block text-sm font-medium text-gray-200">{{ $disease->name }}</span>
                                    <span class="block text-xs text-gray-500">{{ Str::limit($disease->description, 40) }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @if($diseases->isEmpty())
                        <p class="text-yellow-500 text-sm mb-4">Belum ada data penyakit di sistem. Hubungi Admin.</p>
                    @endif

                    <div class="flex justify-end border-t border-gray-700 pt-4">
                        <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-bold shadow-lg transition">
                            Simpan Profil Kesehatan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

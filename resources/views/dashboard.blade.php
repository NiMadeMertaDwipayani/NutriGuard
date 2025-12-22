<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-emerald-900/50 border border-emerald-500 text-emerald-200 px-4 py-3 rounded relative mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                <div class="text-gray-100 text-lg mb-6">
                    Selamat datang, <strong class="text-emerald-400">{{ Auth::user()->name }}</strong>!
                </div>

                <div class="bg-gray-900 p-6 rounded-lg border border-gray-700">
                    <h3 class="text-xl font-bold text-white mb-2">Status Kesehatan Anda</h3>
                    
                    @if(Auth::user()->diseases->isEmpty())
                        <p class="text-gray-400 mb-4">Anda belum mengatur profil kesehatan. Agar sistem bekerja maksimal, silakan atur sekarang.</p>
                        <a href="{{ route('health.edit') }}" class="inline-block px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                            + Atur Penyakit Saya
                        </a>
                    @else
                        <p class="text-gray-400 mb-4">Anda tercatat memiliki kondisi berikut:</p>
                        
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach(Auth::user()->diseases as $disease)
                                <span class="bg-red-900/50 text-red-200 border border-red-700 px-3 py-1 rounded-full text-sm">
                                    {{ $disease->name }}
                                </span>
                            @endforeach
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('health.edit') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Ubah Kondisi Kesehatan
                            </a>

                            <a href="{{ route('health.export') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download PDF
                            </a>
                        </div>

                        <form action="{{ route('health.destroy.all') }}" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-400 underline text-sm transition cursor-pointer" onclick="return confirm('PERINGATAN: Apakah Anda yakin ingin menghapus SEMUA data kondisi kesehatan Anda? Status Anda akan kembali netral.');">
                                Hapus Semua Data Kesehatan
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

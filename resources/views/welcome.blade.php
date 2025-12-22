<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NutriGuard - Your Personal Food Safety Assistant</title>
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .loader {
            border: 3px solid rgba(16, 185, 129, 0.1);
            border-left-color: #10b981;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body class="antialiased font-sans bg-gray-900 text-white selection:bg-emerald-500 selection:text-white">

    <div x-data="{ 
            activeSlide: 0, 
            slides: [
                '{{ asset('img/backgrounds/bg1.jpg') }}', 
                '{{ asset('img/backgrounds/bg2.jpg') }}',
                '{{ asset('img/backgrounds/bg3.jpg') }}',
                '{{ asset('img/backgrounds/bg4.jpg') }}',
                '{{ asset('img/backgrounds/bg5.jpg') }}',
                '{{ asset('img/backgrounds/bg6.jpg') }}',
                '{{ asset('img/backgrounds/bg7.jpg') }}',
                '{{ asset('img/backgrounds/bg8.jpg') }}',
                '{{ asset('img/backgrounds/bg9.jpg') }}',
                '{{ asset('img/backgrounds/bg10.jpg') }}', 
                '{{ asset('img/backgrounds/bg11.jpg') }}',
                '{{ asset('img/backgrounds/bg12.jpg') }}',
                '{{ asset('img/backgrounds/bg13.jpg') }}',
                '{{ asset('img/backgrounds/bg14.jpg') }}',
                '{{ asset('img/backgrounds/bg15.jpg') }}'
            ] 
         }" 
         x-init="setInterval(() => { activeSlide = (activeSlide + 1) % slides.length }, 5000)"
         
         /* PERBAIKAN POSISI: justify-start & pt-24 agar konten naik ke atas */
         class="relative min-h-screen flex flex-col items-center justify-start pt-24 md:pt-32 overflow-hidden">

        <template x-for="(slide, index) in slides" :key="index">
            <img :src="slide" 
                 class="absolute inset-0 w-full h-full object-cover blur-sm scale-105 transition-opacity duration-[2000ms] ease-in-out z-0"
                 :class="{ 'opacity-100': activeSlide === index, 'opacity-0': activeSlide !== index }">
        </template>

        <div class="absolute inset-0 bg-black/80 z-10"></div>

        <div class="absolute top-0 right-0 p-6 z-50">
            @if (Route::has('login'))
                <div class="flex gap-3 items-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-emerald-600 border-2 border-transparent text-white text-sm font-bold rounded-full hover:bg-emerald-700 transition shadow-lg">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 bg-transparent border-2 border-emerald-500 text-emerald-400 text-sm font-bold rounded-full hover:bg-emerald-500 hover:text-white transition shadow-lg">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2 bg-emerald-600 border-2 border-transparent text-white text-sm font-bold rounded-full hover:bg-emerald-700 transition shadow-lg">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        <div class="relative z-20 w-full max-w-5xl px-4 flex flex-col items-center text-center">
            
            <div class="flex justify-center mb-8">
                <img src="{{ url('img/logo.png') }}" alt="Logo NutriGuard" class="h-40 w-auto md:h-60 object-contain drop-shadow-2xl" onerror="this.style.display='none';">
            </div>

            @guest
                <h1 class="text-4xl md:text-6xl font-bold text-emerald-400 mb-4 drop-shadow-lg tracking-wide">
                    Welcome to NutriGuard
                </h1>
            
            <p class="text-gray-200 text-lg md:text-2xl mb-12 leading-relaxed drop-shadow-md font-light max-w-2xl">
                Cek Keamanan Makanan Anda Sekarang.
            </p>
            @else
                <div class="mb-6"></div>
            @endguest

            <div class="w-full max-w-4xl relative mb-10">
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-emerald-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    
                    <input type="text" id="searchInput" 
                        class="block w-full py-3.5 pl-14 pr-12 text-lg text-gray-900 border-none rounded-full bg-white/95 focus:bg-white focus:ring-2 focus:ring-emerald-500/30 shadow-md hover:shadow-lg transition placeholder-gray-500" 
                        placeholder="Cari makanan (misal: Garam, Gula)..." 
                        autocomplete="off">
                    
                    <div id="loadingSpinner" class="absolute inset-y-0 right-0 flex items-center pr-6 hidden">
                        <div class="loader"></div>
                    </div>
                </div>

                <div id="resultsContainer" class="absolute w-full mt-2 bg-gray-900/95 backdrop-blur-xl border border-gray-700 rounded-2xl shadow-2xl overflow-hidden hidden text-left z-50 max-h-[28rem] overflow-y-auto">
                </div>
            </div>

        </div>
        
        <div class="absolute bottom-4 text-gray-500 text-xs z-20">
            © {{ date('Y') }} NutriGuard. Your Health Companion.
        </div>

    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const resultsContainer = document.getElementById('resultsContainer');
        const loadingSpinner = document.getElementById('loadingSpinner');
        let timeout = null;

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            resultsContainer.innerHTML = '';
            resultsContainer.classList.add('hidden');
            clearTimeout(timeout);

            if (query.length > 0) {
                loadingSpinner.classList.remove('hidden');
                timeout = setTimeout(() => { fetchResults(query); }, 500);
            } else {
                loadingSpinner.classList.add('hidden');
            }
        });

        function fetchResults(query) {
            fetch(`/search?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    loadingSpinner.classList.add('hidden');
                    renderResults(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadingSpinner.classList.add('hidden');
                });
        }

        function renderResults(data) {
            if (data.length === 0) {
                resultsContainer.innerHTML = '<div class="p-4 text-gray-400 text-center text-sm">Data tidak ditemukan.</div>';
            } else {
                let html = '';
                data.forEach(item => {
                    let colorClass = 'border-gray-600 bg-gray-800'; 
                    let statusText = 'Login utk Cek';
                    let statusColor = 'text-gray-400';
                    
                    if (item.status === 'safe') {
                        colorClass = 'border-l-4 border-l-emerald-500 bg-gray-800';
                        statusText = 'AMAN';
                        statusColor = 'text-emerald-400';
                    } else if (item.status === 'warning') {
                        colorClass = 'border-l-4 border-l-yellow-500 bg-gray-800';
                        statusText = 'BATASI';
                        statusColor = 'text-yellow-400';
                    } else if (item.status === 'danger') {
                        colorClass = 'border-l-4 border-l-red-500 bg-gray-800';
                        statusText = 'BAHAYA';
                        statusColor = 'text-red-400';
                    }

                    html += `
                        <div class="p-4 border-b border-gray-700 ${colorClass} hover:bg-gray-700 transition flex items-center justify-between group cursor-default">
                            <div class="flex items-center gap-4">
                                ${item.image ? `<img src="${item.image}" class="w-12 h-12 rounded object-cover border border-gray-600">` : ''}
                                <div>
                                    <h3 class="font-bold text-gray-100 text-base">${item.name}</h3>
                                    <p class="text-sm text-gray-400 mt-1">${item.message}</p>
                                </div>
                            </div>
                            <div class="text-xs font-bold ${statusColor} border border-current px-3 py-1 rounded-full tracking-wider">
                                ${statusText}
                            </div>
                        </div>
                    `;
                });
                resultsContainer.innerHTML = html;
            }
            resultsContainer.classList.remove('hidden');
        }
        
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                resultsContainer.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
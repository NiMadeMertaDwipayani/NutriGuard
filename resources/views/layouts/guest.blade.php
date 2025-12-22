<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">

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
         class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

        <template x-for="(slide, index) in slides" :key="index">
            <img :src="slide" 
                 class="absolute inset-0 w-full h-full object-cover blur-sm scale-105 transition-opacity duration-[2000ms] ease-in-out z-0"
                 :class="{ 'opacity-100': activeSlide === index, 'opacity-0': activeSlide !== index }"
                 alt="Background">
        </template>

        <div class="absolute inset-0 bg-black/80 z-10"></div>

        <div class="relative z-20 w-full flex flex-col items-center">
            
            <div class="mb-6">
                <a href="/">
                    <x-application-logo class="w-24 h-24 fill-current text-white drop-shadow-lg" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-6 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-lg border-t-4 border-emerald-500">
                {{ $slot }}
            </div>

        </div>
    </div>
</body>
</html>


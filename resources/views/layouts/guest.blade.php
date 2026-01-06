<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Amaniax Cafe') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png?v=1') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#FDF0F5]">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            <div class="mb-4 transition-transform duration-300 hover:scale-110">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-[#8C6239]" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-[0_15px_50px_-15px_rgba(231,84,128,0.2)] overflow-hidden rounded-[2.5rem] border border-pink-100">
                {{ $slot }}
            </div>

            <div class="mt-8 text-center">
                <p class="text-[10px] font-bold text-[#8C6239]/50 uppercase tracking-[0.2em]">
                    &copy; {{ date('Y') }} Amaniax Cafe - Bali
                </p>
            </div>
        </div>
    </body>
</html>
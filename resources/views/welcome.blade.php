<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Amaniax Café</title>
    <link rel="icon" href="{{ asset('images/cafelogo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Smooth Scrolling */
        html { scroll-behavior: smooth; }
        body { font-family: 'Lora', serif; }
        h1, h2, h3, h4, h5 { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-[#F7C8E0] text-[#3a4a37] antialiased m-0 p-0">

    {{-- NAVBAR (Sticky) --}}
    <nav class="bg-[#fde4ef] px-6 py-4 flex justify-between items-center shadow-sm md:px-10 sticky top-0 z-50">
        <h1 class="text-[#8C6239] text-2xl font-bold m-0 font-['Playfair_Display']">Amaniax Café</h1>
        <div class="flex items-center space-x-4 md:space-x-6">
            <a href="{{ url('/') }}" class="text-[#e75480] font-bold hover:text-[#d74370] transition">HOME</a>
            
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('customer.menu') }}" class="text-[#e75480] font-bold hover:text-[#d74370] transition">MENU</a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-[#e75480] font-bold hover:text-[#d74370] transition bg-transparent border-none cursor-pointer">
                            LOGOUT
                        </button>
                    </form>
                @else
                @endauth
            @endif
        </div>
    </nav>

    {{-- SECTION 1: HERO (Full Screen & Teks Lebih Besar) --}}
    <section class="min-h-screen flex flex-col lg:flex-row items-center justify-center gap-8 px-6 md:px-12 -mt-16 pt-16">
        <div class="w-full lg:w-1/2 text-center lg:text-left">
            {{-- PERUBAHAN: Ukuran teks judul diperbesar (text-5xl md:text-7xl) dan margin bawah ditambah (mb-6) --}}
            <h2 class="text-[#8C6239] font-bold text-5xl md:text-7xl mb-6 font-['Playfair_Display']">
                Sweet Moments Begin with Amaniax
            </h2>
            {{-- PERUBAHAN: Ukuran teks paragraf diperbesar (text-xl md:text-2xl) dan margin bawah ditambah (mb-8) --}}
            <p class="text-[#3A4A37] text-xl md:text-2xl mb-8 leading-relaxed">
                Experience premium desserts, delicious meals, and refreshing drinks at Amaniax Café. <br>
                <span class="font-bold text-[#e75480]">Please login to view our menu and order.</span>
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                @auth
                    <a href="{{ route('customer.menu') }}" class="inline-block">
                        {{-- PERUBAHAN: Ukuran teks tombol diperbesar (text-xl) --}}
                        <button class="bg-[#A6E3E9] text-[#8C6239] text-xl font-bold px-8 py-4 border-2 border-[#6BBBC3] rounded-xl shadow-md hover:bg-[#6BBBC3] hover:text-[#465940] transition duration-300 w-full sm:w-auto">
                            Go to Menu & Order
                        </button>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-block">
                        {{-- PERUBAHAN: Ukuran teks tombol diperbesar (text-xl) --}}
                        <button class="bg-[#A6E3E9] text-[#8C6239] text-xl font-bold px-8 py-4 border-2 border-[#6BBBC3] rounded-xl shadow-md hover:bg-[#6BBBC3] hover:text-[#465940] transition duration-300 w-full sm:w-auto">
                            Login to Order
                        </button>
                    </a>
                    
                    <a href="{{ route('register') }}" class="inline-block">
                        {{-- PERUBAHAN: Ukuran teks tombol diperbesar (text-xl) --}}
                        <button class="bg-transparent text-[#8C6239] text-xl font-bold px-8 py-4 border-2 border-[#8C6239] rounded-xl hover:bg-[#8C6239] hover:text-white transition duration-300 w-full sm:w-auto">
                            Sign Up Now
                        </button>
                    </a>
                @endauth
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex justify-center lg:justify-end">
            {{-- Gambar Hero Besar --}}
            <img src="{{ asset('images/amaniax_hero.png') }}" alt="Amaniax Cafe" class="w-full h-auto rounded-2xl shadow-xl object-cover">
        </div>
    </section>

    {{-- SECTION 2: ABOUT US (Full Screen) --}}
    <section class="min-h-screen flex flex-col-reverse lg:flex-row items-center justify-center gap-8 px-6 py-16 md:px-24 bg-[#F7C8E0]">
        <div class="w-full lg:w-1/2 flex justify-center">
            {{-- Gambar About Us Besar --}}
            <img src="{{ asset('images/amaniaxbuilding.jpg') }}" alt="Amaniax Building" class="w-full h-auto rounded-2xl shadow-xl object-cover">
        </div>

        <div class="w-full lg:w-1/2 bg-[#FFF6BD]/75 p-10 rounded-[32px] shadow-lg">
            <h2 class="text-[#8C6239] font-bold text-4xl md:text-5xl text-center mb-6 font-['Playfair_Display']">About Us</h2>
            <p class="text-[#3A4A37] text-lg text-justify leading-relaxed">
                Established in 2020, Amaniax Café is a cozy café dedicated to creating happiness through premium desserts, delicious food, and refreshing beverages. Designed with comfort and aesthetics in mind, our café offers a welcoming atmosphere perfect for spending time with friends.
            </p>
        </div>
    </section>

    {{-- SECTION 3: WHAT MAKES US SPECIAL (Full Screen) --}}
    <section class="min-h-screen flex flex-col justify-center items-center px-6 py-16">
        
        <div class="text-center mb-12 px-4">
            <h2 class="text-[#8C6239] font-bold text-4xl md:text-6xl font-['Playfair_Display']">What Makes Us Special?</h2>
        </div>

        <div class="flex flex-wrap justify-center gap-6 w-full max-w-7xl mx-auto">
            <div class="w-full md:w-[48%] lg:w-[30%] bg-[#A6E3E9]/75 p-6 rounded-[32px] shadow-lg transform hover:scale-105 transition duration-300">
                <img src="{{ asset('images/cozycafe.jpg') }}" alt="Cozy Cafe" class="w-full h-56 object-cover rounded-2xl shadow-md mb-4 mx-auto block">
                <h3 class="text-[#8C6239] font-bold text-2xl text-center mb-2 font-['Playfair_Display']">Cozy Atmosphere</h3>
                <p class="text-[#3A4A37] text-center leading-relaxed">
                    Amaniax Café offers a warm, cozy, and Instagram-worthy atmosphere that makes every visit feel comfortable.
                </p>
            </div>

            <div class="w-full md:w-[48%] lg:w-[30%] bg-[#A6E3E9]/75 p-6 rounded-[32px] shadow-lg transform hover:scale-105 transition duration-300">
                <img src="{{ asset('images/dessert.jpg') }}" alt="Dessert" class="w-full h-56 object-cover rounded-2xl shadow-md mb-4 mx-auto block">
                <h3 class="text-[#8C6239] font-bold text-2xl text-center mb-2 font-['Playfair_Display']">Special Desserts</h3>
                <p class="text-[#3A4A37] text-center leading-relaxed">
                    Our premium desserts and signature menu are crafted with high-quality ingredients and unique flavors.
                </p>
            </div>

            <div class="w-full md:w-[48%] lg:w-[30%] bg-[#A6E3E9]/75 p-6 rounded-[32px] shadow-lg transform hover:scale-105 transition duration-300">
                <img src="{{ asset('images/promo1.jpg') }}" alt="Promo" class="w-full h-56 object-cover rounded-2xl shadow-md mb-4 mx-auto block">
                <h3 class="text-[#8C6239] font-bold text-2xl text-center mb-2 font-['Playfair_Display']">Attractive Promos</h3>
                <p class="text-[#3A4A37] text-center leading-relaxed">
                    We regularly offer exciting promotions and special deals for our customers. Enjoy great food at special prices.
                </p>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-[#E6A9C8] pt-12 pb-6">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <div class="flex flex-col items-start">
                <img src="{{ asset('images/cafelogo.png') }}" alt="Amaniax Logo" class="h-24 mb-4">
                <p class="text-[#3A4A37] text-justify font-light leading-relaxed">
                    Amaniax Cafe is the perfect place to enjoy premium desserts, delicious meals, and refreshing drinks in a cozy atmosphere.
                </p>
            </div>

            <div>
                <h3 class="text-[#8C6239] font-bold text-xl mb-4 font-['Playfair_Display']">Contact Us</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="flex items-center text-[#3A4A37] font-semibold hover:text-[#8C6239] transition">
                            <i class="fa-solid fa-location-dot mr-2"></i> Vanilla Blvd No. 21, Indonesia
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center text-[#3A4A37] font-semibold hover:text-[#8C6239] transition">
                            <i class="fa-solid fa-phone mr-2"></i> +62 361 555 0101
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center text-[#3A4A37] font-semibold hover:text-[#8C6239] transition">
                            <i class="fa-solid fa-envelope mr-2"></i> hello@amaniax.com
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-[#8C6239] font-bold text-xl mb-4 font-['Playfair_Display']">Follow Us</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="flex items-center text-[#3A4A37] font-semibold hover:text-[#8C6239] transition">
                            <i class="fa-brands fa-square-instagram mr-2"></i> amaniax.id
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center text-[#3A4A37] font-semibold hover:text-[#8C6239] transition">
                            <i class="fa-brands fa-square-facebook mr-2"></i> amaniax.id
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center text-[#3A4A37] font-semibold hover:text-[#8C6239] transition">
                            <i class="fa-brands fa-tiktok mr-2"></i> amaniax.id
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="text-center text-gray-600 mt-12 border-t border-gray-400/20 pt-6">
            <p>&copy; 2025 Amaniax Cafe. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
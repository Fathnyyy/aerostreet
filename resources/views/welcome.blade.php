<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KICKSLAB - Industrial Hypebeast Store</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&family=Inter:wght@300;400;500;600&family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .brand-font { font-family: 'Oswald', sans-serif; }
        .logo-font { font-family: 'Instrument Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        
        /* Sale Badge Animation */
        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
        }
        .sale-badge {
            animation: pulse-red 2s infinite;
        }
    </style>
</head>
<body class="antialiased bg-white text-black selection:bg-black selection:text-white">

    <!-- Navbar -->
    <nav class="sticky top-0 z-[100] bg-white border-b border-gray-200" x-data="{ searchOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-3xl font-black italic uppercase tracking-tighter logo-font">
                        KICKSLAB
                    </a>
                </div>

                <!-- Center Menu (Desktop) -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home', ['category' => 'men']) }}#shop" class="text-sm font-bold uppercase tracking-wide hover:border-b-2 hover:border-black transition-all pb-1">Men</a>
                    <a href="{{ route('home', ['category' => 'women']) }}#shop" class="text-sm font-bold uppercase tracking-wide hover:border-b-2 hover:border-black transition-all pb-1">Women</a>
                    
                    <!-- Brands Dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="flex items-center text-sm font-bold uppercase tracking-wide hover:border-b-2 hover:border-black transition-all pb-1 focus:outline-none">
                            Brands
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 shadow-lg py-2 z-50 rounded-sm" x-cloak>
                            @foreach($brands as $b)
                                <a href="{{ route('home', ['brand' => $b]) }}#shop" class="block px-4 py-2 text-sm font-medium hover:bg-gray-100">{{ $b }}</a>
                            @endforeach
                        </div>
                    </div>

                    <a href="#shop" class="text-sm font-bold uppercase tracking-wide text-red-600 hover:border-b-2 hover:border-red-600 transition-all pb-1">Sale</a>
                </div>

                <!-- Right Icons -->
                <div class="flex items-center space-x-6">
                    <!-- Search -->
                    <a href="#shop" class="hover:text-gray-600 transition focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </a>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="relative hover:text-gray-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold w-4 h-4 flex items-center justify-center rounded-full">
                            {{ Auth::check() ? Auth::user()->carts->count() : 0 }}
                        </span>
                    </a>

                    <!-- Auth -->
                    @if (Route::has('login'))
                        @auth
                            <!-- User Dropdown (Logged In) -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="flex items-center focus:outline-none group">
                                    <div class="h-8 w-8 bg-black text-white rounded-full flex items-center justify-center font-bold text-xs uppercase border border-gray-200 group-hover:bg-gray-800 transition">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span class="ml-2 text-sm font-bold uppercase hidden md:block">{{ Auth::user()->name }}</span>
                                </button>
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 shadow-lg py-1 z-50 rounded-sm" x-cloak>
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-medium">Dashboard</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-medium">Order History</a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold">Sign Out</a>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Guest (Not Logged In) -->
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('login') }}" class="text-sm font-bold uppercase tracking-wide hover:underline">Login</a>
                                <span class="text-gray-300">|</span>
                                <a href="{{ route('register') }}" class="text-sm font-bold uppercase tracking-wide hover:underline text-gray-500 hover:text-black">Register</a>
                            </div>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Carousel -->
    <div x-data="{ 
        activeSlide: 0, 
        slides: [
            { text: 'NEW SEASON ARRIVALS', sub: 'The latest drops from Nike & New Balance', image: 'https://images.unsplash.com/photo-1552346154-21d32810aba3?q=80&w=2000' },
            { text: 'STREETWEAR ICONS', sub: 'Classic silhouettes for the modern era', image: 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=2000' },
            { text: 'INDUSTRIAL AESTHETICS', sub: 'Minimalist designs for maximum impact', image: 'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?q=80&w=2000' }
        ] 
    }" 
    x-init="setInterval(() => { activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1 }, 3000)"
    class="relative h-[80vh] w-full overflow-hidden z-0">
        
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index" 
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-1000"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute inset-0 z-0">
                 
                 <img :src="slide.image" 
                      class="absolute inset-0 w-full h-full object-cover"
                      style="object-position: center 15%;"
                      alt="Hero Image">
                 
                 <div class="absolute inset-0 bg-black/40"></div>
                 <div class="absolute inset-0 flex items-center justify-center text-center">
                     <div class="max-w-4xl px-4">
                         <h2 x-text="slide.sub" class="text-white/80 text-sm md:text-lg uppercase tracking-[0.2em] mb-4 animate-fade-in-up"></h2>
                         <h1 x-text="slide.text" class="text-white text-5xl md:text-7xl font-bold brand-font tracking-tight mb-8 animate-fade-in-up-delay"></h1>
                         <a href="#shop" class="inline-block bg-white text-black px-8 py-4 text-sm font-bold uppercase tracking-wider hover:bg-black hover:text-white transition duration-300">Shop Now</a>
                     </div>
                 </div>
            </div>
        </template>
        
        <!-- Indicators -->
        <div class="absolute bottom-10 left-0 right-0 flex justify-center space-x-3">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        :class="activeSlide === index ? 'w-12 bg-white' : 'w-2 bg-white/50'"
                        class="h-1 rounded-full transition-all duration-300"></button>
            </template>
        </div>
    </div>

    <!-- Latest Arrivals (Standard Grid) with Search & Filter -->
    <section id="shop" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
                <div>
                    <h2 class="text-4xl font-bold brand-font mb-2">
                        @if(request('search'))
                            RESULTS FOR "{{ strtoupper(request('search')) }}"
                        @elseif(request('brand'))
                            {{ strtoupper(request('brand')) }}
                        @elseif(request('category'))
                            {{ strtoupper(request('category')) }}
                        @else
                            LATEST DROPS
                        @endif
                    </h2>
                    <p class="text-gray-500">
                        @if(request('search') || request('brand') || request('category'))
                            {{ $products->total() }} products found.
                        @else
                            Curated selection of premium footwear.
                        @endif
                    </p>
                </div>
                @if(request('search') || request('brand') || request('category'))
                    <a href="{{ route('home') }}#shop" class="text-sm font-bold uppercase border-b border-black pb-1 hover:text-gray-600 hover:border-gray-600 transition">Clear All Filters</a>
                @endif
            </div>

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('home') }}" class="mb-8" id="search-form">
                {{-- Preserve existing filters --}}
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('brand'))
                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                @endif
                <div class="relative max-w-2xl mx-auto">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search sneakers by name or brand..."
                           class="w-full pl-14 pr-14 py-4 bg-gray-50 border border-gray-200 rounded-full text-sm font-medium focus:ring-2 focus:ring-black focus:border-transparent focus:bg-white outline-none transition shadow-sm">
                    <button type="submit" class="absolute inset-y-0 right-2 flex items-center px-4">
                        <span class="bg-black text-white px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider hover:bg-gray-800 transition">Search</span>
                    </button>
                </div>
            </form>

            {{-- Filter Pills --}}
            <div class="mb-10 space-y-4">
                {{-- Category Filter --}}
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mr-2">Category:</span>
                    <a href="{{ route('home', array_filter(['search' => request('search'), 'brand' => request('brand')])) }}#shop"
                       class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition border
                       {{ !request('category') ? 'bg-black text-white border-black' : 'bg-white text-gray-600 border-gray-200 hover:border-black hover:text-black' }}">
                        All
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('home', array_filter(['search' => request('search'), 'brand' => request('brand'), 'category' => $cat->slug])) }}#shop"
                           class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition border
                           {{ request('category') == $cat->slug ? 'bg-black text-white border-black' : 'bg-white text-gray-600 border-gray-200 hover:border-black hover:text-black' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>

                {{-- Brand Filter --}}
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mr-2">Brand:</span>
                    <a href="{{ route('home', array_filter(['search' => request('search'), 'category' => request('category')])) }}#shop"
                       class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition border
                       {{ !request('brand') ? 'bg-black text-white border-black' : 'bg-white text-gray-600 border-gray-200 hover:border-black hover:text-black' }}">
                        All
                    </a>
                    @foreach($brands as $brand)
                        <a href="{{ route('home', array_filter(['search' => request('search'), 'category' => request('category'), 'brand' => $brand])) }}#shop"
                           class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition border
                           {{ request('brand') == $brand ? 'bg-black text-white border-black' : 'bg-white text-gray-600 border-gray-200 hover:border-black hover:text-black' }}">
                            {{ $brand }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Products Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-y-12 gap-x-8">
                @forelse($products as $product)
                <div class="group cursor-pointer">
                    <a href="{{ route('product.show', $product->slug) }}">
                        <div class="relative overflow-hidden aspect-[4/5] bg-gray-100 mb-6 group-hover:shadow-xl transition duration-500">
                            <span class="absolute top-4 left-4 bg-black text-white text-[10px] font-bold px-2 py-1 uppercase tracking-wider z-10">{{ $product->brand }}</span>
                            <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center transform group-hover:scale-105 transition duration-700 ease-in-out">
                            
                            <!-- Quick View Overlay -->
                            <div class="absolute inset-x-0 bottom-0 bg-white/90 py-3 translate-y-full group-hover:translate-y-0 transition duration-300 flex justify-center items-center">
                                <span class="text-xs font-bold uppercase tracking-widest text-black">View Details</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ $product->category->name }}</p>
                            <h3 class="text-lg font-bold brand-font leading-tight mb-2 group-hover:text-gray-600 transition">{{ $product->name }}</h3>
                            <p class="text-sm font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-span-full py-20 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold brand-font uppercase mb-2">No Products Found</h3>
                    <p class="text-gray-500 text-sm mb-6">Try adjusting your search or filter criteria.</p>
                    <a href="{{ route('home') }}#shop" class="inline-block bg-black text-white px-6 py-3 text-xs font-bold uppercase tracking-wider hover:bg-gray-800 transition">Clear Filters</a>
                </div>
                @endforelse
            </div>
            
            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="mt-16 flex justify-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </section>

    <!-- SALE SECTION (ENHANCED) -->
    <section class="py-24 bg-gray-50 border-t border-gray-200 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                <div>
                    <span class="text-red-600 font-bold tracking-widest uppercase text-sm mb-2 block animate-pulse">Limited Time Offers</span>
                    <h2 class="text-5xl font-black brand-font italic uppercase tracking-tighter mb-4">SEASON SALE</h2>
                    <p class="text-gray-500 max-w-lg">Exclusive discounts on selected premium footwear. Grab them before they are gone forever.</p>
                </div>
                <div class="mt-6 md:mt-0">
                    <a href="#" class="inline-flex items-center gap-2 text-sm font-bold uppercase bg-red-600 text-white px-6 py-3 hover:bg-red-700 transition shadow-lg hover:shadow-red-500/30">
                        View All Sale Items
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Sale Product Carousel/Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Promo Card -->
                <div class="bg-black text-white p-10 flex flex-col justify-between h-[400px] relative overflow-hidden group">
                    <img src="https://images.unsplash.com/photo-1556906781-9a412961d289?q=80&w=2000" class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:scale-110 transition duration-1000">
                    <div class="relative z-10">
                        <span class="bg-red-600 text-white text-xs font-bold px-2 py-1 uppercase tracking-wider inline-block mb-4">Final Clearance</span>
                        <h3 class="text-4xl font-black italic uppercase leading-none">UP TO <br> 70% OFF</h3>
                    </div>
                    <div class="relative z-10">
                        <p class="text-gray-300 text-sm mb-4">Nike, Adidas, Vans & More.</p>
                        <a href="#" class="text-white border-b border-white pb-1 text-sm font-bold uppercase tracking-wider hover:text-red-500 hover:border-red-500 transition">Shop Clearance</a>
                    </div>
                </div>

                <!-- Sale Product 1 (Simulated) -->
                @foreach($products->take(2) as $product)
                <div class="bg-white p-4 border border-gray-100 hover:border-gray-300 transition group relative">
                    <!-- Sale Tag -->
                    <div class="absolute top-4 left-4 z-10 flex gap-2">
                         <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-1 uppercase tracking-wider shadow-sm sale-badge">-30%</span>
                    </div>

                    <div class="aspect-square bg-gray-100 mb-6 overflow-hidden relative">
                         <img src="{{ $product->thumbnail }}" class="w-full h-full object-cover mix-blend-multiply group-hover:scale-105 transition duration-700">
                         <!-- Add to Cart (Quick) -->
                         <button class="absolute bottom-4 right-4 bg-black text-white p-3 rounded-full hover:bg-gray-800 transform translate-y-10 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition duration-300 shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                         </button>
                    </div>

                    <div>
                        <p class="text-gray-400 text-xs font-bold uppercase mb-1">{{ $product->brand }}</p>
                        <h4 class="text-lg font-bold brand-font uppercase mb-2 truncate">{{ $product->name }}</h4>
                        <div class="flex items-center gap-3">
                            <span class="text-red-600 font-bold text-lg">Rp {{ number_format($product->price * 0.7, 0, ',', '.') }}</span>
                            <span class="text-gray-400 text-sm line-through decoration-1">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black text-white py-16 border-t border-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1 md:col-span-1">
                    <h3 class="text-2xl font-bold brand-font mb-6">KICKSLAB.</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Premium footwear retailer specializing in authentic industrial hypebeast aesthetics. Worldwide shipping available.</p>
                </div>
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider mb-6">Shop</h4>
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">New Arrivals</a></li>
                        <li><a href="#" class="hover:text-white transition">Men</a></li>
                        <li><a href="#" class="hover:text-white transition">Women</a></li>
                        <li><a href="#" class="hover:text-white transition">Sale</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider mb-6">Support</h4>
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition">Shipping & Returns</a></li>
                        <li><a href="#" class="hover:text-white transition">Size Guide</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider mb-6">Newsletter</h4>
                    <p class="text-gray-400 text-sm mb-4">Subscribe for exclusive drops and offers.</p>
                    <div class="flex">
                        <input type="email" placeholder="Email Address" class="bg-transparent border-b border-gray-700 text-white w-full py-2 focus:outline-none focus:border-white transition">
                        <button class="ml-2 text-sm font-bold uppercase hover:text-gray-400">Join</button>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-900 mt-16 pt-8 text-center text-xs text-gray-600 uppercase tracking-wider">
                &copy; 2024 KICKSLAB. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
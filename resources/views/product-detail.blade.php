<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - KICKSLAB</title>
    
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
    </style>
</head>
<body class="antialiased bg-white text-black selection:bg-black selection:text-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-sm border-b border-gray-100">
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
                    <a href="#" class="text-sm font-bold uppercase tracking-wide hover:border-b-2 hover:border-black transition-all pb-1">Men</a>
                    <a href="#" class="text-sm font-bold uppercase tracking-wide hover:border-b-2 hover:border-black transition-all pb-1">Women</a>
                    
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
                            <a href="#" class="block px-4 py-2 text-sm font-medium hover:bg-gray-100">Nike</a>
                            <a href="#" class="block px-4 py-2 text-sm font-medium hover:bg-gray-100">Adidas</a>
                            <a href="#" class="block px-4 py-2 text-sm font-medium hover:bg-gray-100">New Balance</a>
                        </div>
                    </div>

                    <a href="#" class="text-sm font-bold uppercase tracking-wide text-red-600 hover:border-b-2 hover:border-red-600 transition-all pb-1">Sale</a>
                </div>

                <!-- Right Icons -->
                <div class="flex items-center space-x-6">
                    <!-- Search -->
                    <button class="hover:text-gray-600 transition focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

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
                            <!-- User Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="flex items-center focus:outline-none group">
                                    <div class="h-8 w-8 bg-black text-white rounded-full flex items-center justify-center font-bold text-xs uppercase border border-gray-200 group-hover:bg-gray-800 transition">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
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
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-medium">Riwayat Pesanan</a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold">Logout</a>
                                    </form>
                                </div>
                            </div>
                        @else
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

    <!-- Product Detail Section -->
    <main class="pt-20 min-h-screen flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                
                <!-- Left: Image -->
                <div class="relative bg-gray-50 aspect-square overflow-hidden group">
                    <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center transform group-hover:scale-105 transition duration-700 ease-in-out">
                    <div class="absolute top-4 left-4">
                        <span class="bg-black text-white text-xs font-bold px-3 py-1.5 uppercase tracking-wider">{{ $product->brand }}</span>
                    </div>
                </div>

                <!-- Right: Info -->
                <div class="flex flex-col h-full justify-center" x-data="{ selectedSize: null, showModal: false }">
                    <div class="mb-2">
                        <a href="#" class="text-sm text-gray-400 hover:text-black uppercase tracking-wide transition">{{ $product->category->name }}</a>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-bold brand-font mb-4 leading-none uppercase">{{ $product->name }}</h1>
                    
                    <div class="text-2xl font-medium mb-8">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>

                    <div class="mb-8">
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <!-- Cart Form -->
                    <form action="{{ route('cart.add', ['slug' => $product->slug]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="size" x-model="selectedSize">

                        <!-- Size Selector -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm font-bold uppercase tracking-wider">Select Size</span>
                                <a href="#" class="text-xs text-gray-400 underline hover:text-black">Size Guide</a>
                            </div>
                            <div class="grid grid-cols-4 sm:grid-cols-6 gap-3">
                                @foreach($product->sizes as $size)
                                    <button 
                                        type="button"
                                        @click="selectedSize = '{{ $size->size }}'"
                                        :class="selectedSize === '{{ $size->size }}' ? 'bg-black text-white border-black' : 'bg-white text-black border-gray-200 hover:border-black'"
                                        class="border py-3 text-sm font-bold transition duration-200 focus:outline-none flex justify-center items-center h-12"
                                        {{ $size->stock == 0 ? 'disabled' : '' }}
                                    >
                                        {{ $size->size }}
                                    </button>
                                @endforeach
                            </div>
                            <p class="text-xs text-red-500 mt-2 h-4" x-show="!selectedSize && $el.closest('form')?.submitted" x-transition>Please select a size.</p>
                        </div>

                        <!-- Add to Cart Buttons -->
                        <div class="flex items-center gap-4">
                            @auth
                                <button 
                                    type="submit"
                                    :disabled="!selectedSize"
                                    :class="!selectedSize ? 'bg-gray-200 text-gray-400 cursor-not-allowed' : 'bg-black text-white hover:bg-gray-800 transform active:scale-95'"
                                    class="flex-1 py-4 text-sm font-bold uppercase tracking-widest transition duration-200"
                                >
                                    Add to Cart
                                </button>
                            @else
                                <button 
                                    type="button"
                                    @click="showModal = true"
                                    class="flex-1 py-4 text-sm font-bold uppercase tracking-widest transition duration-200 bg-black text-white hover:bg-gray-800 transform active:scale-95"
                                >
                                    Add to Cart
                                </button>
                            @endauth

                            <button type="button" class="p-4 border border-gray-200 hover:border-black transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 border-t border-gray-100 pt-6 space-y-3">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Authenticity Guaranteed
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            Free Shipping on Orders Over Rp 5.000.000
                        </div>
                    </div>

                    <!-- Guest Login Modal -->
                    <div x-show="showModal" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showModal = false">
                                <div class="absolute inset-0 bg-gray-500 opacity-0"></div>
                            </div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative z-10 inline-block align-bottom bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                            <h3 class="text-2xl leading-6 font-bold brand-font text-gray-900 uppercase" id="modal-title">Authentication Required</h3>
                                            <div class="mt-4">
                                                <p class="text-sm text-gray-500">You must be logged in to add items to your cart. Please log in or create an account to start shopping.</p>
                                            </div>
                                            <div class="mt-8 grid grid-cols-2 gap-4">
                                                <a href="{{ route('login') }}" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-none text-sm font-bold text-white bg-black hover:bg-gray-800 uppercase tracking-widest">
                                                    Log in
                                                </a>
                                                <a href="{{ route('register') }}" class="w-full flex justify-center py-3 px-4 border border-black rounded-none text-sm font-bold text-black bg-white hover:bg-gray-50 uppercase tracking-widest">
                                                    Register
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showModal = false">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Your Cart - KICKSLAB</title>
    <meta name="description" content="Review your cart and proceed to checkout at KICKSLAB — Industrial Hypebeast Store.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&family=Inter:wght@300;400;500;600;700&family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .brand-font { font-family: 'Oswald', sans-serif; }
        .logo-font { font-family: 'Instrument Sans', sans-serif; }
        [x-cloak] { display: none !important; }

        /* Cart Item Slide In Animation */
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .cart-item-enter {
            animation: slideInLeft 0.4s ease-out both;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out both;
        }
        @keyframes bounceIn {
            0% { opacity: 0; transform: scale(0.3); }
            50% { opacity: 1; transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); }
        }
        .bounce-in {
            animation: bounceIn 0.6s ease-out both;
        }

        /* Smooth hover on cart items */
        .cart-item-row {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .cart-item-row:hover {
            background-color: #fafafa;
            transform: translateX(4px);
        }

        /* Qty button press effect */
        .qty-btn:active {
            transform: scale(0.9);
        }

        /* Sticky summary glow */
        .summary-card {
            box-shadow: 0 0 0 1px rgba(0,0,0,0.05), 0 4px 30px rgba(0,0,0,0.08);
        }
        .summary-card:hover {
            box-shadow: 0 0 0 1px rgba(0,0,0,0.1), 0 8px 40px rgba(0,0,0,0.12);
        }

        /* Checkout button shine effect */
        .checkout-btn {
            position: relative;
            overflow: hidden;
        }
        .checkout-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s ease;
        }
        .checkout-btn:hover::after {
            left: 100%;
        }

        /* Toast notification */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-100%); }
            to { opacity: 1; transform: translateY(0); }
        }
        .toast-enter {
            animation: slideDown 0.4s ease-out both;
        }
    </style>
</head>
<body class="antialiased bg-white text-black selection:bg-black selection:text-white">

    {{-- ============================================================ --}}
    {{-- NAVBAR --}}
    {{-- ============================================================ --}}
    <nav class="fixed w-full z-[100] bg-white/95 backdrop-blur-md border-b border-gray-200" x-data="{ mobileMenu: false }">
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
                    <a href="/" class="text-sm font-bold uppercase tracking-wide hover:border-b-2 hover:border-black transition-all pb-1">Home</a>
                    <a href="/#shop" class="text-sm font-bold uppercase tracking-wide hover:border-b-2 hover:border-black transition-all pb-1">Shop</a>
                    <a href="{{ route('cart.index') }}" class="text-sm font-bold uppercase tracking-wide border-b-2 border-black pb-1">Cart</a>
                </div>

                <!-- Right Icons -->
                <div class="flex items-center space-x-6">
                    <!-- Search -->
                    <a href="/#shop" class="hover:text-gray-600 transition focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </a>

                    <!-- Cart Icon (Active) -->
                    <a href="{{ route('cart.index') }}" class="relative text-black transition" id="cart-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        @php $cartCount = $carts->sum('quantity'); @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-black text-white text-[9px] font-bold w-5 h-5 flex items-center justify-center rounded-full bounce-in">
                            {{ $cartCount > 99 ? '99+' : $cartCount }}
                        </span>
                        @endif
                    </a>

                    <!-- Auth -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center focus:outline-none group">
                                <div class="h-8 w-8 bg-black text-white rounded-full flex items-center justify-center font-bold text-xs uppercase border-2 border-transparent group-hover:border-gray-300 transition">
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
                                 class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 shadow-xl py-1 z-50" x-cloak>
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-medium">Dashboard</a>
                                <a href="{{ route('cart.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-medium">My Cart</a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold">Sign Out</a>
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
                </div>

                <!-- Mobile Hamburger -->
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 hover:bg-gray-100 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" x-cloak/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenu" x-transition class="md:hidden border-t border-gray-100 py-4 space-y-2" x-cloak>
                <a href="/" class="block px-4 py-2 text-sm font-bold uppercase hover:bg-gray-50">Home</a>
                <a href="/#shop" class="block px-4 py-2 text-sm font-bold uppercase hover:bg-gray-50">Shop</a>
                <a href="{{ route('cart.index') }}" class="block px-4 py-2 text-sm font-bold uppercase bg-gray-50">Cart</a>
            </div>
        </div>
    </nav>

    {{-- ============================================================ --}}
    {{-- FLASH MESSAGES (Toast Notifications) --}}
    {{-- ============================================================ --}}
    @if(session('success') || session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="fixed top-24 left-1/2 -translate-x-1/2 z-[200] max-w-md w-full px-4">
        <div class="flex items-center gap-3 px-5 py-4 shadow-2xl border {{ session('success') ? 'bg-black text-white border-gray-800' : 'bg-red-600 text-white border-red-700' }}">
            @if(session('success'))
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            @else
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            @endif
            <p class="text-sm font-bold uppercase tracking-wide">{{ session('success') ?? session('error') }}</p>
            <button @click="show = false" class="ml-auto hover:opacity-70 transition flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>
    @endif

    {{-- ============================================================ --}}
    {{-- MAIN CONTENT — CART PAGE --}}
    {{-- ============================================================ --}}
    <main class="pt-20 min-h-screen bg-gray-50">

        {{-- Breadcrumb --}}
        <div class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex items-center text-xs text-gray-400 uppercase tracking-widest font-medium">
                    <a href="/" class="hover:text-black transition">Home</a>
                    <svg class="w-3 h-3 mx-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-black font-bold">Shopping Cart</span>
                </nav>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16">

            {{-- Page Heading --}}
            <div class="mb-10 fade-in-up">
                <h1 class="text-4xl md:text-5xl font-black italic uppercase tracking-tighter brand-font mb-2">
                    YOUR CART
                </h1>
                <p class="text-gray-400 text-sm uppercase tracking-widest font-medium">
                    @if($carts->count() > 0)
                        {{ $carts->sum('quantity') }} {{ $carts->sum('quantity') === 1 ? 'ITEM' : 'ITEMS' }} IN YOUR BAG
                    @else
                        NO ITEMS YET
                    @endif
                </p>
            </div>

            @if($carts->count() > 0)
            {{-- ======================================================== --}}
            {{-- 2-COLUMN GRID: Cart Items + Order Summary --}}
            {{-- ======================================================== --}}
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">

                {{-- ============================================ --}}
                {{-- LEFT COLUMN — Cart Items --}}
                {{-- ============================================ --}}
                <div class="w-full lg:w-2/3">
                    <div class="bg-white border border-gray-200 divide-y divide-gray-100">
                        @foreach($carts as $index => $cart)
                        <div class="cart-item-row p-5 sm:p-6" style="animation-delay: {{ $index * 0.08 }}s" id="cart-item-{{ $cart->id }}">
                            <div class="flex flex-col sm:flex-row gap-5">

                                {{-- Product Image --}}
                                <a href="{{ route('product.show', $cart->product->slug) }}" class="flex-shrink-0 w-full sm:w-28 h-28 bg-gray-100 overflow-hidden group block">
                                    <img 
                                        src="{{ $cart->product->thumbnail }}" 
                                        alt="{{ $cart->product->name }}"
                                        class="w-full h-full object-cover object-center group-hover:scale-110 transition duration-500"
                                        loading="lazy"
                                    >
                                </a>

                                {{-- Product Details --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3">
                                        {{-- Info --}}
                                        <div class="min-w-0">
                                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-1">{{ $cart->product->brand }}</p>
                                            <h3 class="text-base font-bold brand-font uppercase leading-tight mb-1 truncate">
                                                <a href="{{ route('product.show', $cart->product->slug) }}" class="hover:text-gray-600 transition">
                                                    {{ $cart->product->name }}
                                                </a>
                                            </h3>
                                            <div class="flex items-center gap-3 mb-3">
                                                <span class="inline-flex items-center gap-1.5 text-xs text-gray-500">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"></path></svg>
                                                    Size: <span class="font-bold text-black">{{ $cart->size }}</span>
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Price --}}
                                        <div class="text-right flex-shrink-0">
                                            <p class="text-lg font-bold brand-font">
                                                Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                                            </p>
                                            @if($cart->quantity > 1)
                                                <p class="text-[10px] text-gray-400 uppercase tracking-wider mt-0.5">
                                                    {{ $cart->quantity }} × Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Bottom Row: Qty Controls + Remove --}}
                                    <div class="flex items-center justify-between mt-2">
                                        {{-- Quantity Controls --}}
                                        <div class="flex items-center border border-gray-200 bg-white">
                                            <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="type" value="minus">
                                                <button type="submit" class="qty-btn w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-black hover:text-white transition-all duration-200 text-sm font-bold" aria-label="Decrease quantity">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                                                </button>
                                            </form>
                                            <span class="w-10 h-9 flex items-center justify-center text-sm font-bold select-none border-x border-gray-200 bg-gray-50">
                                                {{ $cart->quantity }}
                                            </span>
                                            <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="type" value="plus">
                                                <button type="submit" class="qty-btn w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-black hover:text-white transition-all duration-200 text-sm font-bold" aria-label="Increase quantity">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                                </button>
                                            </form>
                                        </div>

                                        {{-- Remove Button --}}
                                        <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="group/del flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-gray-400 hover:text-red-600 transition-all duration-200 py-2 px-1" aria-label="Remove item">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover/del:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span class="hidden sm:inline">Remove</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Continue Shopping Link --}}
                    <div class="mt-6 flex items-center">
                        <a href="/" class="group inline-flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-gray-500 hover:text-black transition">
                            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path></svg>
                            Continue Shopping
                        </a>
                    </div>
                </div>

                {{-- ============================================ --}}
                {{-- RIGHT COLUMN — Order Summary (Sticky) --}}
                {{-- ============================================ --}}
                @php
                    $subtotal = $carts->sum(fn($c) => $c->product->price * $c->quantity);
                    $taxRate  = 0.11; // 11% PPN
                    $tax      = $subtotal * $taxRate;
                    $serviceFee = 0; // Biaya layanan flat
                    $total    = $subtotal + $tax + $serviceFee;
                @endphp

                <div class="w-full lg:w-1/3">
                    <div class="sticky top-24">
                        <div class="summary-card bg-white border border-gray-200 p-6 lg:p-8 transition-shadow duration-300">
                            
                            {{-- Summary Heading --}}
                            <div class="flex items-center justify-between mb-8">
                                <h3 class="text-xl font-black italic uppercase tracking-tighter brand-font">Order Summary</h3>
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $carts->sum('quantity') }} Items</span>
                            </div>

                            {{-- Line Items --}}
                            <div class="space-y-4 mb-8">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Subtotal</span>
                                    <span class="text-sm font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Tax (PPN 11%)</span>
                                    <span class="text-sm font-semibold">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Shipping</span>
                                    <span class="text-xs font-bold text-green-600 uppercase tracking-wider bg-green-50 px-2 py-0.5">Free</span>
                                </div>
                                @if($serviceFee > 0)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Service Fee</span>
                                    <span class="text-sm font-semibold">Rp {{ number_format($serviceFee, 0, ',', '.') }}</span>
                                </div>
                                @endif
                            </div>

                            {{-- Divider --}}
                            <div class="border-t border-dashed border-gray-200 my-6"></div>

                            {{-- Total --}}
                            <div class="flex justify-between items-end mb-8">
                                <div>
                                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Payment</span>
                                    <span class="text-sm text-gray-500">Including tax</span>
                                </div>
                                <span class="text-3xl font-black brand-font tracking-tight">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>

                            {{-- Checkout Button --}}
                            <a href="{{ route('checkout.index') }}"
                                id="checkout-btn"
                                class="checkout-btn w-full bg-black text-white py-4 font-bold uppercase tracking-[0.15em] text-sm hover:bg-gray-900 transition-all duration-300 active:scale-[0.98] flex items-center justify-center gap-3"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Proceed to Checkout
                            </a>

                            {{-- Security Badge --}}
                            <div class="mt-6 flex items-center justify-center gap-2 text-gray-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <span class="text-[10px] uppercase font-bold tracking-[0.15em]">Secure Checkout</span>
                            </div>

                            {{-- Trust Signals --}}
                            <div class="mt-6 pt-6 border-t border-gray-100 space-y-3">
                                <div class="flex items-center gap-3 text-xs text-gray-400">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>100% Authenticity Guaranteed</span>
                                </div>
                                <div class="flex items-center gap-3 text-xs text-gray-400">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    <span>Free Shipping on All Orders</span>
                                </div>
                                <div class="flex items-center gap-3 text-xs text-gray-400">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    <span>30-Day Returns Policy</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @else
            {{-- ======================================================== --}}
            {{-- EMPTY STATE — Premium Empty Cart Design --}}
            {{-- ======================================================== --}}
            <div class="fade-in-up max-w-2xl mx-auto">
                <div class="bg-white border border-gray-200 p-12 sm:p-20 text-center">
                    
                    {{-- Animated Cart Icon --}}
                    <div class="relative inline-block mb-8">
                        <div class="w-28 h-28 bg-gray-50 rounded-full flex items-center justify-center mx-auto border border-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        {{-- Decorative dots --}}
                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-gray-200 rounded-full"></div>
                        <div class="absolute -bottom-2 -left-2 w-2 h-2 bg-gray-200 rounded-full"></div>
                        <div class="absolute top-1/2 -right-4 w-1.5 h-1.5 bg-gray-200 rounded-full"></div>
                    </div>

                    {{-- Empty State Text --}}
                    <h2 class="text-3xl sm:text-4xl font-black italic uppercase tracking-tighter brand-font mb-3">
                        Your Cart is Empty
                    </h2>
                    <p class="text-gray-400 mb-3 max-w-sm mx-auto">
                        Looks like you haven't added any kicks to your cart yet. Start exploring our collection.
                    </p>
                    <p class="text-xs text-gray-300 uppercase tracking-widest font-medium mb-10">
                        Premium footwear awaits you
                    </p>

                    {{-- CTA Button --}}
                    <a href="/" id="empty-cart-shop-btn" class="inline-flex items-center gap-3 bg-black text-white px-10 py-4 font-bold uppercase tracking-[0.15em] text-sm hover:bg-gray-800 transition-all duration-300 active:scale-95 group">
                        <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path></svg>
                        Back to Shop
                    </a>

                    {{-- Separator --}}
                    <div class="mt-12 pt-10 border-t border-gray-100">
                        <p class="text-[10px] text-gray-300 uppercase tracking-[0.2em] font-bold mb-6">Why shop with us</p>
                        <div class="grid grid-cols-3 gap-6">
                            <div class="text-center">
                                <div class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 border border-gray-100">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">Authentic</p>
                            </div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 border border-gray-100">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">Free Ship</p>
                            </div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 border border-gray-100">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </div>
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">30-Day Return</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </main>

    {{-- ============================================================ --}}
    {{-- FOOTER --}}
    {{-- ============================================================ --}}
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
                        <li><a href="/" class="hover:text-white transition">New Arrivals</a></li>
                        <li><a href="/#shop" class="hover:text-white transition">Men</a></li>
                        <li><a href="/#shop" class="hover:text-white transition">Women</a></li>
                        <li><a href="/#shop" class="hover:text-white transition">Sale</a></li>
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
                &copy; {{ date('Y') }} KICKSLAB. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>

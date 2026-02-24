<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Member Dashboard | KICKSLAB</title>
    <meta name="description" content="Your KICKSLAB Member Dashboard — Manage orders, profile, and explore exclusive drops.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .brand-font { font-family: 'Oswald', sans-serif; }
        .logo-font { font-family: 'Instrument Sans', sans-serif; }
        [x-cloak] { display: none !important; }

        /* Gradient mesh for hero */
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .gradient-mesh {
            background: linear-gradient(-45deg, #0a0a0a, #1a1a2e, #16213e, #0f3460, #0a0a0a);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        /* Slide in animation */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .slide-up {
            animation: slideUp 0.6s ease-out both;
        }
        .slide-up-1 { animation-delay: 0.1s; }
        .slide-up-2 { animation-delay: 0.2s; }
        .slide-up-3 { animation-delay: 0.3s; }
        .slide-up-4 { animation-delay: 0.4s; }
        .slide-up-5 { animation-delay: 0.5s; }
        .slide-up-6 { animation-delay: 0.6s; }

        /* Number counter animation */
        @keyframes countUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .count-up {
            animation: countUp 0.5s ease-out both;
        }

        /* Card lift on hover */
        .card-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.1);
        }

        /* Pulse ring animation */
        @keyframes pulseRing {
            0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.6); }
            70% { box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
            100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }
        .pulse-ring {
            animation: pulseRing 2s ease-in-out infinite;
        }

        /* Shine effect */
        .shine-effect {
            position: relative;
            overflow: hidden;
        }
        .shine-effect::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.05), transparent);
            transition: left 0.6s ease;
        }
        .shine-effect:hover::after {
            left: 100%;
        }

        /* Sidebar active glow */
        .sidebar-active {
            position: relative;
        }
        .sidebar-active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 60%;
            background: black;
            border-radius: 0 2px 2px 0;
        }
    </style>
</head>
<body class="bg-gray-50 text-black antialiased" x-data="{ mobileMenuOpen: false }">

    {{-- ============================================================ --}}
    {{-- NAVBAR --}}
    {{-- ============================================================ --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center">
                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="mr-4 md:hidden p-2 text-gray-400 hover:text-black focus:outline-none transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>

                    <a href="/" class="text-3xl font-black italic tracking-tighter uppercase logo-font">
                        KICKSLAB.
                    </a>
                </div>

                <div class="flex items-center gap-4 sm:gap-6">
                    <a href="/" class="hidden md:flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-black transition px-3 py-2 rounded-lg hover:bg-gray-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Back to Store
                    </a>

                    <!-- Cart Icon -->
                    <a href="{{ route('cart.index') }}" class="relative hover:text-gray-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-black text-white text-[9px] font-bold w-4 h-4 flex items-center justify-center rounded-full">
                            {{ Auth::user()->carts->count() }}
                        </span>
                    </a>

                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-xs font-bold uppercase">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider">Member</p>
                        </div>
                        <div class="h-9 w-9 bg-black text-white rounded-full flex items-center justify-center font-bold text-xs border-2 border-gray-100">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- ============================================================ --}}
    {{-- MOBILE SIDEBAR BACKDROP --}}
    {{-- ============================================================ --}}
    <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/80 backdrop-blur-sm z-40 md:hidden" x-cloak></div>

    {{-- ============================================================ --}}
    {{-- MAIN LAYOUT --}}
    {{-- ============================================================ --}}
    <div class="max-w-7xl mx-auto py-8 sm:py-10 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-8">

            {{-- ============================================================ --}}
            {{-- SIDEBAR --}}
            {{-- ============================================================ --}}
            <aside :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" class="fixed md:static inset-y-0 left-0 z-50 w-72 md:w-1/4 bg-white md:bg-transparent shadow-2xl md:shadow-none transform transition-transform duration-300 ease-in-out p-6 md:p-0">
                <div class="md:sticky md:top-24">
                    {{-- Mobile Close --}}
                    <div class="flex justify-between items-center md:hidden mb-8">
                        <span class="text-2xl font-black italic uppercase brand-font">MENU</span>
                        <button @click="mobileMenuOpen = false" class="text-gray-500 hover:text-black p-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    {{-- Profile Card --}}
                    <div class="bg-white md:border md:border-gray-200 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 hidden md:flex items-center gap-4">
                            <div class="w-12 h-12 bg-black text-white rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <nav>
                            <a href="{{ route('dashboard') }}" class="sidebar-active flex items-center gap-3 px-6 py-4 bg-gray-50 text-black font-bold uppercase text-xs tracking-widest border-l-2 border-black">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                Dashboard
                            </a>
                            <a href="{{ route('cart.index') }}" class="flex items-center gap-3 px-6 py-4 text-gray-500 hover:bg-gray-50 hover:text-black font-bold uppercase text-xs tracking-widest transition border-l-2 border-transparent hover:border-gray-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                My Cart
                                @if(Auth::user()->carts->count() > 0)
                                    <span class="ml-auto bg-black text-white text-[9px] font-bold w-5 h-5 flex items-center justify-center rounded-full">{{ Auth::user()->carts->count() }}</span>
                                @endif
                            </a>
                            <a href="#" class="flex items-center gap-3 px-6 py-4 text-gray-500 hover:bg-gray-50 hover:text-black font-bold uppercase text-xs tracking-widest transition border-l-2 border-transparent hover:border-gray-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                My Orders
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-6 py-4 text-gray-500 hover:bg-gray-50 hover:text-black font-bold uppercase text-xs tracking-widest transition border-l-2 border-transparent hover:border-gray-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profile Settings
                            </a>
                        </nav>

                        <div class="border-t border-gray-100 p-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 font-bold uppercase text-xs tracking-widest transition rounded-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- ============================================================ --}}
            {{-- MAIN CONTENT --}}
            {{-- ============================================================ --}}
            <main class="w-full md:w-3/4">

                {{-- ======================================== --}}
                {{-- WELCOME BANNER (Premium Gradient Mesh) --}}
                {{-- ======================================== --}}
                <div class="gradient-mesh text-white p-8 md:p-12 mb-8 relative overflow-hidden shadow-2xl slide-up">
                    {{-- Decorative geometric shapes --}}
                    <div class="absolute top-0 right-0 w-72 h-72 border border-white/10 rounded-full -translate-y-1/2 translate-x-1/3"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 border border-white/5 rounded-full translate-y-1/2 -translate-x-1/4"></div>
                    <div class="absolute top-6 right-10 w-2 h-2 bg-white/20 rounded-full"></div>
                    <div class="absolute top-16 right-32 w-1 h-1 bg-white/30 rounded-full"></div>
                    <div class="absolute bottom-10 right-20 w-1.5 h-1.5 bg-white/15 rounded-full"></div>

                    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <span class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur-sm text-[10px] font-bold uppercase tracking-[0.2em] text-white/80 px-3 py-1.5 rounded-full border border-white/10">
                                    <span class="w-1.5 h-1.5 bg-green-400 rounded-full pulse-ring"></span>
                                    Online
                                </span>
                                <span class="text-[10px] font-medium text-white/40 uppercase tracking-wider">Member Dashboard</span>
                            </div>
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black brand-font uppercase tracking-tighter leading-[0.9] mb-3">
                                WELCOME BACK,<br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-200 to-gray-400">{{ explode(' ', Auth::user()->name)[0] }}.</span>
                            </h1>
                            <p class="text-sm font-medium text-white/50 flex items-center gap-2 mt-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Member since {{ Auth::user()->created_at->format('F Y') }}
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="/" class="inline-flex items-center gap-2 border border-white/30 px-6 py-3 font-bold uppercase text-xs tracking-widest hover:bg-white hover:text-black transition-all duration-300 backdrop-blur-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                New Drops
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ======================================== --}}
                {{-- QUICK STATS ROW --}}
                {{-- ======================================== --}}
                <div class="grid grid-cols-3 gap-4 mb-8">
                    {{-- Stat 1: Cart Items --}}
                    <div class="card-lift bg-white border border-gray-200 p-5 text-center slide-up slide-up-1">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <p class="text-2xl font-black brand-font count-up">{{ Auth::user()->carts->sum('quantity') }}</p>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mt-1">Cart Items</p>
                    </div>

                    {{-- Stat 2: Member Days --}}
                    <div class="card-lift bg-white border border-gray-200 p-5 text-center slide-up slide-up-2">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-2xl font-black brand-font count-up">{{ Auth::user()->created_at->diffInDays(now()) }}</p>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mt-1">Days Active</p>
                    </div>

                    {{-- Stat 3: Total Orders --}}
                    <div class="card-lift bg-white border border-gray-200 p-5 text-center slide-up slide-up-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-2xl font-black brand-font count-up">{{ $stats['total'] }}</p>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mt-1">Total Orders</p>
                    </div>
                </div>

                {{-- ======================================== --}}
                {{-- ORDER STATUS GRID --}}
                {{-- ======================================== --}}
                <div class="mb-8 slide-up slide-up-3">
                    <div class="flex justify-between items-end mb-4">
                        <h3 class="text-xl font-bold brand-font uppercase tracking-tight">Order Status</h3>
                        <a href="#" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-black transition">View All</a>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                        {{-- Pending / Unpaid --}}
                        <div class="card-lift bg-white p-5 border border-gray-200 cursor-pointer group flex flex-col items-center justify-center text-center relative overflow-hidden">
                            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-amber-600 group-hover:text-white transition duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <p class="text-2xl font-black brand-font mb-1">{{ $stats['pending'] }}</p>
                            <h4 class="font-bold uppercase text-[10px] tracking-widest text-gray-400 group-hover:text-black transition">Unpaid</h4>
                        </div>

                        {{-- Paid / Processed --}}
                        <div class="card-lift bg-white p-5 border border-gray-200 cursor-pointer group flex flex-col items-center justify-center text-center relative overflow-hidden">
                            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-blue-600 group-hover:text-white transition duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-2xl font-black brand-font mb-1">{{ $stats['paid'] }}</p>
                            <h4 class="font-bold uppercase text-[10px] tracking-widest text-gray-400 group-hover:text-black transition">Paid</h4>
                        </div>

                        {{-- Shipped --}}
                        <div class="card-lift bg-white p-5 border border-gray-200 cursor-pointer group flex flex-col items-center justify-center text-center relative overflow-hidden">
                            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-purple-600 group-hover:text-white transition duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                            </div>
                            <p class="text-2xl font-black brand-font mb-1">{{ $stats['shipped'] }}</p>
                            <h4 class="font-bold uppercase text-[10px] tracking-widest text-gray-400 group-hover:text-black transition">Shipped</h4>
                        </div>

                        {{-- Completed --}}
                        <div class="card-lift bg-white p-5 border border-gray-200 cursor-pointer group flex flex-col items-center justify-center text-center relative overflow-hidden">
                            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-green-600 group-hover:text-white transition duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-2xl font-black brand-font mb-1">{{ $stats['completed'] }}</p>
                            <h4 class="font-bold uppercase text-[10px] tracking-widest text-gray-400 group-hover:text-black transition">Completed</h4>
                        </div>
                    </div>
                </div>

                {{-- ======================================== --}}
                {{-- QUICK ACTIONS --}}
                {{-- ======================================== --}}
                <div class="mb-8 slide-up slide-up-4">
                    <h3 class="text-xl font-bold brand-font uppercase tracking-tight mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                        <a href="/" class="card-lift shine-effect bg-black text-white p-5 flex flex-col gap-3 group">
                            <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold uppercase tracking-wider">Browse</p>
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider">Explore new drops</p>
                            </div>
                        </a>

                        <a href="{{ route('cart.index') }}" class="card-lift bg-white border border-gray-200 p-5 flex flex-col gap-3 group hover:border-black transition">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-black group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold uppercase tracking-wider">My Cart</p>
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider">{{ Auth::user()->carts->sum('quantity') }} items</p>
                            </div>
                        </a>

                        <a href="{{ route('profile.edit') }}" class="card-lift bg-white border border-gray-200 p-5 flex flex-col gap-3 group hover:border-black transition">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-black group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold uppercase tracking-wider">Settings</p>
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider">Edit profile</p>
                            </div>
                        </a>

                        <a href="{{ route('faq') }}" class="card-lift bg-white border border-gray-200 p-5 flex flex-col gap-3 group hover:border-black transition">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-black group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold uppercase tracking-wider">Support</p>
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider">FAQ & Bantuan</p>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- ======================================== --}}
                {{-- RECENT ORDERS --}}
                {{-- ======================================== --}}
                <div class="bg-white border border-gray-200 overflow-hidden slide-up slide-up-5">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-black text-white rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <h3 class="font-bold brand-font uppercase tracking-tight text-lg">Recent Orders</h3>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ $stats['total'] }} total pesanan</span>
                    </div>

                    @if($recentOrders->count() > 0)
                    {{-- ORDER TABLE --}}
                    <div class="divide-y divide-gray-50">
                        @foreach($recentOrders as $order)
                        @php
                            $statusConfig = [
                                'pending'              => ['bg-yellow-100 text-yellow-700',  '⏳ Pending'],
                                'pending_verification' => ['bg-amber-100 text-amber-700',    '🔍 Verifikasi'],
                                'paid'                 => ['bg-emerald-100 text-emerald-700','✅ Paid'],
                                'processing'           => ['bg-blue-100 text-blue-700',      '📦 Dikemas'],
                                'shipped'              => ['bg-indigo-100 text-indigo-700',  '🚚 Dikirim'],
                                'completed'            => ['bg-green-100 text-green-700',    '🎉 Selesai'],
                                'cancelled'            => ['bg-red-100 text-red-700',        '❌ Dibatalkan'],
                            ];
                            [$badgeCls, $badgeLabel] = $statusConfig[$order->status] ?? ['bg-gray-100 text-gray-600', $order->status];
                            // Cek sudah pernah review belum (ambil product_id dari item pertama)
                            $reviewedProductIds = \App\Models\Review::where('user_id', auth()->id())
                                ->where('order_id', $order->id)->pluck('product_id')->toArray();
                        @endphp
                        <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50/60 transition group">

                            {{-- Order Icon --}}
                            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-black group-hover:text-white transition">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>

                            {{-- Order Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-0.5">
                                    <p class="font-bold text-sm font-mono tracking-wider text-gray-900">{{ $order->order_number }}</p>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider {{ $badgeCls }}">{{ $badgeLabel }}</span>
                                    @if($order->payment_method === 'manual')
                                        <span class="text-[10px] text-gray-300 font-medium">🏦 Manual</span>
                                    @else
                                        <span class="text-[10px] text-gray-300 font-medium">💳 Midtrans</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-400">{{ $order->items->count() }} produk · {{ $order->created_at->format('d M Y') }} · {{ $order->created_at->diffForHumans() }}</p>
                            </div>

                            {{-- Total --}}
                            <div class="text-right flex-shrink-0">
                                <p class="font-black brand-font text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                {{-- Tombol aksi berdasarkan status --}}
                                @if(in_array($order->status, ['pending', 'pending_verification']))
                                    @if($order->payment_method === 'manual')
                                        <a href="{{ route('checkout.manual', $order) }}"
                                           class="inline-block mt-1 text-[10px] font-bold uppercase tracking-wider text-amber-600 hover:text-amber-800 transition">
                                            {{ $order->payment_proof ? 'Lihat Status →' : 'Upload Bukti →' }}
                                        </a>
                                    @else
                                        <a href="{{ route('checkout.midtrans', $order) }}"
                                           class="inline-block mt-1 text-[10px] font-bold uppercase tracking-wider text-blue-600 hover:text-blue-800 transition">
                                            Bayar Sekarang →
                                        </a>
                                    @endif
                                @elseif($order->status === 'paid')
                                    <span class="inline-block mt-1 text-[10px] font-bold uppercase tracking-wider text-emerald-600">✓ Dikonfirmasi Admin</span>
                                @elseif($order->status === 'processing')
                                    <span class="inline-block mt-1 text-[10px] font-bold uppercase tracking-wider text-blue-600">📦 Sedang Dikemas</span>
                                @elseif($order->status === 'shipped')
                                    <div class="flex flex-col items-end gap-1 mt-1">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600">🚚 Dalam Pengiriman</span>
                                        {{-- Tombol Review per produk yang belum diulas --}}
                                        @foreach($order->items as $item)
                                            @if($item->product && !in_array($item->product_id, $reviewedProductIds))
                                            <a href="{{ route('reviews.create', [$order, $item->product_id]) }}"
                                               class="text-[10px] font-black uppercase tracking-wider text-amber-600 hover:text-amber-800 transition">⭐ Ulas →</a>
                                            @endif
                                        @endforeach
                                    </div>
                                @elseif($order->status === 'completed')
                                    <div class="flex flex-col items-end gap-1 mt-1">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-green-600">🎉 Pesanan Selesai</span>
                                        @foreach($order->items as $item)
                                            @if($item->product)
                                                @if(!in_array($item->product_id, $reviewedProductIds))
                                                <a href="{{ route('reviews.create', [$order, $item->product_id]) }}"
                                                   class="text-[10px] font-black uppercase tracking-wider text-amber-600 hover:text-amber-800 transition">⭐ Tulis Ulasan →</a>
                                                @else
                                                <span class="text-[10px] font-bold text-gray-400">✓ Sudah Diulas</span>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                @elseif($order->status === 'cancelled')
                                    <span class="inline-block mt-1 text-[10px] font-bold uppercase tracking-wider text-red-500">Dibatalkan</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @else
                    {{-- EMPTY STATE --}}
                    <div class="p-12 sm:p-20 text-center flex flex-col items-center justify-center">
                        <div class="relative mb-8">
                            <div class="w-24 h-24 bg-gray-50 rounded-2xl flex items-center justify-center border border-gray-100 rotate-3 hover:rotate-0 transition-transform duration-500">
                                <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                        </div>
                        <h4 class="text-2xl font-black brand-font text-black mb-2 uppercase italic tracking-wide">No Orders Yet</h4>
                        <p class="text-sm text-gray-400 mb-8 max-w-sm mx-auto leading-relaxed">
                            You haven't made any purchases yet. Explore our latest collection and secure your first pair of authentic kicks.
                        </p>
                        <a href="/" class="inline-flex items-center gap-3 bg-black text-white px-8 py-4 font-bold uppercase text-xs tracking-[0.2em] hover:bg-gray-800 transition transform hover:-translate-y-0.5 shadow-lg group">
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            Start Shopping
                        </a>
                    </div>
                    @endif
                </div>

            </main>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- FOOTER --}}
    {{-- ============================================================ --}}
    <footer class="bg-black text-white py-12 border-t border-gray-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <span class="text-lg font-black italic uppercase brand-font">KICKSLAB.</span>
                    <span class="text-[10px] text-gray-600 uppercase tracking-[0.2em]">Member Area</span>
                </div>
                <p class="text-[10px] text-gray-600 uppercase tracking-[0.25em]">&copy; {{ date('Y') }} KICKSLAB. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
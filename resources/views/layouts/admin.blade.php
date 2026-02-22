<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') | KICKSLAB</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .brand-font { font-family: 'Oswald', sans-serif; }
        [x-cloak] { display: none !important; }

        /* Custom Scrollbar for Sidebar */
        .admin-sidebar::-webkit-scrollbar { width: 4px; }
        .admin-sidebar::-webkit-scrollbar-track { background: transparent; }
        .admin-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }
        .admin-sidebar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }

        /* Subtle pulse animation for active indicator */
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .pulse-dot { animation: pulse-dot 2s ease-in-out infinite; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased" x-data="{ sidebarOpen: false }">

    {{-- ============================================================ --}}
    {{-- MOBILE SIDEBAR OVERLAY --}}
    {{-- ============================================================ --}}
    <div x-show="sidebarOpen"
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/70 backdrop-blur-sm z-40 lg:hidden"
         x-cloak>
    </div>

    {{-- ============================================================ --}}
    {{-- SIDEBAR --}}
    {{-- ============================================================ --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="admin-sidebar fixed inset-y-0 left-0 z-50 w-72 bg-gray-900 text-white flex flex-col transform transition-transform duration-300 ease-in-out overflow-y-auto">

        {{-- Logo / Brand --}}
        <div class="h-20 flex items-center justify-between px-6 border-b border-white/10 flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-white text-gray-900 flex items-center justify-center font-black text-sm brand-font group-hover:bg-amber-400 transition-colors duration-300">
                    K.
                </div>
                <div>
                    <span class="text-xl font-black italic tracking-tighter uppercase brand-font block leading-none">KICKSLAB.</span>
                    <span class="text-[9px] font-semibold uppercase tracking-[0.3em] text-gray-500">Admin Panel</span>
                </div>
            </a>
            {{-- Close button (mobile) --}}
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-6 space-y-1">
            <p class="px-3 mb-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-500">Menu Utama</p>

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-200
               {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                <div class="w-8 h-8 rounded-md flex items-center justify-center {{ request()->routeIs('admin.dashboard') ? 'bg-amber-400 text-gray-900' : 'bg-white/5 text-gray-400 group-hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </div>
                <span>Dashboard</span>
                @if(request()->routeIs('admin.dashboard'))
                    <span class="ml-auto w-1.5 h-1.5 bg-amber-400 rounded-full pulse-dot"></span>
                @endif
            </a>

            {{-- Products --}}
            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-200
               {{ request()->routeIs('admin.products*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                <div class="w-8 h-8 rounded-md flex items-center justify-center {{ request()->routeIs('admin.products*') ? 'bg-amber-400 text-gray-900' : 'bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <span>Products</span>
            </a>

            {{-- Orders --}}
            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-200
               {{ request()->routeIs('admin.orders*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                <div class="w-8 h-8 rounded-md flex items-center justify-center {{ request()->routeIs('admin.orders*') ? 'bg-amber-400 text-gray-900' : 'bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <span>Orders</span>
            </a>

            {{-- Users --}}
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-200
               {{ request()->routeIs('admin.users*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                <div class="w-8 h-8 rounded-md flex items-center justify-center {{ request()->routeIs('admin.users*') ? 'bg-amber-400 text-gray-900' : 'bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <span>Users</span>
            </a>
        </nav>

        {{-- Sidebar Footer / Logout --}}
        <div class="px-4 py-5 border-t border-white/10 flex-shrink-0">
            {{-- Admin Info --}}
            <div class="flex items-center gap-3 mb-4 px-2">
                <div class="w-9 h-9 bg-amber-400 text-gray-900 rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wider">Administrator</p>
                </div>
            </div>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all duration-200">
                    <div class="w-8 h-8 rounded-md bg-red-500/10 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ============================================================ --}}
    {{-- MAIN CONTENT WRAPPER --}}
    {{-- ============================================================ --}}
    <div class="lg:ml-72 min-h-screen flex flex-col">

        {{-- Top Bar --}}
        <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-30 shadow-sm">
            {{-- Hamburger (mobile) --}}
            <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-black transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            {{-- Page Title --}}
            <div class="hidden lg:block">
                <h2 class="text-lg font-bold brand-font uppercase tracking-tight text-gray-900">@yield('page-title', 'Dashboard')</h2>
                <p class="text-[11px] text-gray-400 font-medium">@yield('page-subtitle', 'Overview & Analytics')</p>
            </div>

            {{-- Right actions --}}
            <div class="flex items-center gap-4">
                {{-- Visit Store --}}
                <a href="{{ route('home') }}"
                   class="hidden md:flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-gray-500 hover:text-black transition px-3 py-2 rounded-lg hover:bg-gray-100"
                   target="_blank">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Visit Store
                </a>

                {{-- Date --}}
                <div class="hidden sm:block text-right">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Today</p>
                    <p class="text-xs font-semibold text-gray-700">{{ now()->format('d M Y') }}</p>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-6 lg:p-8">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="py-6 px-8 border-t border-gray-200 bg-white">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-2">
                <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em]">&copy; {{ date('Y') }} KICKSLAB. Admin Panel.</p>
                <p class="text-[10px] text-gray-400">Laravel v{{ Illuminate\Foundation\Application::VERSION }}</p>
            </div>
        </footer>
    </div>

</body>
</html>

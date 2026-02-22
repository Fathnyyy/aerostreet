<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile Settings | KICKSLAB</title>
    <meta name="description" content="Manage your KICKSLAB profile — update personal info, change password, and control your account settings.">

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

        /* Slide animation */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .slide-up { animation: slideUp 0.6s ease-out both; }
        .slide-up-1 { animation-delay: 0.1s; }
        .slide-up-2 { animation-delay: 0.2s; }
        .slide-up-3 { animation-delay: 0.3s; }
        .slide-up-4 { animation-delay: 0.4s; }

        /* Card hover */
        .form-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .form-card:hover {
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        }

        /* Input focus glow */
        .input-field:focus {
            border-color: #000;
            box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
        }

        /* Toast slide */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .toast-anim {
            animation: fadeInDown 0.4s ease-out both;
        }
    </style>
</head>
<body class="bg-gray-50 text-black antialiased" x-data="{ mobileMenuOpen: false, showDeleteModal: false }">

    {{-- ============================================================ --}}
    {{-- NAVBAR --}}
    {{-- ============================================================ --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center">
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

    {{-- Mobile Sidebar Backdrop --}}
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
                    <div class="flex justify-between items-center md:hidden mb-8">
                        <span class="text-2xl font-black italic uppercase brand-font">MENU</span>
                        <button @click="mobileMenuOpen = false" class="text-gray-500 hover:text-black p-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

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
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-6 py-4 text-gray-500 hover:bg-gray-50 hover:text-black font-bold uppercase text-xs tracking-widest transition border-l-2 border-transparent hover:border-gray-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                Dashboard
                            </a>
                            <a href="{{ route('cart.index') }}" class="flex items-center gap-3 px-6 py-4 text-gray-500 hover:bg-gray-50 hover:text-black font-bold uppercase text-xs tracking-widest transition border-l-2 border-transparent hover:border-gray-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                My Cart
                            </a>
                            <a href="#" class="flex items-center gap-3 px-6 py-4 text-gray-500 hover:bg-gray-50 hover:text-black font-bold uppercase text-xs tracking-widest transition border-l-2 border-transparent hover:border-gray-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                My Orders
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-6 py-4 bg-gray-50 text-black font-bold uppercase text-xs tracking-widest border-l-2 border-black">
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
            <main class="w-full md:w-3/4 space-y-6">

                {{-- Page Header --}}
                <div class="slide-up">
                    <div class="flex items-center gap-3 mb-1">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <h1 class="text-3xl md:text-4xl font-black brand-font uppercase tracking-tighter">Profile Settings</h1>
                    </div>
                    <p class="text-sm text-gray-400 ml-8">Manage your account information and security settings.</p>
                </div>

                {{-- Flash Messages --}}
                @if (session('status') === 'profile-updated')
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                         class="toast-anim flex items-center gap-3 bg-black text-white px-5 py-4 shadow-xl">
                        <svg class="w-5 h-5 flex-shrink-0 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <p class="text-sm font-bold uppercase tracking-wide">Profile updated successfully!</p>
                        <button @click="show = false" class="ml-auto hover:opacity-70 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                @endif

                @if (session('status') === 'password-updated')
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                         class="toast-anim flex items-center gap-3 bg-black text-white px-5 py-4 shadow-xl">
                        <svg class="w-5 h-5 flex-shrink-0 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <p class="text-sm font-bold uppercase tracking-wide">Password updated successfully!</p>
                        <button @click="show = false" class="ml-auto hover:opacity-70 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                @endif

                {{-- ======================================== --}}
                {{-- SECTION 1: Profile Information --}}
                {{-- ======================================== --}}
                <div class="form-card bg-white border border-gray-200 overflow-hidden slide-up slide-up-1">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3 bg-gray-50/50">
                        <div class="w-8 h-8 bg-black text-white rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold brand-font uppercase tracking-tight text-lg">Profile Information</h3>
                            <p class="text-[11px] text-gray-400">Update your account's profile information and email address.</p>
                        </div>
                    </div>

                    <div class="p-6">
                        {{-- Avatar Preview --}}
                        <div class="flex items-center gap-5 mb-8 pb-6 border-b border-gray-100">
                            <div class="w-16 h-16 bg-black text-white rounded-full flex items-center justify-center font-bold text-xl brand-font flex-shrink-0 ring-4 ring-gray-100">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-sm">{{ $user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                <p class="text-[10px] text-gray-300 uppercase tracking-widest mt-1">Member since {{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
                            @csrf
                            @method('patch')

                            <div>
                                <label for="name" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Full Name</label>
                                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                                       class="input-field w-full px-4 py-3 border border-gray-200 text-sm font-medium bg-gray-50 focus:bg-white outline-none transition duration-200 rounded-none">
                                @error('name')
                                    <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Email Address</label>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                                       class="input-field w-full px-4 py-3 border border-gray-200 text-sm font-medium bg-gray-50 focus:bg-white outline-none transition duration-200 rounded-none">
                                @error('email')
                                    <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="mt-3 p-3 bg-amber-50 border border-amber-200">
                                        <p class="text-sm text-amber-800 flex items-center gap-2">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                                            {{ __('Your email address is unverified.') }}
                                            <button form="send-verification" class="underline font-bold text-amber-900 hover:text-amber-700">
                                                {{ __('Resend verification email.') }}
                                            </button>
                                        </p>

                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 text-sm text-green-600 font-medium">
                                                {{ __('A new verification link has been sent to your email address.') }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-4 pt-2">
                                <button type="submit" class="bg-black text-white px-8 py-3 font-bold uppercase text-xs tracking-[0.15em] hover:bg-gray-800 transition-all duration-200 active:scale-[0.98]">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ======================================== --}}
                {{-- SECTION 2: Update Password --}}
                {{-- ======================================== --}}
                <div class="form-card bg-white border border-gray-200 overflow-hidden slide-up slide-up-2">
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3 bg-gray-50/50">
                        <div class="w-8 h-8 bg-gray-800 text-white rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold brand-font uppercase tracking-tight text-lg">Security</h3>
                            <p class="text-[11px] text-gray-400">Ensure your account is using a strong password to stay secure.</p>
                        </div>
                    </div>

                    <div class="p-6">
                        <form method="post" action="{{ route('password.update') }}" class="space-y-5">
                            @csrf
                            @method('put')

                            <div>
                                <label for="update_password_current_password" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Current Password</label>
                                <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                                       class="input-field w-full px-4 py-3 border border-gray-200 text-sm font-medium bg-gray-50 focus:bg-white outline-none transition duration-200 rounded-none"
                                       placeholder="••••••••">
                                @error('current_password', 'updatePassword')
                                    <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="update_password_password" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">New Password</label>
                                    <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                                           class="input-field w-full px-4 py-3 border border-gray-200 text-sm font-medium bg-gray-50 focus:bg-white outline-none transition duration-200 rounded-none"
                                           placeholder="••••••••">
                                    @error('password', 'updatePassword')
                                        <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="update_password_password_confirmation" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Confirm Password</label>
                                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                                           class="input-field w-full px-4 py-3 border border-gray-200 text-sm font-medium bg-gray-50 focus:bg-white outline-none transition duration-200 rounded-none"
                                           placeholder="••••••••">
                                    @error('password_confirmation', 'updatePassword')
                                        <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center gap-4 pt-2">
                                <button type="submit" class="bg-black text-white px-8 py-3 font-bold uppercase text-xs tracking-[0.15em] hover:bg-gray-800 transition-all duration-200 active:scale-[0.98]">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ======================================== --}}
                {{-- SECTION 3: Danger Zone — Delete Account --}}
                {{-- ======================================== --}}
                <div class="form-card bg-white border border-red-200 overflow-hidden slide-up slide-up-3">
                    <div class="px-6 py-5 border-b border-red-100 flex items-center gap-3 bg-red-50/50">
                        <div class="w-8 h-8 bg-red-600 text-white rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold brand-font uppercase tracking-tight text-lg text-red-700">Danger Zone</h3>
                            <p class="text-[11px] text-red-400">Irreversible and destructive actions.</p>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <p class="text-sm font-bold text-gray-900 mb-1">Delete Account</p>
                                <p class="text-xs text-gray-400 leading-relaxed max-w-lg">
                                    Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.
                                </p>
                            </div>
                            <button @click="showDeleteModal = true" class="flex-shrink-0 bg-red-600 text-white px-6 py-3 font-bold uppercase text-xs tracking-[0.15em] hover:bg-red-700 transition-all duration-200 active:scale-[0.98]">
                                Delete Account
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Delete Confirmation Modal --}}
                <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-[200] overflow-y-auto" aria-labelledby="delete-title" role="dialog" aria-modal="true">
                    <div class="flex items-center justify-center min-h-screen px-4">
                        <div x-show="showDeleteModal"
                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                             @click="showDeleteModal = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>

                        <div x-show="showDeleteModal"
                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                             class="relative bg-white w-full max-w-md shadow-2xl z-10">

                            <form method="post" action="{{ route('profile.destroy') }}">
                                @csrf
                                @method('delete')

                                <div class="p-6">
                                    <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                                        <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                                    </div>

                                    <h2 class="text-xl font-black brand-font uppercase text-center mb-2" id="delete-title">
                                        Delete Your Account?
                                    </h2>
                                    <p class="text-sm text-gray-500 text-center mb-6 leading-relaxed">
                                        This will permanently delete your account, orders, and all associated data. Please enter your password to confirm.
                                    </p>

                                    <div class="mb-4">
                                        <label for="delete-password" class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Confirm Password</label>
                                        <input id="delete-password" name="password" type="password" placeholder="Enter your password"
                                               class="input-field w-full px-4 py-3 border border-gray-200 text-sm font-medium bg-gray-50 focus:bg-white outline-none transition duration-200 rounded-none">
                                        @error('password', 'userDeletion')
                                            <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 p-6 pt-0">
                                    <button type="button" @click="showDeleteModal = false" class="flex-1 py-3 border border-gray-200 font-bold uppercase text-xs tracking-wider text-gray-600 hover:bg-gray-50 transition text-center">
                                        Cancel
                                    </button>
                                    <button type="submit" class="flex-1 py-3 bg-red-600 text-white font-bold uppercase text-xs tracking-wider hover:bg-red-700 transition text-center">
                                        Delete Forever
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
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

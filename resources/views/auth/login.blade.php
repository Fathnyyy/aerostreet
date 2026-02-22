<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - KICKSLAB</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .brand-font { font-family: 'Oswald', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased text-black bg-white">

    <div class="min-h-screen flex">
        
        <!-- Left: Image -->
        <div class="hidden lg:block w-1/2 bg-gray-100 relative overflow-hidden">
            <img src="https://images.unsplash.com/photo-1514989940723-e8e51635b782?q=80&w=2000" 
                 class="absolute inset-0 w-full h-full object-cover object-center grayscale hover:grayscale-0 transition duration-1000 ease-in-out" 
                 alt="KICKSLAB Login">
            <div class="absolute inset-0 bg-black/30"></div>
            <div class="absolute bottom-10 left-10 text-white z-10">
                <h2 class="text-6xl font-black uppercase tracking-tighter brand-font mb-2">JOIN THE<br>CULTURE.</h2>
                <p class="text-lg font-medium tracking-wide opacity-90">Access exclusive drops and member-only pricing.</p>
            </div>
        </div>

        <!-- Right: Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16 relative bg-white">
            <a href="/" class="absolute top-8 right-8 text-xs font-bold uppercase tracking-widest hover:underline">
                Back to Home
            </a>

            <div class="w-full max-w-md">
                <div class="mb-10">
                    <h1 class="text-4xl font-bold brand-font uppercase tracking-tight mb-2">MEMBER LOGIN</h1>
                    <p class="text-gray-500 text-sm">Don't have an account? <a href="{{ route('register') }}" class="text-black font-bold underline hover:no-underline">Sign up Details</a></p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-[10px] font-bold uppercase tracking-widest mb-2 text-gray-500">Email Address</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                               class="w-full border border-gray-300 px-4 py-3 text-sm font-medium focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition-colors"
                               placeholder="name@example.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div x-data="{ show: false }">
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-[10px] font-bold uppercase tracking-widest text-gray-500">Password</label>
                            @if (Route::has('password.request'))
                                <a class="text-[10px] font-bold text-gray-400 hover:text-black uppercase tracking-wide" href="{{ route('password.request') }}">
                                    Forgot?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password" 
                                   class="w-full border border-gray-300 px-4 py-3 text-sm font-medium focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition-colors pr-10"
                                   placeholder="••••••••">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-black focus:outline-none">
                                <template x-if="!show">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </template>
                                <template x-if="show">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </template>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-black shadow-sm focus:ring-black" name="remember">
                            <span class="ms-2 text-xs font-bold text-gray-500 uppercase tracking-wide">Remember me</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-black text-white font-bold brand-font uppercase tracking-widest py-4 hover:bg-gray-900 transition transform active:scale-[0.99] text-sm">
                        Start Session
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
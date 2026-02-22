<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - KICKSLAB</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .brand-font { font-family: 'Oswald', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased text-black bg-white">

    <div class="min-h-screen flex flex-row-reverse">
        
        <!-- Left: Image (Reversed to Right) -->
        <div class="hidden lg:block w-1/2 bg-gray-100 relative overflow-hidden">
            <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?q=80&w=2000" 
                 class="absolute inset-0 w-full h-full object-cover object-center grayscale hover:grayscale-0 transition duration-1000 ease-in-out" 
                 alt="KICKSLAB Register">
            <div class="absolute inset-0 bg-black/30"></div>
            <div class="absolute bottom-10 right-10 text-white z-10 text-right">
                <h2 class="text-6xl font-black uppercase tracking-tighter brand-font mb-2">CREATE YOUR<br>LEGACY.</h2>
                <p class="text-lg font-medium tracking-wide opacity-90">Step into the future of streetwear.</p>
            </div>
        </div>

        <!-- Right: Form (Reversed to Left) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16 relative bg-white">
            <a href="/" class="absolute top-8 left-8 text-xs font-bold uppercase tracking-widest hover:underline">
                Back to Home
            </a>

            <div class="w-full max-w-md">
                <div class="mb-10">
                    <h1 class="text-4xl font-bold brand-font uppercase tracking-tight mb-2">BECOME A MEMBER</h1>
                    <p class="text-gray-500 text-sm">Already have an account? <a href="{{ route('login') }}" class="text-black font-bold underline hover:no-underline">Log in Here</a></p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6" x-data="{ show: false, showConfirm: false }">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-[10px] font-bold uppercase tracking-widest mb-2 text-gray-500">Full Name</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus 
                               class="w-full border border-gray-300 px-4 py-3 text-sm font-medium focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition-colors"
                               placeholder="John Doe">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-[10px] font-bold uppercase tracking-widest mb-2 text-gray-500">Email Address</label>
                        <input id="email" type="email" name="email" :value="old('email')" required 
                               class="w-full border border-gray-300 px-4 py-3 text-sm font-medium focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition-colors"
                               placeholder="name@example.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-[10px] font-bold uppercase tracking-widest mb-2 text-gray-500">Password</label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" id="password" name="password" required autocomplete="new-password"
                                   class="w-full border border-gray-300 px-4 py-3 text-sm font-medium focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition-colors pr-10"
                                   placeholder="Min. 8 characters">
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

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-[10px] font-bold uppercase tracking-widest mb-2 text-gray-500">Confirm Password</label>
                        <div class="relative">
                            <input :type="showConfirm ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                                   class="w-full border border-gray-300 px-4 py-3 text-sm font-medium focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition-colors pr-10"
                                   placeholder="Repeat password">
                            <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-black focus:outline-none">
                                <template x-if="!showConfirm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </template>
                                <template x-if="showConfirm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </template>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-black text-white font-bold brand-font uppercase tracking-widest py-4 hover:bg-gray-900 transition transform active:scale-[0.99] text-sm">
                        Create Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
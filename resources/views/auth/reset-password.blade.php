<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah Password - Aerostreet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-black bg-white">

    <div class="min-h-screen flex">
        
        <div class="hidden lg:block w-1/2 bg-gray-100 relative overflow-hidden">
            <img src="https://images.unsplash.com/photo-1595341888016-a392ef81b7de?q=80&w=2079&auto=format&fit=crop" 
                 class="absolute inset-0 w-full h-full object-cover object-center" 
                 alt="New Shoes">
            <div class="absolute bottom-10 left-10 text-white z-10">
                <h2 class="text-5xl font-black uppercase italic tracking-tighter mb-2">NEW ERA</h2>
                <p class="text-lg font-medium opacity-90 tracking-wide">Mulai langkah baru dengan style baru.</p>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16 relative">
            
            <div class="w-full max-w-md">
                <div class="mb-8">
                    <h1 class="text-3xl font-black uppercase italic tracking-tighter mb-2">BUAT PASSWORD BARU</h1>
                    <p class="text-gray-500 text-sm">Silakan masukkan password baru untuk akunmu.</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1 text-gray-400">Email</label>
                        <input type="email" name="email" :value="old('email', $request->email)" required autofocus 
                               class="w-full border-b-2 border-gray-200 py-2 text-lg font-bold text-gray-500 bg-transparent cursor-not-allowed focus:outline-none"
                               readonly>
                        @error('email') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1 text-gray-400">Password Baru</label>
                        <input type="password" name="password" required 
                               class="w-full border-b-2 border-gray-200 py-2 text-lg font-bold placeholder-gray-300 focus:outline-none focus:border-black transition-colors bg-transparent"
                               placeholder="Minimal 8 karakter">
                        @error('password') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1 text-gray-400">Ulangi Password</label>
                        <input type="password" name="password_confirmation" required 
                               class="w-full border-b-2 border-gray-200 py-2 text-lg font-bold placeholder-gray-300 focus:outline-none focus:border-black transition-colors bg-transparent"
                               placeholder="Ketik ulang password baru">
                        @error('password_confirmation') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-black text-white font-black uppercase tracking-widest py-4 hover:bg-gray-800 transition transform active:scale-95 text-sm mt-6">
                        Simpan Password Baru <span class="ml-2">→</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
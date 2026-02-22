<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password - Aerostreet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-black bg-white">

    <div class="min-h-screen flex">
        <div class="hidden lg:block w-1/2 bg-black relative overflow-hidden">
            <img src="https://images.unsplash.com/photo-1515955656352-a1fa3ffcd111?q=80&w=2070&auto=format&fit=crop" 
                 class="absolute inset-0 w-full h-full object-cover opacity-60" alt="Sepatu">
            <div class="absolute inset-0 flex items-center justify-center">
                <h2 class="text-white text-6xl font-black italic uppercase tracking-tighter">RESET<br>YOUR<br>STYLE</h2>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16 relative">
            <a href="/login" class="absolute top-8 left-8 text-xs font-bold uppercase tracking-widest hover:underline">
                ← Kembali Masuk
            </a>

            <div class="w-full max-w-md">
                <div class="mb-6">
                    <h1 class="text-3xl font-black uppercase italic tracking-tighter mb-2">LUPA PASSWORD?</h1>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Jangan panik. Masukkan email yang terdaftar, kami akan mengirimkan link untuk mereset passwordmu.
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 text-sm font-bold uppercase tracking-wide">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2 text-gray-400">Email Terdaftar</label>
                        <input type="email" name="email" :value="old('email')" required autofocus 
                               class="w-full border-b-2 border-gray-200 py-3 text-lg font-bold placeholder-gray-300 focus:outline-none focus:border-black transition-colors bg-transparent"
                               placeholder="nama@email.com">
                        @error('email') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-black text-white font-black uppercase tracking-widest py-4 hover:bg-gray-800 transition transform active:scale-95 text-sm">
                        Kirim Link Reset <span class="ml-2">→</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
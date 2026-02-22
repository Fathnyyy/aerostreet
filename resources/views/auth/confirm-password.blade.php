<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Akses - Aerostreet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-black bg-white">

    <div class="min-h-screen flex">
        
        <div class="hidden lg:block w-1/2 bg-black relative overflow-hidden">
            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=2070&auto=format&fit=crop" 
                 class="absolute inset-0 w-full h-full object-cover opacity-60" alt="Secure">
            <div class="absolute bottom-10 left-10 text-white z-10">
                <h2 class="text-5xl font-black uppercase italic tracking-tighter mb-2">SECURE<br>ACCESS</h2>
                <p class="text-lg font-medium opacity-90 tracking-wide">Konfirmasi identitas Anda untuk melanjutkan.</p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16 relative">
            <div class="w-full max-w-md">
                <div class="mb-8">
                    <h1 class="text-3xl font-black uppercase italic tracking-tighter mb-2">KONFIRMASI PASSWORD</h1>
                    <p class="text-gray-500 text-sm">Ini adalah area aman. Harap konfirmasi password Anda sebelum melanjutkan.</p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2 text-gray-400">Password Saat Ini</label>
                        <input type="password" name="password" required autocomplete="current-password" autofocus
                               class="w-full border-b-2 border-gray-200 py-3 text-lg font-bold placeholder-gray-300 focus:outline-none focus:border-black transition-colors bg-transparent"
                               placeholder="••••••••">
                        @error('password') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="w-full bg-black text-white font-black uppercase tracking-widest py-4 hover:bg-gray-800 transition transform active:scale-95 text-sm">
                            Konfirmasi <span class="ml-2">→</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
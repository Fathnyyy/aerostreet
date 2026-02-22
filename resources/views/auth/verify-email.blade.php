<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email - Aerostreet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-black bg-white">

    <div class="min-h-screen flex">
        
        <div class="hidden lg:block w-1/2 bg-gray-100 relative overflow-hidden">
            <img src="https://images.unsplash.com/photo-1579338559194-a162d19bd842?q=80&w=1974&auto=format&fit=crop" 
                 class="absolute inset-0 w-full h-full object-cover object-center" alt="Mail">
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                <h2 class="text-white text-5xl font-black uppercase italic tracking-tighter text-center">CHECK<br>YOUR<br>INBOX</h2>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16 relative">
            <div class="w-full max-w-md">
                <div class="mb-6">
                    <h1 class="text-3xl font-black uppercase italic tracking-tighter mb-4">VERIFIKASI EMAIL</h1>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">
                        Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan?
                    </p>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan yang baru.
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 p-4 bg-green-50 text-green-700 text-sm font-bold uppercase tracking-wide border border-green-200">
                        Link verifikasi baru telah dikirim ke email Anda.
                    </div>
                @endif

                <div class="mt-8 flex items-center justify-between gap-4">
                    <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full bg-black text-white font-black uppercase tracking-widest py-4 hover:bg-gray-800 transition transform active:scale-95 text-xs">
                            Kirim Ulang Email
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-black hover:underline whitespace-nowrap">
                            Keluar (Logout)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Support & FAQ | KICKSLAB</title>
    <meta name="description" content="Temukan jawaban atas pertanyaan umum seputar pemesanan, pembayaran, pengiriman, dan pengembalian produk KICKSLAB.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .brand-font { font-family: 'Oswald', sans-serif; }
        .logo-font { font-family: 'Instrument Sans', sans-serif; }
        [x-cloak] { display: none !important; }

        /* Hero gradient */
        .faq-hero {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #111827 100%);
        }

        /* Animated underline */
        @keyframes expandWidth {
            from { width: 0; }
            to { width: 100%; }
        }

        /* FAQ accordion transition */
        .faq-answer {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Category tab active indicator */
        .cat-tab.active {
            background: #000;
            color: #fff;
        }

        /* Floating label search */
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fsu { animation: fadeSlideUp 0.5s ease-out both; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }

        /* Highlight search match */
        mark { background: #fef08a; color: #000; border-radius: 2px; padding: 0 2px; }

        /* Card hover */
        .contact-card { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .contact-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="antialiased bg-white text-black selection:bg-black selection:text-white">

    <!-- ============================================================ -->
    <!-- NAVBAR -->
    <!-- ============================================================ -->
    <nav class="sticky top-0 z-[100] bg-white border-b border-gray-200" x-data="{ searchOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="text-3xl font-black italic uppercase tracking-tighter logo-font">KICKSLAB</a>

                <!-- Center Nav -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home', ['category' => 'men']) }}#shop" class="text-sm font-bold uppercase tracking-wide hover:border-b-2 hover:border-black transition-all pb-1">Men</a>
                    <a href="{{ route('home', ['category' => 'women']) }}#shop" class="text-sm font-bold uppercase tracking-wide hover:border-b-2 hover:border-black transition-all pb-1">Women</a>
                    <a href="{{ route('faq') }}" class="text-sm font-bold uppercase tracking-wide border-b-2 border-black pb-1 text-black">Support</a>
                </div>

                <!-- Right Icons -->
                <div class="flex items-center space-x-6">
                    <a href="{{ route('cart.index') }}" class="relative hover:text-gray-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold w-4 h-4 flex items-center justify-center rounded-full">
                            {{ Auth::check() ? Auth::user()->carts->count() : 0 }}
                        </span>
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-gray-600 hover:text-black transition">
                            <div class="h-8 w-8 bg-black text-white rounded-full flex items-center justify-center font-bold text-xs uppercase">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </a>
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-sm font-bold uppercase tracking-wide hover:underline">Login</a>
                            <span class="text-gray-300">|</span>
                            <a href="{{ route('register') }}" class="text-sm font-bold uppercase tracking-wide text-gray-500 hover:text-black">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ============================================================ -->
    <!-- HERO SECTION -->
    <!-- ============================================================ -->
    <section class="faq-hero text-white py-20 md:py-28 relative overflow-hidden">
        <!-- Grid texture -->
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 40px 40px;"></div>

        <!-- Decorative blobs -->
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-1/3 w-64 h-64 bg-white/3 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <div class="animate-fsu">
                <span class="inline-block text-[10px] font-bold uppercase tracking-[0.35em] text-gray-400 mb-4">Customer Support</span>
                <h1 class="text-6xl md:text-8xl font-black brand-font uppercase tracking-tighter leading-none mb-6">
                    HELP<br><span class="text-transparent" style="WebkitTextStroke: 1px rgba(255,255,255,0.3)">CENTER</span>
                </h1>
                <p class="text-gray-300 text-base md:text-lg max-w-xl mx-auto leading-relaxed mb-10">
                    Temukan jawaban cepat untuk semua pertanyaanmu seputar pemesanan, pembayaran, dan pengiriman.
                </p>
            </div>

            <!-- Live Search Bar -->
            <div class="animate-fsu delay-200 max-w-xl mx-auto"
                 x-data="{
                    search: '',
                    get isSearching() { return this.search.length > 1 }
                 }">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text"
                           x-model="search"
                           @input="$dispatch('faq-search', { query: search })"
                           placeholder="Cari pertanyaan... (mis: pembayaran, ukuran, retur)"
                           class="w-full pl-14 pr-5 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white placeholder-gray-400 rounded-xl focus:outline-none focus:border-white/50 focus:bg-white/15 transition text-sm">
                </div>
                <p x-show="isSearching" x-cloak class="text-xs text-gray-500 mt-2">Tekan Enter atau scroll ke bawah untuk melihat hasil</p>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- STATS BAR -->
    <!-- ============================================================ -->
    <div class="bg-gray-50 border-b border-gray-200 py-4">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-wrap justify-center gap-8 md:gap-16">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-gray-900">Produk Asli</p>
                        <p class="text-[10px] text-gray-400">100% Authentic</p>
                    </div>
                </div>
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-gray-900">Verifikasi 1x24 Jam</p>
                        <p class="text-[10px] text-gray-400">Pembayaran Manual</p>
                    </div>
                </div>
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-gray-900">Pengiriman Aman</p>
                        <p class="text-[10px] text-gray-400">Seluruh Indonesia</p>
                    </div>
                </div>
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-gray-900">Easy Return</p>
                        <p class="text-[10px] text-gray-400">7 Hari Retur</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- FAQ MAIN CONTENT -->
    <!-- ============================================================ -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24"
          x-data="{
              activeCategory: 'all',
              searchQuery: '',
              openItems: {},
              toggle(id) { this.openItems[id] = !this.openItems[id]; },
              isOpen(id) { return this.openItems[id] || false; },
              matchSearch(text) {
                  if (!this.searchQuery || this.searchQuery.length < 2) return true;
                  return text.toLowerCase().includes(this.searchQuery.toLowerCase());
              }
          }"
          @faq-search.window="searchQuery = $event.detail.query">

        <!-- ======================== -->
        <!-- CATEGORY TABS -->
        <!-- ======================== -->
        <div class="flex flex-wrap gap-2 mb-12 justify-center">
            @php
            $cats = [
                'all'        => ['🔍 Semua', 'all'],
                'order'      => ['🛒 Pemesanan', 'order'],
                'payment'    => ['💳 Pembayaran', 'payment'],
                'delivery'   => ['🚚 Pengiriman', 'delivery'],
                'return'     => ['🔄 Pengembalian', 'return'],
                'product'    => ['👟 Produk & Ukuran', 'product'],
                'account'    => ['👤 Akun', 'account'],
            ];
            @endphp
            @foreach($cats as $key => [$label, $val])
            <button @click="activeCategory = '{{ $val }}'"
                    :class="activeCategory === '{{ $val }}' ? 'bg-black text-white border-black' : 'bg-white text-gray-600 border-gray-200 hover:border-black hover:text-black'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider border transition-all duration-200">
                {{ $label }}
            </button>
            @endforeach
        </div>

        <!-- ======================== -->
        <!-- FAQ GROUPS -->
        <!-- ======================== -->
        @php
        $faqs = [
            [
                'cat'   => 'order',
                'icon'  => '🛒',
                'title' => 'Pemesanan',
                'items' => [
                    ['q' => 'Bagaimana cara memesan di KICKSLAB?', 'a' => 'Pilih produk yang kamu inginkan, pilih ukuran, lalu klik "Add to Cart". Setelah itu buka halaman Cart dan lanjutkan ke proses Checkout. Kamu akan diminta untuk login terlebih dahulu jika belum masuk. Isi alamat pengiriman dan pilih metode pembayaran yang kamu inginkan.'],
                    ['q' => 'Apakah saya bisa memesan tanpa membuat akun?', 'a' => 'Saat ini pemesanan hanya bisa dilakukan oleh pengguna yang sudah memiliki akun. Pendaftaran akun gratis dan hanya membutuhkan beberapa menit. Akun juga berguna untuk melacak status pesananmu.'],
                    ['q' => 'Berapa lama pesanan saya diproses?', 'a' => 'Untuk pembayaran via Midtrans (kartu/transfer online), pesanan langsung diproses setelah pembayaran terkonfirmasi otomatis. Untuk transfer manual, pesananmu akan diproses dalam 1×24 jam setelah admin memverifikasi bukti pembayaranmu.'],
                    ['q' => 'Bisakah saya mengubah atau membatalkan pesanan?', 'a' => 'Pembatalan pesanan dapat dilakukan sebelum admin mengkonfirmasi pembayaran. Setelah pembayaran dikonfirmasi dan status berubah menjadi "Paid", pesanan tidak dapat dibatalkan. Silakan hubungi kami melalui WhatsApp atau email sesegera mungkin jika ingin membatalkan.'],
                    ['q' => 'Apakah stok selalu tersedia?', 'a' => 'Stok produk kami update secara real-time. Namun pada saat ramai, bisa saja terjadi kehabisan stok. Kami sarankan untuk segera menyelesaikan pembayaran setelah checkout untuk mengamankan pesananmu.'],
                ],
            ],
            [
                'cat'   => 'payment',
                'icon'  => '💳',
                'title' => 'Pembayaran',
                'items' => [
                    ['q' => 'Metode pembayaran apa saja yang tersedia?', 'a' => 'KICKSLAB menyediakan dua metode pembayaran: (1) Midtrans — mendukung berbagai metode seperti QRIS, Virtual Account (BCA, Mandiri, BNI, BRI), kartu kredit/debit, dan GoPay. (2) Transfer Manual — transfer langsung ke rekening bank kami (BCA atau Mandiri), lalu upload bukti transfer.'],
                    ['q' => 'Bagaimana cara melakukan transfer manual?', 'a' => 'Setelah checkout dan memilih "Bank Transfer Manual", kamu akan diarahkan ke halaman instruksi transfer. Transfer sesuai nominal yang tertera ke rekening yang tersedia (BCA atau Mandiri). Setelah transfer, upload foto/screenshot bukti pembayaran di halaman tersebut. Admin akan memverifikasi dalam 1×24 jam.'],
                    ['q' => 'Berapa lama verifikasi pembayaran manual?', 'a' => 'Verifikasi transfer manual dilakukan oleh tim kami dalam waktu maksimal 1×24 jam di hari kerja (Senin–Jumat, 09.00–17.00 WIB). Kamu akan mendapatkan notifikasi perubahan status di dashboard.'],
                    ['q' => 'Apakah pembayaran Midtrans aman?', 'a' => 'Ya, Midtrans adalah payment gateway resmi dan tersertifikasi PCI DSS yang digunakan oleh ribuan merchant di Indonesia. Semua data transaksi dienkripsi dan aman. KICKSLAB tidak menyimpan data kartu kreditmu.'],
                    ['q' => 'Apa yang terjadi jika pembayaran manual saya ditolak?', 'a' => 'Jika bukti pembayaran yang kamu upload tidak valid atau nominal tidak sesuai, admin akan menolak verifikasi dan status pesananmu akan berubah menjadi "Cancelled". Kamu bisa membuat pesanan baru dan menghubungi kami jika ada pertanyaan lebih lanjut.'],
                    ['q' => 'Apakah ada biaya tambahan atau pajak?', 'a' => 'Harga yang tertera sudah termasuk PPN 11%. Tidak ada biaya tersembunyi. Untuk pengiriman, saat ini kami menawarkan free ongkir untuk semua pesanan.'],
                ],
            ],
            [
                'cat'   => 'delivery',
                'icon'  => '🚚',
                'title' => 'Pengiriman',
                'items' => [
                    ['q' => 'Berapa lama estimasi pengiriman?', 'a' => 'Estimasi pengiriman tergantung lokasi tujuan: Jabodetabek 1–2 hari kerja, Jawa 2–3 hari kerja, Luar Jawa 3–5 hari kerja. Estimasi dihitung mulai dari tanggal pesanan diproses (status "Shipped").'],
                    ['q' => 'Berapa ongkos kirim yang dikenakan?', 'a' => 'Saat ini KICKSLAB menawarkan FREE ONGKIR untuk semua pesanan ke seluruh Indonesia! Tidak ada minimum pembelian.'],
                    ['q' => 'Jasa pengiriman apa yang digunakan?', 'a' => 'Kami menggunakan JNE, J&T, SiCepat, dan AnterAja tergantung ketersediaan di lokasi pickup. Kami akan memilihkan jasa kurir terbaik untuk area tujuanmu.'],
                    ['q' => 'Bagaimana cara melacak pesanan saya?', 'a' => 'Setelah pesanan berstatus "Shipped", nomor resi akan dikirimkan melalui email dan bisa dilihat di halaman detail pesananmu di dashboard. Gunakan nomor resi tersebut untuk melacak di situs resmi jasa kurir.'],
                    ['q' => 'Apakah pesanan dikemas dengan aman?', 'a' => 'Tentu! Setiap produk dikemas dengan bubble wrap dan kardus tebal untuk melindungi sepatu dari kerusakan selama pengiriman. Produk premium mendapatkan packaging khusus dengan KICKSLAB branded box.'],
                ],
            ],
            [
                'cat'   => 'return',
                'icon'  => '🔄',
                'title' => 'Pengembalian & Retur',
                'items' => [
                    ['q' => 'Apakah KICKSLAB menerima pengembalian produk?', 'a' => 'Ya, kami menerima pengembalian produk dalam kondisi tertentu. Retur dapat dilakukan dalam 7 hari setelah produk diterima, dengan syarat: produk masih dalam kondisi baru/belum dipakai, tag/label masih terpasang, dan disertai alasan yang valid (salah ukuran, cacat produksi, produk tidak sesuai deskripsi).'],
                    ['q' => 'Bagaimana cara mengajukan retur?', 'a' => 'Hubungi tim support kami via WhatsApp atau email dengan menyertakan: nomor order, foto produk yang ingin diretur, dan alasan pengembalian. Tim kami akan merespons dalam 1×24 jam dan memberikan instruksi selanjutnya.'],
                    ['q' => 'Apakah ongkos kirim retur ditanggung KICKSLAB?', 'a' => 'Jika pengembalian disebabkan oleh kesalahan kami (salah produk, cacat produksi), ongkos kirim retur ditanggung sepenuhnya oleh KICKSLAB. Jika karena alasan personal (salah pesan ukuran), ongkos kirim menjadi tanggungan customer.'],
                    ['q' => 'Berapa lama proses refund?', 'a' => 'Setelah produk retur kami terima dan diverifikasi (2–3 hari kerja), refund akan diproses dalam 3–7 hari kerja tergantung metode pembayaran awal. Refund untuk Midtrans dikembalikan ke metode pembayaran asli, sementara transfer manual dikembalikan via transfer bank.'],
                ],
            ],
            [
                'cat'   => 'product',
                'icon'  => '👟',
                'title' => 'Produk & Ukuran',
                'items' => [
                    ['q' => 'Bagaimana cara menentukan ukuran yang tepat?', 'a' => 'Kami menggunakan ukuran standar internasional (US sizing). Sebagai panduan umum: ukur panjang kaki menggunakan penggaris, lalu cocokkan dengan size chart. Untuk brand tertentu (seperti Nike vs Adidas), ukuran bisa sedikit berbeda. Disarankan untuk membeli ukuran yang sama dengan yang biasa kamu pakai.'],
                    ['q' => 'Apakah semua produk yang dijual 100% original?', 'a' => 'MUTLAK YA! KICKSLAB hanya menjual produk 100% authentic/original. Kami mendapatkan produk langsung dari distributor resmi dan brand. Setiap produk dilengkapi dengan box original, tag, dan kartu garansi (jika ada). Kami berani memberikan refund penuh jika produk terbukti tidak original.'],
                    ['q' => 'Apa yang dimaksud dengan kondisi "Deadstock"?', 'a' => 'Deadstock berarti sepatu dalam kondisi baru, belum pernah dipakai, masih dalam box original, dan sudah tidak diproduksi lagi. Biasanya harganya lebih tinggi karena kelangkaannya.'],
                    ['q' => 'Apakah foto produk sesuai dengan kondisi aslinya?', 'a' => 'Ya, foto produk yang kami tampilkan adalah foto asli produk yang kami miliki (bukan foto dari brand). Kami berusaha memotret dari berbagai sudut agar kamu bisa melihat kondisi produk dengan jelas.'],
                ],
            ],
            [
                'cat'   => 'account',
                'icon'  => '👤',
                'title' => 'Akun & Keamanan',
                'items' => [
                    ['q' => 'Bagaimana cara mendaftar akun KICKSLAB?', 'a' => 'Klik tombol "Register" di pojok kanan atas halaman, isi nama, email, dan password, lalu klik "Daftar". Kamu langsung bisa berbelanja setelah akun dibuat.'],
                    ['q' => 'Bagaimana jika saya lupa password?', 'a' => 'Klik "Login" > "Forgot Password", masukkan emailmu, dan kami akan mengirimkan link reset password ke emailmu. Link berlaku selama 60 menit.'],
                    ['q' => 'Apakah data pribadi saya aman?', 'a' => 'Keamanan data adalah prioritas kami. Data pribadi kamu disimpan secara aman dan terenkripsi. Kami tidak pernah menjual atau membagikan data kamu ke pihak ketiga tanpa persetujuanmu. Selengkapnya bisa kamu baca di Kebijakan Privasi kami.'],
                    ['q' => 'Bisakah saya punya lebih dari satu akun?', 'a' => 'Tidak disarankan. Satu email hanya bisa digunakan untuk satu akun. Memiliki beberapa akun dapat menyebabkan masalah pelacakan pesanan dan riwayat pembelian.'],
                ],
            ],
        ];
        @endphp

        @php $itemIdx = 0; @endphp

        @foreach($faqs as $group)
        @php $groupCat = $group['cat']; @endphp
        <div x-show="activeCategory === 'all' || activeCategory === '{{ $groupCat }}'"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="mb-12">

            <!-- Group Header -->
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gray-900 rounded-xl flex items-center justify-center text-lg flex-shrink-0">
                    {{ $group['icon'] }}
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-black brand-font uppercase tracking-tight text-gray-900">{{ $group['title'] }}</h2>
                    <p class="text-xs text-gray-400 uppercase tracking-widest">{{ count($group['items']) }} pertanyaan</p>
                </div>
                <div class="h-px flex-1 bg-gray-100 max-w-[200px] hidden md:block"></div>
            </div>

            <!-- FAQ Items -->
            <div class="space-y-2">
                @foreach($group['items'] as $faq)
                @php $itemIdx++; $id = 'faq-' . $itemIdx; @endphp
                <div x-show="matchSearch('{{ addslashes($faq['q']) }} {{ addslashes($faq['a']) }}')"
                     class="border border-gray-200 rounded-xl overflow-hidden hover:border-gray-300 transition-colors">

                    <!-- Question (Toggle) -->
                    <button @click="toggle('{{ $id }}')"
                            class="w-full flex items-center justify-between px-6 py-5 text-left group bg-white hover:bg-gray-50/70 transition-colors"
                            :class="isOpen('{{ $id }}') ? 'bg-gray-50' : ''">
                        <span class="font-semibold text-gray-900 text-sm md:text-base pr-4 leading-snug">{{ $faq['q'] }}</span>
                        <div class="flex-shrink-0 w-7 h-7 rounded-full border-2 border-gray-200 flex items-center justify-center transition-all duration-300"
                             :class="isOpen('{{ $id }}') ? 'bg-black border-black rotate-45' : 'group-hover:border-gray-400'">
                            <svg class="w-3.5 h-3.5 transition-colors" :class="isOpen('{{ $id }}') ? 'text-white' : 'text-gray-400'"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v12M6 12h12"/>
                            </svg>
                        </div>
                    </button>

                    <!-- Answer -->
                    <div x-show="isOpen('{{ $id }}')"
                         x-collapse
                         x-cloak>
                        <div class="px-6 pb-5 pt-0 bg-gray-50 border-t border-gray-100">
                            <p class="text-gray-600 text-sm leading-relaxed pt-4">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <!-- Not Found State saat search -->
        <div x-show="searchQuery.length > 1"
             x-data
             class="text-center py-12 hidden"
             :class="{ 'hidden': false }"
             x-cloak>
            <p class="text-sm text-gray-400">Tidak ada pertanyaan yang cocok dengan "<span class="font-bold text-gray-600" x-text="searchQuery"></span>"</p>
        </div>

    </main>

    <!-- ============================================================ -->
    <!-- CONTACT SECTION -->
    <!-- ============================================================ -->
    <section class="bg-gray-50 border-t border-gray-200 py-16 md:py-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-400">Masih ada pertanyaan?</span>
                <h2 class="text-4xl md:text-5xl font-black brand-font uppercase tracking-tighter mt-2">HUBUNGI KAMI</h2>
                <p class="text-gray-500 text-sm mt-3">Tim support kami siap membantu kamu setiap hari kerja.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <!-- WhatsApp -->
                <a href="https://wa.me/6281234567890?text=Halo%20KICKSLAB%2C%20saya%20butuh%20bantuan%20mengenai..."
                   target="_blank" rel="noopener"
                   class="contact-card bg-white border border-gray-200 rounded-2xl p-7 text-center group">
                    <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.116 1.522 5.845L.057 23.487a1 1 0 001.22 1.22l5.706-1.453A11.937 11.937 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.859 0-3.6-.504-5.096-1.382l-.344-.208-3.562.907.924-3.489-.228-.36A9.943 9.943 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/>
                        </svg>
                    </div>
                    <h3 class="font-black brand-font uppercase tracking-tight text-lg mb-1">WhatsApp</h3>
                    <p class="text-sm text-gray-500 mb-3">Respon tercepat! Biasanya < 1 jam</p>
                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">+62 812-3456-7890</span>
                    <div class="mt-4 flex items-center justify-center gap-1.5">
                        <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Online 08.00–21.00</span>
                    </div>
                </a>

                <!-- Email -->
                <a href="mailto:support@kickslab.id?subject=Pertanyaan%20tentang%20pesanan"
                   class="contact-card bg-white border border-gray-200 rounded-2xl p-7 text-center group">
                    <div class="w-14 h-14 bg-blue-500 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-black brand-font uppercase tracking-tight text-lg mb-1">Email</h3>
                    <p class="text-sm text-gray-500 mb-3">Untuk pertanyaan detail & dokumentasi</p>
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">support@kickslab.id</span>
                    <div class="mt-4 flex items-center justify-center gap-1.5">
                        <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Respon 1×24 Jam</span>
                    </div>
                </a>

                <!-- Instagram -->
                <a href="https://instagram.com/kickslab.id" target="_blank" rel="noopener"
                   class="contact-card bg-white border border-gray-200 rounded-2xl p-7 text-center group">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform"
                         style="background: linear-gradient(135deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                    <h3 class="font-black brand-font uppercase tracking-tight text-lg mb-1">Instagram</h3>
                    <p class="text-sm text-gray-500 mb-3">DM kami untuk pertanyaan singkat</p>
                    <span class="text-xs font-bold uppercase tracking-wider" style="color: #dc2743;">@kickslab.id</span>
                    <div class="mt-4 flex items-center justify-center gap-1.5">
                        <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Follow untuk Update</span>
                    </div>
                </a>
            </div>

            <!-- My Orders CTA -->
            @auth
            <div class="mt-10 bg-black text-white rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-400 mb-1">Punya pesanan aktif?</p>
                    <h3 class="text-2xl font-black brand-font uppercase tracking-tight">Cek Status Pesananmu</h3>
                    <p class="text-gray-400 text-sm mt-1">Lihat semua riwayat order dan status pembayaranmu di sini.</p>
                </div>
                <a href="{{ route('dashboard') }}"
                   class="flex-shrink-0 flex items-center gap-2.5 px-8 py-4 bg-white text-black font-black text-sm uppercase tracking-wider rounded-xl hover:bg-gray-100 transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    My Orders
                </a>
            </div>
            @else
            <div class="mt-10 bg-black text-white rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-400 mb-1">Pelanggan baru?</p>
                    <h3 class="text-2xl font-black brand-font uppercase tracking-tight">Mulai Belanja Sekarang</h3>
                    <p class="text-gray-400 text-sm mt-1">Buat akun gratis dan dapatkan akses ke koleksi terbaru.</p>
                </div>
                <a href="{{ route('register') }}"
                   class="flex-shrink-0 flex items-center gap-2.5 px-8 py-4 bg-white text-black font-black text-sm uppercase tracking-wider rounded-xl hover:bg-gray-100 transition-all active:scale-95">
                    Daftar Sekarang →
                </a>
            </div>
            @endauth
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- FOOTER -->
    <!-- ============================================================ -->
    <footer class="bg-black text-white py-12 border-t border-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="text-2xl font-black italic uppercase tracking-tighter logo-font">KICKSLAB</a>
                    <span class="text-[10px] text-gray-600 uppercase tracking-[0.2em]">Support Center</span>
                </div>
                <div class="flex items-center gap-6 text-xs text-gray-500 uppercase tracking-widest">
                    <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                    <a href="{{ route('faq') }}" class="text-white">FAQ</a>
                    <a href="{{ route('cart.index') }}" class="hover:text-white transition">Cart</a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-white transition">Dashboard</a>
                    @endauth
                </div>
            </div>
            <div class="border-t border-gray-900 mt-8 pt-8 text-center text-[10px] text-gray-600 uppercase tracking-wider">
                &copy; {{ date('Y') }} KICKSLAB. All rights reserved. — 100% Authentic Footwear
            </div>
        </div>
    </footer>

</body>
</html>

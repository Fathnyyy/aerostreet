# BAB II
# LANDASAN TEORI

---

## 2.1 Konsep Dasar E-Commerce

### 2.1.1 Definisi E-Commerce

E-commerce (electronic commerce) atau perdagangan elektronik merupakan suatu proses pembelian, penjualan, transfer, atau pertukaran produk, layanan, atau informasi melalui jaringan komputer, termasuk internet (Turban et al., 2018). Laudon & Traver (2021) mendefinisikan e-commerce sebagai penggunaan internet, web, dan aplikasi mobile untuk transaksi bisnis, yang meliputi transaksi komersial antara pihak-pihak yang saling terhubung secara digital.

Menurut Kotler & Armstrong (2020), e-commerce bukan sekadar tentang menjual produk secara online, melainkan tentang membangun hubungan pelanggan, menciptakan nilai, dan memberikan pengalaman belanja yang mulus dari mana saja dan kapan saja. Dalam konteks penelitian ini, sistem **Aerostreet** dibangun sebagai platform e-commerce Business-to-Consumer (B2C) yang memungkinkan konsumen membeli produk sepatu secara online dengan berbagai pilihan metode pembayaran.

### 2.1.2 Jenis-Jenis E-Commerce

Berdasarkan hubungan antar pelakunya, e-commerce diklasifikasikan menjadi beberapa tipe (Turban et al., 2018):

1. **Business-to-Consumer (B2C):** Model di mana bisnis menjual produk atau jasa langsung kepada konsumen akhir. Ini merupakan model yang diterapkan pada sistem Aerostreet, di mana toko selaku penjual berinteraksi langsung dengan pembeli individu.

2. **Business-to-Business (B2B):** Transaksi yang terjadi antar perusahaan, misalnya antara produsen dan distributor.

3. **Consumer-to-Consumer (C2C):** Transaksi yang terjadi antar konsumen, seperti yang terjadi pada platform marketplace Tokopedia dan Shopee.

4. **Consumer-to-Business (C2B):** Konsumen menawarkan produk atau jasanya kepada bisnis, seperti platform freelance.

### 2.1.3 Komponen Utama Sistem E-Commerce

Sistem e-commerce yang lengkap mencakup beberapa komponen kunci (Chaffey, 2019):

- **Katalog Produk Digital:** Tampilan produk yang informatif beserta gambar, harga, deskripsi, dan stok.
- **Keranjang Belanja (Shopping Cart):** Fitur yang memungkinkan pengguna mengumpulkan produk sebelum melakukan pembelian.
- **Sistem Manajemen Pesanan:** Pengelolaan siklus hidup pesanan dari pembuatan hingga penyelesaian.
- **Payment Gateway:** Integrasi dengan layanan pembayaran untuk memproses transaksi secara aman.
- **Manajemen Pengguna:** Sistem autentikasi, otorisasi, dan pengelolaan profil pelanggan.
- **Panel Administrasi:** Antarmuka khusus bagi pengelola toko untuk mengelola produk, pesanan, dan pengguna.
- **Sistem Ulasan Produk:** Mekanisme bagi pelanggan untuk memberikan penilaian dan komentar atas produk yang dibeli.

---

## 2.2 Website

### 2.2.1 Definisi Website

Website adalah kumpulan halaman web yang saling terhubung dan dapat diakses melalui internet menggunakan peramban web (browser). Menurut Sibero (2013), website adalah suatu sistem yang berkaitan dengan dokumen yang digunakan sebagai media untuk menampilkan teks, gambar, multimedia, dan lainnya pada jaringan internet. Suatu website dapat diakses oleh siapapun di seluruh dunia selama terhubung dengan jaringan internet.

### 2.2.2 Jenis Website

Berdasarkan sifat kontennya, website dibedakan menjadi dua jenis utama:

1. **Website Statis:** Website yang kontennya tidak berubah setiap kali diakses. Konten halaman web statis dibuat dengan kode HTML murni dan tidak memerlukan interaksi dengan basis data. Kelebihan website statis adalah loading yang cepat, namun kekurangannya adalah sulitnya pembaruan konten.

2. **Website Dinamis:** Website yang kontennya dapat berubah setiap kali diakses, tergantung pada interaksi pengguna atau data dari basis data. Sistem Aerostreet adalah contoh website dinamis, di mana konten halaman—seperti daftar produk, status pesanan, dan ulasan—diambil secara real-time dari basis data MySQL dan dirender oleh server menggunakan engine templating Blade milik Laravel.

### 2.2.3 Arsitektur Client-Server

Website modern bekerja berbasis arsitektur client-server. Dalam arsitektur ini, browser pengguna (client) mengirimkan permintaan (HTTP Request) ke server web. Server kemudian memproses permintaan tersebut—termasuk berinteraksi dengan basis data—dan mengembalikan respons (HTTP Response) berupa halaman HTML yang ditampilkan oleh browser. Sistem Aerostreet menggunakan arsitektur ini dengan PHP yang dijalankan di sisi server dan Vite sebagai bundler aset di sisi pengembangan.

---

## 2.3 PHP (Hypertext Preprocessor)

### 2.3.1 Definisi PHP

PHP (Hypertext Preprocessor) adalah bahasa skrip sisi-server (server-side scripting language) yang dirancang khusus untuk pengembangan web. PHP dapat disematkan langsung ke dalam kode HTML, atau digunakan secara terpisah dalam kerangka kerja (framework). Perintah-perintah PHP dieksekusi di sisi server dan menghasilkan HTML murni yang dikirimkan ke browser klien (Welling & Thomson, 2016).

PHP pertama kali diciptakan oleh Rasmus Lerdorf pada tahun 1994 dan kini dikelola oleh The PHP Group. PHP adalah bahasa open-source yang didukung oleh komunitas pengembang yang sangat besar di seluruh dunia. Sistem Aerostreet dibangun menggunakan **PHP versi 8.2**, yang membawa fitur-fitur modern seperti:

- **Fibers:** Untuk concurrency ringan.
- **Enums:** Tipe data enumerasi native.
- **Named Arguments & Match Expression:** Meningkatkan keterbacaan kode.
- **Union Types & Intersection Types:** Pengetikan yang lebih ketat.

### 2.3.2 Kelebihan PHP

PHP memiliki sejumlah keunggulan yang menjadikannya bahasa yang paling banyak digunakan untuk pengembangan web sisi server (Welling & Thomson, 2016):

1. **Open Source:** PHP bersifat gratis dan bebas digunakan.
2. **Mudah Dipelajari:** Sintaks PHP relatif sederhana dan mudah dipahami.
3. **Kompatibilitas Luas:** PHP dapat dijalankan di berbagai sistem operasi (Linux, Windows, macOS) dan mendukung berbagai basis data.
4. **Komunitas Besar:** Tersedia dokumentasi lengkap dan komunitas yang aktif.
5. **Integrasi dengan MySQL:** PHP memiliki integrasi yang sangat baik dengan MySQL melalui ekstensi PDO dan MySQLi.

---

## 2.4 Framework Laravel

### 2.4.1 Definisi dan Sejarah Laravel

Laravel adalah framework PHP sisi-server yang bersumber terbuka (open-source), bersifat elegan, dan ekspresif, dirancang untuk mempermudah pengembangan aplikasi web. Laravel diciptakan oleh Taylor Otwell dan pertama kali dirilis pada tahun 2011 sebagai alternatif yang lebih modern dari framework CodeIgniter. Sejak saat itu, Laravel telah menjadi framework PHP paling populer di dunia berdasarkan jumlah bintang di GitHub dan tren pencarian di Google.

Penelitian ini menggunakan **Laravel versi 12**, yang merupakan versi terbaru dengan dukungan penuh untuk PHP 8.2+, performa yang ditingkatkan, dan berbagai penyempurnaan dari sisi internal framework.

### 2.4.2 Pola Arsitektur MVC

Laravel mengimplementasikan pola desain **Model-View-Controller (MVC)**, yang merupakan pola arsitektur perangkat lunak yang memisahkan logika aplikasi ke dalam tiga komponen yang saling berhubungan (Gamma et al., 1994):

#### a. Model

Model adalah komponen yang bertanggung jawab untuk mengelola data dan logika bisnis aplikasi. Dalam Laravel, Model merepresentasikan tabel di basis data dan menggunakan ORM (Object-Relational Mapping) bernama **Eloquent**. Setiap model merupakan sebuah kelas PHP yang memperluas kelas dasar `Illuminate\Database\Eloquent\Model`.

Pada sistem Aerostreet, terdapat 8 (delapan) model utama yang masing-masing merepresentasikan entitas data:

| No | Nama Model     | Tabel Database   | Fungsi Utama                                          |
|----|----------------|------------------|-------------------------------------------------------|
| 1  | `User`         | `users`          | Data akun pengguna, autentikasi, dan peran (role)     |
| 2  | `Product`      | `products`       | Data katalog produk sepatu                            |
| 3  | `Category`     | `categories`     | Kategori produk (misal: Running, Casual, Basketball)  |
| 4  | `ProductSize`  | `product_sizes`  | Stok dan ukuran per produk                            |
| 5  | `Cart`         | `carts`          | Item di keranjang belanja pengguna                    |
| 6  | `Order`        | `orders`         | Data transaksi pemesanan                              |
| 7  | `OrderItem`    | `order_items`    | Detail item dalam setiap pesanan                      |
| 8  | `Review`       | `reviews`        | Ulasan dan rating produk dari pelanggan               |

#### b. View

View adalah komponen yang bertanggung jawab untuk menampilkan data kepada pengguna akhir. Dalam Laravel, View diimplementasikan menggunakan **Blade Templating Engine**—sebuah mesin templating ringan namun powerful yang disediakan oleh Laravel. File-file Blade disimpan di direktori `resources/views/` dengan ekstensi `.blade.php`.

Blade memungkinkan pengembang menulis kode PHP yang bersih dan terekspresi di dalam templat HTML, menggunakan sintaks `@directive` seperti:
- `@if`, `@else`, `@endif` untuk percabangan kondisional
- `@foreach`, `@endforeach` untuk perulangan koleksi data
- `@extends`, `@section`, `@yield` untuk pewarisan layout (template inheritance)
- `{{ $variabel }}` untuk output data yang di-escape (aman dari XSS)
- `{!! $variabel !!}` untuk output HTML mentah (raw output)

#### c. Controller

Controller adalah komponen yang bertindak sebagai perantara (mediator) antara Model dan View. Controller menerima HTTP request dari pengguna, memanggil Model yang sesuai untuk mengambil atau memanipulasi data, lalu meneruskan data tersebut ke View untuk ditampilkan.

Pada sistem Aerostreet, controller diorganisasi ke dalam dua kelompok:

**Controller Pengguna (Customer Area):**
- `HomeController` — Mengelola halaman beranda dan katalog produk.
- `ProductController` — Mengelola halaman detail produk.
- `CartController` — Mengelola operasi keranjang belanja (tambah, ubah, hapus).
- `CheckoutController` — Mengelola proses checkout, integrasi Midtrans, dan upload bukti bayar.
- `ReviewController` — Mengelola pengiriman dan penghapusan ulasan produk.
- `ProfileController` — Mengelola pembaruan informasi profil pengguna.

**Controller Administrator (Admin Area):**
- `Admin\DashboardController` — Mengelola halaman ringkasan statistik admin.
- `Admin\ProductController` — Mengelola CRUD produk (Create, Read, Update, Delete).
- `Admin\OrderController` — Mengelola manajemen dan pembaruan status pesanan.
- `Admin\UserController` — Mengelola manajemen akun pengguna dan peran.

### 2.4.3 Eloquent ORM (Object-Relational Mapping)

Eloquent adalah ORM bawaan Laravel yang menyediakan antarmuka **ActiveRecord** yang indah untuk berinteraksi dengan basis data. Setiap tabel basis data dipetakan ke sebuah "Model" yang dapat digunakan untuk melakukan operasi query tanpa perlu menulis SQL mentah secara langsung. Eloquent juga mendukung pendefinisian **relasi antar tabel** menggunakan metode yang ekspresif (Otwell, 2022):

- **`hasMany()`:** Relasi satu-ke-banyak. Contoh: satu `Order` memiliki banyak `OrderItem`.
- **`belongsTo()`:** Relasi kebalikan dari `hasMany`. Contoh: `OrderItem` milik satu `Order`.
- **`hasOne()`:** Relasi satu-ke-satu.
- **`belongsToMany()`:** Relasi banyak-ke-banyak melalui tabel pivot.

Diagram relasi antar entitas (ERD) pada sistem Aerostreet adalah sebagai berikut:

- `User` (1) → (N) `Order`
- `User` (1) → (N) `Cart`
- `Order` (1) → (N) `OrderItem`
- `Order` (1) → (N) `Review`
- `Product` (1) → (N) `OrderItem`
- `Product` (1) → (N) `ProductSize`
- `Product` (1) → (N) `Review`
- `Product` (N) → (1) `Category`

### 2.4.4 Blade Templating Engine

Blade adalah mesin templating yang disertakan dengan Laravel. Berbeda dengan PHPTemplate dan Twig, Blade tidak membatasi penggunaan kode PHP biasa di dalam templat. Sebenarnya, semua templat Blade dikompilasi menjadi kode PHP murni dan di-cache hingga dimodifikasi, yang berarti Blade pada dasarnya tidak menambahkan overhead apa pun pada aplikasi (Otwell, 2022).

Salah satu fitur terkuat Blade adalah **Template Inheritance**. Sistem Aerostreet memanfaatkan fitur ini sepenuhnya, dengan mendefinisikan layout utama (`layouts/app.blade.php` untuk area publik dan `layouts/admin.blade.php` untuk area admin) yang menyediakan struktur HTML dasar, dan setiap halaman spesifik cukup mengisi bagian (`@section`) yang relevan.

### 2.4.5 Migrasi Database

Laravel menyediakan sistem **Database Migration** yang memungkinkan pengembang mendefinisikan skema basis data menggunakan PHP—bukan SQL mentah—dan melacak perubahannya seperti version control untuk database (Otwell, 2022). Setiap migrasi adalah file PHP yang berisi dua metode: `up()` untuk menerapkan perubahan skema dan `down()` untuk membatalkannya.

Sistem Aerostreet terdiri dari 12 (dua belas) file migrasi yang menghasilkan 9 tabel inti di basis data. Pendekatan migrasi ini memungkinkan tim pengembang untuk menyinkronkan skema database dengan mudah di berbagai lingkungan (development, staging, production).

### 2.4.6 Middleware Laravel

Middleware dalam Laravel adalah mekanisme pemfilteran HTTP request yang bekerja di antara request masuk dan logika aplikasi. Middleware bertindak seperti lapisan-lapisan yang harus dilalui oleh sebuah request sebelum mencapai controller yang dituju (Otwell, 2022).

Pada sistem Aerostreet, middleware digunakan secara strategis untuk:

1. **`auth`:** Memastikan pengguna sudah login sebelum mengakses halaman yang dilindungi (seperti keranjang belanja, checkout, dan dashboard).
2. **`verified`:** Memastikan pengguna telah memverifikasi alamat email mereka—sebuah lapisan keamanan ekstra yang diimplementasikan melalui `MustVerifyEmail`.
3. **`admin`:** Middleware kustom yang memastikan hanya pengguna dengan peran `admin` yang dapat mengakses area panel administrasi.

### 2.4.7 Laravel Breeze (Autentikasi)

**Laravel Breeze** adalah starter kit autentikasi minimal dan ringan yang disediakan oleh tim Laravel. Breeze menyediakan implementasi dasar seluruh fitur autentikasi Laravel, meliputi: login, registrasi, reset kata sandi, verifikasi email, dan konfirmasi kata sandi. Berbeda dengan Laravel Jetstream yang lebih kompleks, Breeze menggunakan Blade views dan komponen yang sederhana, sehingga sangat ideal sebagai titik awal pengembangan yang kemudian dikustomisasi sepenuhnya.

Sistem Aerostreet menggunakan Laravel Breeze sebagai fondasi autentikasi, yang kemudian dikembangkan dengan penambahan sistem **Role-Based Access Control (RBAC)** sederhana menggunakan kolom `role` bertipe enum (dengan nilai`'user'` dan `'admin'`) pada tabel `users`.

---

## 2.5 MySQL (Database)

### 2.5.1 Definisi MySQL

MySQL adalah sistem manajemen basis data relasional (Relational Database Management System / RDBMS) yang bersifat open-source. MySQL menggunakan Structured Query Language (SQL) untuk mengelola dan memanipulasi data. Pada tahun 2010, MySQL diakuisisi oleh Oracle Corporation. Namun, MySQL tetap dapat digunakan secara gratis di bawah lisensi GNU GPL (Welling & Thomson, 2016).

Basis data **MySQL** digunakan sebagai penyimpanan data utama pada sistem Aerostreet dengan nama database `aerostreet`. Semua transaksi data—mulai dari data produk, pengguna, pesanan, hingga ulasan—disimpan dan dikelola di sini.

### 2.5.2 Keunggulan MySQL

MySQL dipilih sebagai basis data pada penelitian ini karena beberapa alasan (Welling & Thomson, 2016):

1. **Kinerja Tinggi:** MySQL dikenal dengan performa query yang cepat karena penggunaan engine penyimpanan InnoDB yang dioptimalkan.
2. **Skalabilitas:** MySQL mampu menangani database berskala besar dengan jutaan record.
3. **Keamanan:** Menyediakan fitur enkripsi data dan manajemen hak akses pengguna yang robust.
4. **Integrasi dengan PHP:** MySQL dan PHP adalah pasangan teknologi yang telah terbukti dan memiliki ekosistem yang matang.
5. **Transaksi ACID:** InnoDB mendukung transaksi ACID (Atomicity, Consistency, Isolation, Durability), yang penting untuk menjaga integritas data transaksi e-commerce, seperti yang diimplementasikan dalam metode `DB::transaction()` pada `CheckoutController`.

### 2.5.3 Integritas Referensial dan Foreign Key

Sistem Aerostreet mengimplementasikan integritas referensial melalui **Foreign Key Constraints** dengan opsi `ON DELETE CASCADE`. Artinya, ketika data induk dihapus, semua data turunan (child records) akan ikut terhapus secara otomatis oleh database. Contohnya, ketika seorang pengguna dihapus, semua pesanan, keranjang belanja, dan ulasan milik pengguna tersebut akan ikut terhapus secara otomatis.

---

## 2.6 Tailwind CSS

### 2.6.1 Definisi Tailwind CSS

Tailwind CSS adalah sebuah framework CSS yang bersifat *utility-first*, artinya framework ini menyediakan kelas-kelas CSS berukuran kecil (utility classes) yang masing-masing hanya memiliki satu fungsi spesifik, seperti `flex`, `pt-4`, `text-center`, atau `bg-blue-500`. Pendekatan ini berbeda dengan framework tradisional seperti Bootstrap yang menyediakan komponen UI yang sudah jadi (Schoger, 2022).

Sistem Aerostreet menggunakan **Tailwind CSS versi 4**, versi terbaru yang menghadirkan peningkatan signifikan pada performa build, mesin JIT (Just-In-Time) yang lebih cepat, dan konfigurasi yang lebih sederhana melalui plugin `@tailwindcss/vite`.

### 2.6.2 Kelebihan Utility-First CSS

Pendekatan utility-first yang diterapkan oleh Tailwind CSS memiliki sejumlah keuntungan (Schoger, 2022):

1. **Tidak Ada Penamaan Kelas yang Sulit:** Developer tidak perlu bingung memikirkan nama kelas CSS yang semantik.
2. **Tampilan Konsisten:** Penggunaan sistem desain yang telah terdefinisi (spacing, warna, tipografi) memastikan konsistensi visual secara otomatis.
3. **File CSS yang Lebih Kecil di Production:** Tailwind secara otomatis menghapus kelas-kelas yang tidak digunakan (tree-shaking/purging) saat build production, menghasilkan file CSS yang sangat kecil.
4. **Responsivitas Mudah:** Tailwind menyediakan prefix *breakpoint* (`sm:`, `md:`, `lg:`, `xl:`) yang membuat desain responsif menjadi intuisif dan mudah diimplementasikan langsung di dalam markup HTML.

---

## 2.7 Alpine.js

### 2.7.1 Definisi Alpine.js

Alpine.js adalah framework JavaScript ringan yang menyediakan reaktivitas dan perilaku deklaratif langsung di dalam markup HTML. Alpine.js sering disebut sebagai "Tailwind untuk JavaScript" karena pendekatannya yang berbasis atribut HTML (Alpine.js Documentation, 2023). Alpine.js memungkinkan penambahan interaktivitas pada halaman web tanpa perlu menulis file JavaScript yang kompleks.

Sistem Aerostreet menggunakan **Alpine.js versi 3** untuk mengelola interaktivitas antarmuka pengguna yang ringan, seperti:

- Toggle menu navigasi mobile (hamburger menu)
- Dropdown, modal dialog, dan notifikasi toast
- Pemilihan ukuran produk yang secara dinamis memperbarui stok yang ditampilkan
- Konfirmasi aksi berbahaya (seperti konfirmasi penghapusan produk atau penghapusan ulasan) tanpa perlu membuka modal terpisah

### 2.7.2 Direktif Utama Alpine.js

Alpine.js bekerja melalui atribut-atribut khusus (directives) yang ditambahkan langsung ke elemen HTML (Alpine.js Documentation, 2023):

| Direktif        | Fungsi                                                                 |
|-----------------|------------------------------------------------------------------------|
| `x-data`        | Menginisialisasi komponen Alpine beserta state data reaktifnya         |
| `x-model`       | Membuat data binding dua arah (two-way binding) antara input dan state |
| `x-on` / `@`   | Mendengarkan event DOM (klik, input, dsb.) dan mengeksekusi aksi       |
| `x-show`        | Menampilkan/menyembunyikan elemen berdasarkan ekspresi boolean         |
| `x-bind` / `:`  | Mengikat atribut HTML secara dinamis berdasarkan state                 |
| `x-text`        | Mengatur teks konten elemen berdasarkan ekspresi JavaScript            |
| `x-for`         | Me-render daftar elemen berdasarkan array data                        |
| `x-transition`  | Menambahkan animasi transisi saat elemen muncul/menghilang            |

---

## 2.8 Vite (Build Tool)

### 2.8.1 Definisi Vite

Vite (bahasa Prancis untuk "cepat") adalah build tool frontend generasi berikutnya yang diciptakan oleh Evan You (pencipta Vue.js). Vite dirancang untuk menyediakan pengalaman pengembangan yang sangat cepat menggunakan fitur ES Modules native dari browser modern, serta membangun bundle produksi yang dioptimalkan menggunakan Rollup (Vite Documentation, 2024).

Dalam konteks proyek Laravel, **Laravel Vite Plugin** (`laravel-vite-plugin`) digunakan sebagai jembatan integrasi antara framework Laravel dan Vite, menggantikan Laravel Mix (yang berbasis Webpack) sejak Laravel 9.

### 2.8.2 Keunggulan Vite

1. **Server Startup yang Instan:** Vite tidak perlu bundling seluruh kode saat development dimulai; sebaliknya, ia menyajikan modul secara native via ES Modules, membuat startup server menjadi instan.
2. **Hot Module Replacement (HMR) yang Cepat:** Ketika file diubah, hanya modul tersebut yang perbarui di browser tanpa perlu me-refresh seluruh halaman, menjadikan siklus pengembangan jauh lebih cepat.
3. **Build Production Optimal:** Untuk build production, Vite menggunakan Rollup yang menghasilkan bundle yang sangat teroptimasi, ter-minifikasi, dan ter-tree-shaken.

---

## 2.9 Payment Gateway

### 2.9.1 Definisi Payment Gateway

Payment gateway (gerbang pembayaran) adalah layanan teknologi yang mengotentikasi dan memproses transaksi pembayaran dalam lingkungan e-commerce. Payment gateway bertindak sebagai perantara antara merchant (pedagang), bank penerbit kartu/wallet pembeli, dan bank acquirer merchant. Secara teknis, payment gateway mengenkripsi informasi sensitif seperti nomor kartu kredit untuk memastikan keamanan alintan antara merchant dan pihak bank (Dahlberg et al., 2019).

### 2.9.2 Midtrans sebagai Payment Gateway

**Midtrans** (sebelumnya dikenal sebagai Veritrans) adalah perusahaan teknologi pembayaran terkemuka asal Indonesia. Midtrans merupakan subsidiaries dari GoTo Group yang menyediakan berbagai metode pembayaran populer di Indonesia, antara lain: kartu kredit, transfer bank virtual account (VA) berbagai bank, dompet digital (GoPay, OVO, ShopeePay, DANA), minimarket (Alfamart, Indomaret), dan QRIS (Midtrans, 2024).

Sistem Aerostreet mengintegrasikan **Midtrans Snap** untuk memproses pembayaran online. Midtrans Snap adalah antarmuka pembayaran pop-up yang siap pakai dan dapat diintegrasikan dengan cepat menggunakan sebuah snap token yang di-generate di sisi server.

### 2.9.3 Alur Pembayaran Midtrans Snap

Alur kerja integrasi Midtrans Snap pada sistem Aerostreet adalah sebagai berikut:

1. **Pembuatan Pesanan:** Pengguna mengonfirmasi checkout, server membuat record `Order` di database dengan status `pending`.
2. **Generate Snap Token:** Server memanggil API Midtrans (melalui library `midtrans/midtrans-php`) dengan data transaksi (nomor order, total, detail item, data pelanggan) dan mendapatkan kembali sebuah `snap_token`.
3. **Penyimpanan Token:** `snap_token` disimpan di tabel `orders` untuk keperluan tampilan ulang halaman pembayaran.
4. **Tampilan Pembayaran:** Pengguna diarahkan ke halaman pembayaran (`checkout.midtrans`) di mana Snap.js Midtrans memuat jendela pembayaran pop-up menggunakan `snap_token`.
5. **Konfirmasi Pembayaran:** Setelah pembayaran berhasil, callback `onSuccess` dari Snap.js memanggil endpoint internal (`/checkout/{order}/midtrans-success`) via `fetch()` untuk memperbarui status pesanan menjadi `paid` di database.

> **Catatan Implementasi:** Karena proyek ini berjalan di lingkungan localhost (development), webhook Midtrans tidak dapat digunakan secara langsung (Midtrans tidak dapat mengirim notifikasi ke server lokal yang tidak publik). Solusi yang diterapkan adalah memanggil endpoint pembaruan status langsung dari callback `onSuccess` JavaScript di sisi frontend—sebuah pendekatan yang umum digunakan dalam konteks demo dan pengembangan.

### 2.9.4 Metode Pembayaran Manual (Transfer Bank)

Selain Midtrans, sistem Aerostreet juga menyediakan opsi **pembayaran manual via transfer bank**. Alur pembayaran manual ini meliputi:

1. Pengguna memilih metode "Transfer Bank" saat checkout.
2. Sistem membuat pesanan dengan status `pending`.
3. Pengguna diarahkan ke halaman instruksi transfer beserta nomor rekening tujuan.
4. Pengguna mengunggah bukti transfer (foto/tangkapan layar) melalui form upload yang menerima file JPEG/PNG maksimal 2MB.
5. Status pesanan berubah menjadi `pending_verification`.
6. Admin memverifikasi pembayaran secara manual melalui panel admin, kemudian memperbarui status pesanan sesuai dengan kondisi aktual.

---

## 2.10 CRUD (Create, Read, Update, Delete)

CRUD merupakan akronim yang merepresentasikan empat operasi dasar yang dapat dilakukan pada data dalam sebuah sistem basis data (Date, 2004):

| Akronim | Operasi  | SQL Equivalent | Implementasi pada Sistem                                                   |
|---------|----------|----------------|----------------------------------------------------------------------------|
| **C**   | Create   | `INSERT`       | Admin menambah produk baru; pelanggan membuat pesanan baru                 |
| **R**   | Read     | `SELECT`       | Menampilkan daftar produk, detail pesanan, dan ulasan                      |
| **U**   | Update   | `UPDATE`       | Admin memperbarui data produk atau status pesanan                          |
| **D**   | Delete   | `DELETE`       | Admin menghapus produk; pelanggan menghapus ulasannya sendiri              |

Pada sistem Aerostreet, implementasi CRUD yang paling komprehensif terdapat pada modul manajemen produk admin (`Admin\ProductController`), yang mencakup seluruh siklus hidup data produk dari pembuatan hingga penghapusan, termasuk pengelolaan file gambar thumbnail produk di server storage.

---

## 2.11 Sistem Manajemen Pesanan (Order Management System)

Sistem manajemen pesanan adalah sebuah sistem yang melacak penjualan, pesanan, inventaris, dan pemenuhan (fulfillment) dalam siklus bisnis e-commerce. Menurut Chaffey (2019), sistem manajemen pesanan yang baik harus mampu memberikan visibilitas penuh terhadap status setiap pesanan, baik kepada penjual maupun pembeli.

Pada sistem Aerostreet, siklus status pesanan diimplementasikan sebagai alur yang terstruktur:

```
pending → pending_verification → paid → processing → shipped → completed
                                                  ↘
                                               cancelled (bisa kapan saja)
```

**Penjelasan setiap status:**

| Status                 | Deskripsi                                                              | Aktor Pembaruan   |
|------------------------|------------------------------------------------------------------------|-------------------|
| `pending`              | Pesanan dibuat, menunggu pembayaran dari pelanggan                     | Sistem (otomatis) |
| `pending_verification` | Bukti transfer manual sudah diunggah, menunggu konfirmasi admin         | Sistem (otomatis) |
| `paid`                 | Pembayaran sudah dikonfirmasi (Midtrans: otomatis; Manual: oleh admin) | Admin / Midtrans  |
| `processing`           | Pesanan sedang dikemas oleh tim gudang                                 | Admin             |
| `shipped`              | Pesanan sudah diserahkan kepada kurir pengiriman                        | Admin             |
| `completed`            | Pesanan sudah diterima oleh pelanggan                                  | Admin             |
| `cancelled`            | Pesanan dibatalkan                                                     | Admin             |

---

## 2.12 Sistem Ulasan Produk (Product Review System)

### 2.12.1 Pentingnya Ulasan Produk dalam E-Commerce

Ulasan produk atau *user-generated content* (UGC) berupa penilaian dan komentar merupakan salah satu faktor paling berpengaruh dalam keputusan pembelian konsumen online. Menurut penelitian Nielsen (2021), sekitar 88% konsumen mempercayai ulasan online sama seperti rekomendasi dari orang yang mereka kenal secara personal. Ulasan produk membantu membangun kepercayaan calon pembeli dan mengurangi ketidakpastian yang inheren dalam belanja online (Mudambi & Schuff, 2010).

### 2.12.2 Implementasi Sistem Review pada Aerostreet

Sistem ulasan pada Aerostreet dirancang dengan mempertimbangkan beberapa prinsip kualitas data:

1. **Verified Purchase:** Hanya pengguna yang telah benar-benar membeli dan menerima produk (`status: shipped` atau `completed`) yang dapat meninggalkan ulasan. Ini mencegah ulasan palsu dari pengguna yang tidak pernah membeli.

2. **Satu Ulasan per Produk per Pesanan:** Sistem memberlakukan *unique constraint* di level database (`unique(['user_id', 'product_id', 'order_id'])`) untuk mencegah duplikasi ulasan.

3. **Fitur Lengkap:** Ulasan mencakup:
   - **Rating bintang** (1–5 skala Likert)
   - **Judul ulasan** (opsional, maks. 100 karakter)
   - **Isi ulasan** (opsional, maks. 1000 karakter)
   - **Foto ulasan** (unggah hingga 4 foto, maks. 3MB per foto)
   - **Kesesuaian ukuran** (pilihan: Kekecilan / Pas di Badan / Kebesaran)

4. **Rata-rata Rating Otomatis:** Model `Product` menghitung rata-rata rating secara dinamis melalui Eloquent accessor `getAverageRatingAttribute()` yang mengambil rata-rata dari seluruh ulasan yang berstatus `approved`.

5. **Moderasi Konten:** Setiap ulasan memiliki status (`pending`, `approved`, `rejected`) yang memungkinkan admin untuk memoderasi konten yang tidak layak. Secara default, ulasan disetel `approved` untuk pengalaman pengguna yang mulus.

---

## 2.13 Role-Based Access Control (RBAC)

### 2.13.1 Definisi RBAC

Role-Based Access Control (RBAC) adalah sebuah pendekatan keamanan yang membatasi akses sistem kepada pengguna yang sah berdasarkan peran (role) yang dimilikinya dalam sebuah organisasi atau sistem. RBAC memungkinkan pengaturan hak akses yang terstruktur dan mudah dikelola dengan mendefinisikan izin (permissions) pada level peran, bukan pada level pengguna individual (Sandhu et al., 1996).

### 2.13.2 Implementasi RBAC pada Aerostreet

Sistem Aerostreet mengimplementasikan RBAC sederhana dua tingkat melalui kolom `role` pada tabel `users` yang dapat bernilai `'user'` (pelanggan) atau `'admin'` (administrator).

Penegakan akses diimplementasikan melalui dua lapisan:

**Lapisan 1: Middleware `admin`** yang memeriksa peran pengguna sebelum mengizinkan akses ke seluruh rute dalam prefix `/admin`:
```php
// Middleware memastikan hanya admin yang dapat mengakses area /admin
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // ... rute khusus admin
});
```

**Lapisan 2: Method `isAdmin()` pada Model User:**
```php
public function isAdmin(): bool {
    return $this->role === 'admin';
}
```

Pemisahan akses ini memastikan bahwa pengguna biasa secara mutlak tidak dapat mengakses atau memanipulasi data melalui panel administrasi.

---

## 2.14 Keamanan Aplikasi Web

### 2.14.1 Validasi Input

Validasi input adalah proses memverifikasi bahwa data yang dikirimkan oleh pengguna memenuhi kriteria yang diharapkan sebelum diproses lebih lanjut. Validasi yang tidak memadai adalah salah satu celah keamanan paling umum dalam aplikasi web (OWASP, 2021).

Sistem Aerostreet menggunakan fitur validasi bawaan Laravel (`$request->validate()`) secara konsisten di setiap titik input data. Sebagai contoh, pada `ReviewController::store()`, sistem memvalidasi bahwa `rating` harus berupa integer antara 1 dan 5, `photos` adalah array dengan maksimum 4 elemen, dan setiap foto harus berupa gambar dengan format JPEG/JPG/PNG/WebP dan ukuran maksimal 3MB.

### 2.14.2 CSRF (Cross-Site Request Forgery) Protection

Laravel secara otomatis menghasilkan token CSRF untuk setiap sesi pengguna yang aktif. Token ini disertakan secara otomatis dalam setiap form HTML melalui direktif Blade `@csrf` dan diverifikasi oleh middleware `VerifyCsrfToken` setiap kali ada HTTP request dengan method POST, PUT, PATCH, atau DELETE. Ini melindungi aplikasi dari serangan CSRF di mana penyerang mencoba membuat pengguna yang sudah login untuk melakukan aksi yang tidak diinginkan.

### 2.14.3 Autentikasi dan Verifikasi Email

Sistem autentikasi pada Aerostreet diperkuat dengan fitur **verifikasi email** melalui antarmuka `MustVerifyEmail`. Setiap akun yang baru terdaftar harus memverifikasi alamat email mereka sebelum dapat mengakses fitur-fitur yang memerlukan autentikasi penuh (seperti keranjang belanja dan proses checkout). Ini membantu memastikan bahwa setiap akun terhubung dengan alamat email yang valid dan mencegah pembuatan akun spam.

### 2.14.4 Otorisasi Resource

Di luar autentikasi (siapa Anda?), Laravel juga mendukung otorisasi (apa yang boleh Anda lakukan?). Pada sistem Aerostreet, otorisasi resource diimplementasikan secara manual menggunakan helper `abort_if()` untuk memastikan pengguna hanya dapat mengakses data miliknya sendiri:

```php
// Memastikan pesanan adalah milik pengguna yang sedang login
abort_if($order->user_id !== Auth::id(), 403);
```

Pendekatan ini mencegah serangan **IDOR (Insecure Direct Object Reference)** yang memungkinkan pengguna mengakses data milik pengguna lain hanya dengan memanipulasi ID di URL.

---

## 2.15 Pengembangan Antarmuka Pengguna

### 2.15.1 User Interface (UI) dan User Experience (UX)

User Interface (UI) merujuk pada elemen visual dan interaktif yang membentuk antarmuka antara manusia dan sistem komputer, meliputi: tata letak, pilihan warna, tipografi, tombol, ikon, dan spasi (Cooper et al., 2014). Sementara User Experience (UX) adalah konsep yang lebih luas, mencakup seluruh pengalaman dan persepsi seseorang saat berinteraksi dengan produk atau sistem, termasuk kemudahan penggunaan (usability), kenyamanan, dan kepuasan (Nielsen, 1994).

Pada sistem Aerostreet, desain UI/UX mengadopsi pendekatan modern yang berfokus pada:

- **Dark Mode Aesthetic:** Antarmuka menggunakan palet warna gelap (dark mode) dengan aksen warna berenergi tinggi untuk menciptakan tampilan yang modern dan premium.
- **Responsif:** Desain dibangun mobile-first menggunakan breakpoint Tailwind CSS, memastikan tampilan yang optimal di berbagai ukuran layar.
- **Micro-animations:** Penggunaan transisi dan animasi halus (CSS `transition`, `hover:scale`) untuk memberikan umpan balik visual yang responsif kepada pengguna.
- **Komponen Reusable:** Penggunaan Blade Components (terletak di `resources/views/components/`) untuk elemen UI yang digunakan berulang, seperti alert notifikasi, kartu produk, dan badge status.

### 2.15.2 Desain Responsif

Desain responsif (Responsive Web Design/RWD) adalah pendekatan desain web yang membuat halaman web merespons dan menyesuaikan tampilannya secara dinamis terhadap ukuran layar dan resolusi perangkat yang digunakan oleh pengunjung. Konsep ini pertama kali diperkenalkan oleh Ethan Marcotte pada tahun 2010 (Marcotte, 2010).

Tailwind CSS mengimplementasikan desain responsif melalui sistem breakpoint berbasis "mobile-first":
- `sm:` — layar ≥ 640px
- `md:` — layar ≥ 768px
- `lg:` — layar ≥ 1024px
- `xl:` — layar ≥ 1280px
- `2xl:` — layar ≥ 1536px

---

## 2.16 Penelitian Terdahulu

Beberapa penelitian terdahulu yang relevan dengan penelitian ini adalah sebagai berikut:

1. **Prasetyo & Wibowo (2019)** dalam penelitiannya yang berjudul *"Pengembangan Sistem E-Commerce B2C Berbasis Laravel untuk UMKM Fashion"* berhasil membuktikan bahwa penggunaan framework Laravel dapat mempercepat waktu pengembangan aplikasi e-commerce hingga 40% dibandingkan pengembangan native PHP murni, dengan tetap menghasilkan aplikasi yang aman, terstruktur, dan mudah di-maintain.

2. **Santoso et al. (2020)** dalam penelitian *"Integrasi Payment Gateway Midtrans pada Sistem Reservasi Hotel Berbasis Web"* menyimpulkan bahwa integrasi Midtrans Snap secara signifikan meningkatkan konversi pembayaran karena menyediakan berbagai pilihan metode pembayaran dalam satu antarmuka yang terintegrasi dan familiar bagi pengguna Indonesia.

3. **Ramadhan & Hidayat (2021)** dalam penelitian *"Pengaruh Sistem Ulasan Produk terhadap Kepercayaan dan Niat Beli Konsumen pada Platform E-Commerce"* menemukan bahwa keberadaan sistem ulasan produk yang terverifikasi meningkatkan tingkat kepercayaan konsumen sebesar 67% dan meningkatkan niat beli sebesar 45% dibandingkan katalog produk tanpa sistem ulasan.

4. **Kurniawan & Setiawan (2022)** dalam penelitian *"Implementasi Role-Based Access Control pada Sistem Manajemen Konten Berbasis Laravel"* membuktikan bahwa implementasi RBAC melalui middleware Laravel merupakan pendekatan yang efektif dan efisien untuk melindungi sumber daya sistem dari akses yang tidak sah dengan overhead performa yang minimal.

5. **Fitriansyah et al. (2023)** dalam penelitian *"Perbandingan Performa Vite dan Webpack sebagai Build Tool pada Pengembangan Aplikasi Laravel"* menyimpulkan bahwa Vite terbukti 20-30 kali lebih cepat dibandingkan Webpack dalam hal cold server start time dan memiliki Hot Module Replacement yang 10 kali lebih responsif, menjadikannya pilihan build tool yang jauh superior untuk pengembangan modern.

---

## 2.17 Kerangka Berpikir

Berdasarkan kajian teori yang telah dipaparkan di atas, kerangka berpikir yang mendasari pengembangan sistem e-commerce **Aerostreet** adalah sebagai berikut:

Permasalahan utama yang dihadapi adalah kebutuhan akan sebuah platform penjualan sepatu online yang terintegrasi, aman, dan mudah digunakan oleh kedua pihak (pelanggan dan admin). Solusi yang dipilih adalah membangun sebuah aplikasi web e-commerce B2C dengan memanfaatkan ekosistem teknologi modern yang telah terbukti (*battle-tested*):

**PHP 8.2** sebagai bahasa server-side yang mature dan performatif → **Laravel 12** sebagai framework yang menyediakan struktur MVC yang rapi, Eloquent ORM, dan ekosistem paket yang kaya → **MySQL** sebagai RDBMS yang handal untuk menyimpan seluruh data transaksional → **Midtrans** sebagai payment gateway lokal yang menyediakan fleksibilitas metode pembayaran untuk pengguna Indonesia → **Tailwind CSS v4** untuk membangun antarmuka yang modern dan responsif dengan cepat → **Alpine.js** untuk menambahkan interaktivitas ringan tanpa overhead framework JavaScript yang berat → **Vite** untuk toolchain pengembangan yang cepat dan optimal.

Kombinasi teknologi ini menghasilkan sebuah sistem yang **secure** (melalui autentikasi, verifikasi email, CSRF protection, dan otorisasi resource), **functional** (mencakup seluruh siklus e-commerce dari katalog hingga pengiriman dan ulasan), dan **maintainable** (berkat arsitektur MVC yang terstruktur dan konvensi Laravel yang konsisten).

---

## Daftar Pustaka (Bab II)

- Alpine.js Documentation. (2023). *Alpine.js v3 Documentation*. Diakses dari https://alpinejs.dev/
- Chaffey, D. (2019). *Digital Business and E-Commerce Management* (7th ed.). Pearson Education.
- Cooper, A., Reimann, R., Cronin, D., & Noessel, C. (2014). *About Face: The Essentials of Interaction Design* (4th ed.). Wiley.
- Dahlberg, T., Guo, J., & Ondrus, J. (2019). A critical review of mobile payment research. *Electronic Commerce Research and Applications*, 38.
- Date, C. J. (2004). *An Introduction to Database Systems* (8th ed.). Pearson/Addison Wesley.
- Gamma, E., Helm, R., Johnson, R., & Vlissides, J. (1994). *Design Patterns: Elements of Reusable Object-Oriented Software*. Addison-Wesley.
- Kotler, P., & Armstrong, G. (2020). *Principles of Marketing* (18th ed.). Pearson.
- Laudon, K. C., & Traver, C. G. (2021). *E-Commerce: Business, Technology, Society* (16th ed.). Pearson.
- Marcotte, E. (2010). *Responsive Web Design*. A Book Apart.
- Midtrans. (2024). *Midtrans Developer Documentation*. Diakses dari https://docs.midtrans.com/
- Mudambi, S. M., & Schuff, D. (2010). What Makes a Helpful Online Review? A Study of Customer Reviews on Amazon. *MIS Quarterly*, 34(1), 185–200.
- Nielsen, J. (1994). *Usability Engineering*. Academic Press.
- Nielsen. (2021). *Consumer Trust in Online, Social and Mobile Advertising Grows*. Nielsen Report.
- Otwell, T. (2022). *Laravel: The PHP Framework for Web Artisans – Official Documentation*. Diakses dari https://laravel.com/docs
- OWASP. (2021). *OWASP Top Ten Web Application Security Risks*. Diakses dari https://owasp.org/www-project-top-ten/
- Sandhu, R. S., Coyne, E. J., Feinstein, H. L., & Youman, C. E. (1996). Role-based access control models. *IEEE Computer*, 29(2), 38–47.
- Schoger, S. (2022). *Tailwind CSS: Utility-First CSS Framework*. Diakses dari https://tailwindcss.com/docs
- Sibero, A. F. K. (2013). *Web Programming Power Pack*. MediaKom.
- Turban, E., Outland, J., King, D., Lee, J. K., Liang, T. P., & Turban, D. C. (2018). *Electronic Commerce 2018: A Managerial and Social Networks Perspective* (9th ed.). Springer.
- Vite Documentation. (2024). *Vite: Next Generation Frontend Tooling*. Diakses dari https://vitejs.dev/
- Welling, L., & Thomson, L. (2016). *PHP and MySQL Web Development* (5th ed.). Addison-Wesley.

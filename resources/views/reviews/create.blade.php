<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tulis Ulasan | KICKSLAB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1,h2,h3,h4,.brand-font { font-family: 'Oswald', sans-serif; }
        .logo-font { font-family: 'Instrument Sans', sans-serif; }
        [x-cloak] { display: none !important; }

        /* Star Rating */
        .star-input { display: none; }
        .star-label {
            font-size: 2.5rem;
            cursor: pointer;
            color: #d1d5db;
            transition: color 0.15s, transform 0.15s;
            display: inline-block;
        }
        .star-label:hover,
        .star-input:checked ~ .star-label,
        .star-group:hover .star-label { color: #f59e0b; transform: scale(1.1); }
        .star-input:checked + .star-label,
        .star-input:checked ~ .star-label { color: #f59e0b; }

        /* Drag & Drop */
        .drop-zone { transition: all 0.2s; }
        .drop-zone.drag-over { border-color: #000; background-color: #f9fafb; transform: scale(1.01); }

        /* Photo preview grid */
        .photo-thumb { animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn { from { opacity:0; transform:scale(0.9); } to { opacity:1; transform:scale(1); } }

        /* Character counter animate */
        .char-warning { color: #f59e0b; }
        .char-danger  { color: #ef4444; }
    </style>
</head>
<body class="antialiased bg-gray-50 text-black">

    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 bg-white border-b border-gray-200">
        <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-black italic uppercase tracking-tighter logo-font">KICKSLAB</a>
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-black transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-12"
          x-data="{
              rating: 0,
              hoverRating: 0,
              bodyLen: 0,
              photos: [],
              previewUrls: [],
              sizeFit: 0,

              setRating(n) { this.rating = n; },
              setSizeFit(n) { this.sizeFit = (this.sizeFit === n) ? 0 : n; },

              addPhotos(files) {
                  const arr = Array.from(files);
                  const remaining = 4 - this.photos.length;
                  arr.slice(0, remaining).forEach(f => {
                      if (!f.type.startsWith('image/')) return;
                      this.photos.push(f);
                      const reader = new FileReader();
                      reader.onload = e => this.previewUrls.push(e.target.result);
                      reader.readAsDataURL(f);
                  });
              },

              removePhoto(idx) {
                  this.photos.splice(idx, 1);
                  this.previewUrls.splice(idx, 1);
              },

              ratingLabel(n) {
                  return ['', 'Sangat Kecewa 😞', 'Kurang Puas 😕', 'Cukup OK 😐', 'Puas! 😊', 'Luar Biasa! 🤩'][n] || '';
              },

              handleDrop(e) {
                  e.preventDefault();
                  e.currentTarget.classList.remove('drag-over');
                  this.addPhotos(e.dataTransfer.files);
              }
          }">

        {{-- Header --}}
        <div class="mb-8 text-center">
            <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-400">KICKSLAB Review</span>
            <h1 class="text-4xl font-black brand-font uppercase tracking-tighter mt-1 mb-2">Tulis Ulasanmu</h1>
            <p class="text-gray-500 text-sm">Bantu pembeli lain dengan pengalaman jujurmu</p>
        </div>

        {{-- Product Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6 flex items-center gap-4">
            <div class="w-20 h-20 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                @if($orderItem->product?->thumbnail)
                    <img src="{{ $orderItem->product->thumbnail }}" alt="{{ $orderItem->product->name }}"
                         class="w-full h-full object-cover">
                @endif
            </div>
            <div class="flex-1">
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ $orderItem->product->brand ?? '' }}</p>
                <h2 class="font-black brand-font uppercase text-lg leading-tight">{{ $orderItem->product->name ?? 'Produk' }}</h2>
                <p class="text-xs text-gray-400 mt-1">
                    Ukuran: <span class="font-bold text-gray-700">{{ $orderItem->size }}</span>
                    · Qty: <span class="font-bold text-gray-700">{{ $orderItem->quantity }}</span>
                </p>
            </div>
            <div class="text-right flex-shrink-0">
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Order</p>
                <p class="font-mono text-xs font-bold text-gray-700">{{ $order->order_number }}</p>
                <span class="inline-block mt-1 text-[10px] px-2 py-0.5 bg-emerald-100 text-emerald-700 font-bold rounded-full uppercase tracking-wider">
                    ✓ Verified Purchase
                </span>
            </div>
        </div>

        {{-- FORM --}}
        <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data"
              class="space-y-6"
              @submit.prevent="
                  if(rating === 0) { alert('Pilih rating bintang dulu yaa!'); return; }
                  // Build FormData dan submit
                  const fd = new FormData($el);
                  fd.set('rating', rating);
                  fd.set('size_fit', sizeFit || '');
                  photos.forEach((p, i) => fd.append('photos[]', p));
                  fetch($el.action, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                      .then(r => r.redirected ? window.location.href = r.url : r.json())
                      .catch(() => $el.submit());
                  $el.submit();
              ">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="product_id" value="{{ $orderItem->product_id }}">

            {{-- ================ RATING BINTANG ================ --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-black brand-font uppercase tracking-tight text-gray-900 mb-1">Rating Keseluruhan</h3>
                <p class="text-xs text-gray-400 mb-5">Klik bintang untuk memberi nilai</p>

                {{-- Bintang Interaktif --}}
                <div class="flex gap-1 mb-3 justify-center" id="star-group">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button"
                            @click="setRating({{ $i }})"
                            @mouseenter="hoverRating = {{ $i }}"
                            @mouseleave="hoverRating = 0"
                            class="text-5xl transition-all duration-150 hover:scale-110 focus:outline-none"
                            :class="(hoverRating >= {{ $i }} || rating >= {{ $i }}) ? 'text-amber-400' : 'text-gray-200'">
                        ★
                    </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" :value="rating">

                <div class="text-center">
                    <p class="text-lg font-black brand-font uppercase tracking-tight text-gray-900 transition-all" x-text="ratingLabel(hoverRating || rating) || 'Pilih rating bintang...'" :class="rating > 0 ? 'text-amber-600' : 'text-gray-400'"></p>
                </div>
            </div>

            {{-- ================ SIZE FIT ================ --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-black brand-font uppercase tracking-tight text-gray-900 mb-1">Kesesuaian Ukuran <span class="text-gray-400 font-normal text-sm normal-case">(opsional)</span></h3>
                <p class="text-xs text-gray-400 mb-4">Apakah ukuran yang kamu beli sesuai ekspektasi?</p>
                <input type="hidden" name="size_fit" :value="sizeFit || ''">
                <div class="grid grid-cols-3 gap-3">
                    @foreach([1 => ['😅', 'Kekecilan'], 2 => ['👌', 'Pas di Badan'], 3 => ['😂', 'Kebesaran']] as $val => [$emoji, $label])
                    <button type="button"
                            @click="setSizeFit({{ $val }})"
                            :class="sizeFit === {{ $val }} ? 'border-black bg-black text-white' : 'border-gray-200 text-gray-600 hover:border-gray-400'"
                            class="flex flex-col items-center gap-1.5 py-4 border-2 rounded-xl transition-all font-semibold text-sm">
                        <span class="text-2xl">{{ $emoji }}</span>
                        <span class="text-xs font-bold uppercase tracking-wider" :class="sizeFit === {{ $val }} ? 'text-white' : 'text-gray-500'">{{ $label }}</span>
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- ================ JUDUL + ISI ULASAN ================ --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
                <div>
                    <h3 class="font-black brand-font uppercase tracking-tight text-gray-900 mb-4">Tulis Ulasan</h3>

                    {{-- Judul --}}
                    <div class="mb-4">
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Judul Singkat <span class="text-gray-300">(opsional)</span></label>
                        <input type="text" name="title" maxlength="100"
                               placeholder="Contoh: Sepatu Keren & Nyaman Dipakai!"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent focus:bg-white transition">
                    </div>

                    {{-- Body --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">
                            Ceritakan Pengalamanmu <span class="text-gray-300">(opsional)</span>
                        </label>
                        <div class="relative">
                            <textarea name="body" rows="5" maxlength="1000"
                                      @input="bodyLen = $event.target.value.length"
                                      placeholder="Bagaimana kualitas, bahan, dan kenyamanannya? Apakah sesuai dengan deskripsi? Sertakan hal-hal yang berguna untuk pembeli lain..."
                                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-300 resize-none focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent focus:bg-white transition leading-relaxed"></textarea>
                            <div class="absolute bottom-3 right-4 text-[10px] font-bold transition-colors"
                                 :class="bodyLen > 900 ? 'text-red-400' : bodyLen > 700 ? 'text-amber-400' : 'text-gray-300'">
                                <span x-text="bodyLen"></span>/1000
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================ UPLOAD FOTO ================ --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-black brand-font uppercase tracking-tight text-gray-900 mb-1">
                    Foto Produk <span class="text-gray-400 font-normal text-sm normal-case">(opsional, max 4 foto)</span>
                </h3>
                <p class="text-xs text-gray-400 mb-5">Format JPG/PNG/WebP · Maksimal 3MB per foto · Tunjukkan kondisi asli produk</p>

                {{-- Drop Zone --}}
                <div class="drop-zone border-2 border-dashed border-gray-200 rounded-xl p-8 text-center cursor-pointer hover:border-gray-400 hover:bg-gray-50 transition"
                     x-show="photos.length < 4"
                     @dragover.prevent="$el.classList.add('drag-over')"
                     @dragleave.prevent="$el.classList.remove('drag-over')"
                     @drop="handleDrop($event)"
                     @click="$refs.photoInput.click()">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-gray-600 mb-1">Drag & drop foto di sini</p>
                    <p class="text-xs text-gray-400">atau <span class="text-black font-bold underline cursor-pointer">klik untuk pilih file</span></p>
                    <p class="text-[10px] text-gray-300 mt-2 uppercase tracking-widest">Max 4 foto · JPG, PNG, WebP · 3MB/foto</p>
                </div>

                <input type="file" x-ref="photoInput" multiple accept="image/*" class="hidden"
                       @change="addPhotos($event.target.files)">

                {{-- Preview Grid --}}
                <div class="grid grid-cols-4 gap-3 mt-4" x-show="previewUrls.length > 0">
                    <template x-for="(url, idx) in previewUrls" :key="idx">
                        <div class="photo-thumb relative aspect-square rounded-xl overflow-hidden bg-gray-100 border border-gray-200 group">
                            <img :src="url" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition flex items-center justify-center">
                                <button type="button"
                                        @click="removePhoto(idx)"
                                        class="w-7 h-7 bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition hover:bg-red-700">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            <div class="absolute bottom-1 left-1 text-[9px] font-bold bg-black/60 text-white px-1.5 py-0.5 rounded-full" x-text="'Foto ' + (idx + 1)"></div>
                        </div>
                    </template>

                    {{-- Add more slot --}}
                    <template x-if="previewUrls.length < 4">
                        <button type="button"
                                @click="$refs.photoInput.click()"
                                class="aspect-square rounded-xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 hover:border-gray-400 hover:text-gray-600 transition">
                            <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12M6 12h12"/></svg>
                            <span class="text-[10px] font-bold uppercase">Tambah</span>
                        </button>
                    </template>
                </div>

                <p class="text-[10px] text-gray-400 mt-3 uppercase tracking-wider" x-show="photos.length > 0">
                    <span x-text="photos.length"></span> foto dipilih
                    — <span x-text="4 - photos.length"></span> slot tersisa
                </p>
            </div>

            {{-- ERROR --}}
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl px-5 py-4">
                <ul class="space-y-1">
                    @foreach($errors->all() as $err)
                    <li class="text-sm text-red-600 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        {{ $err }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- SUBMIT --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit"
                        :disabled="rating === 0"
                        :class="rating === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-800 active:scale-[0.98]'"
                        class="flex-1 flex items-center justify-center gap-2.5 px-8 py-4 bg-black text-white font-black text-base rounded-xl transition-all shadow-lg">
                    <span class="text-xl">⭐</span>
                    Kirim Ulasan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>
                <a href="{{ route('dashboard') }}"
                   class="px-6 py-4 border-2 border-gray-200 text-gray-600 font-bold text-sm rounded-xl hover:border-gray-400 hover:text-gray-900 transition text-center">
                    Batalkan
                </a>
            </div>

            <p class="text-center text-[11px] text-gray-400">
                Dengan mengirim ulasan, kamu menyetujui bahwa ulasan ini jujur berdasarkan pengalaman pribadi.
            </p>
        </form>
    </main>

</body>
</html>

@extends('layouts.admin')

@section('title', 'Detail Order ' . $order->order_number)
@section('page-title', 'Order Detail')
@section('page-subtitle', 'Review pesanan & kelola alur pengiriman')

@section('content')

    {{-- Flash --}}
    @if(session('success') || session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="mb-6 flex items-center gap-3 px-5 py-4 shadow-lg {{ session('success') ? 'bg-emerald-500' : 'bg-red-500' }} text-white rounded-xl">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ session('success') ? 'M5 13l4 4L19 7' : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}"/></svg>
        <p class="text-sm font-bold">{{ session('success') ?? session('error') }}</p>
        <button @click="show = false" class="ml-auto hover:opacity-70"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>
    @endif

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            Kembali ke Daftar Orders
        </a>
    </div>

    {{-- ============================================================ --}}
    {{-- ORDER STATUS PIPELINE (Full Width Visual) --}}
    {{-- ============================================================ --}}
    @php
        $pipeline = [
            'pending'              => ['⏳', 'Pending',       'Menunggu pembayaran'],
            'pending_verification' => ['🔍', 'Verifikasi',    'Bukti transfer diupload'],
            'paid'                 => ['✅', 'Dibayar',       'Pembayaran dikonfirmasi'],
            'processing'           => ['📦', 'Dikemas',       'Pesanan sedang disiapkan'],
            'shipped'              => ['🚚', 'Dikirim',       'Dalam perjalanan ke customer'],
            'completed'            => ['🎉', 'Selesai',       'Pesanan diterima customer'],
        ];
        $statusOrder = array_keys($pipeline);
        $currentIdx  = array_search($order->status, $statusOrder);
        $isCancelled = $order->status === 'cancelled';
    @endphp

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="font-black brand-font uppercase tracking-tight text-gray-900 text-lg">Status Pipeline</h2>
                <p class="text-xs text-gray-400">Alur pesanan dari order hingga selesai</p>
            </div>
            @if($isCancelled)
                <span class="px-4 py-2 bg-red-100 text-red-700 border border-red-200 text-xs font-black rounded-xl uppercase tracking-wider">❌ Order Dibatalkan</span>
            @endif
        </div>

        @if(!$isCancelled)
        {{-- Pipeline Steps --}}
        <div class="flex items-start gap-0 overflow-x-auto pb-2">
            @foreach($pipeline as $statusKey => [$icon, $label, $desc])
            @php
                $stepIdx = array_search($statusKey, $statusOrder);
                $isDone    = $currentIdx !== false && $stepIdx < $currentIdx;
                $isCurrent = $statusKey === $order->status;
                $isFuture  = $currentIdx !== false && $stepIdx > $currentIdx;
            @endphp

            <div class="flex flex-col items-center flex-1 min-w-[90px] relative">
                {{-- Connector line (before) --}}
                @if(!$loop->first)
                <div class="absolute top-5 right-1/2 w-full h-0.5 {{ $isDone || $isCurrent ? 'bg-gray-900' : 'bg-gray-200' }} -z-10 translate-x-1/2"></div>
                @endif

                {{-- Circle --}}
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-base font-bold z-10 transition-all
                    {{ $isCurrent ? 'bg-gray-900 text-white ring-4 ring-gray-900/20 scale-110' : ($isDone ? 'bg-emerald-500 text-white' : 'bg-gray-100 text-gray-400') }}">
                    @if($isDone)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    @else
                        {{ $icon }}
                    @endif
                </div>

                {{-- Label --}}
                <p class="text-[10px] font-black uppercase tracking-wider mt-2 text-center
                    {{ $isCurrent ? 'text-gray-900' : ($isDone ? 'text-emerald-600' : 'text-gray-300') }}">
                    {{ $label }}
                </p>
                <p class="text-[9px] text-center leading-tight mt-0.5
                    {{ $isCurrent ? 'text-gray-500' : 'text-gray-300' }} hidden md:block">
                    {{ $desc }}
                </p>
            </div>
            @endforeach
        </div>

        {{-- ========================================== --}}
        {{-- NEXT STEP ACTION BUTTON --}}
        {{-- ========================================== --}}
        @php
            $nextStatus = $statusOrder[$currentIdx + 1] ?? null;
            $nextConfig = $pipeline[$nextStatus] ?? null;
            $nextActions = [
                'paid'       => ['📦 Proses & Kemas Pesanan',  'processing', 'bg-blue-500 hover:bg-blue-600 shadow-blue-200'],
                'processing' => ['🚚 Tandai Sudah Dikirim',    'shipped',    'bg-indigo-500 hover:bg-indigo-600 shadow-indigo-200'],
                'shipped'    => ['🎉 Tandai Pesanan Selesai',  'completed',  'bg-emerald-500 hover:bg-emerald-600 shadow-emerald-200'],
            ];
        @endphp

        @if(isset($nextActions[$order->status]))
        @php
            [$btnLabel, $nextVal, $btnCls] = $nextActions[$order->status];
            $orderNum    = $order->order_number;
            $confirmText = 'Lanjutkan ke step berikutnya untuk order ' . $orderNum . '?';
        @endphp
        <div class="mt-6 flex flex-col sm:flex-row items-center gap-3 pt-5 border-t border-gray-100">
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="w-full sm:w-auto">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="{{ $nextVal }}">
                <button type="submit"
                        onclick="return confirm('{{ $confirmText }}')"
                        class="w-full sm:w-auto flex items-center justify-center gap-2.5 px-8 py-4 {{ $btnCls }} text-white font-black text-base rounded-xl transition-all duration-200 shadow-lg active:scale-[0.98]">
                    <span class="text-lg">{{ explode(' ', $btnLabel)[0] }}</span>
                    {{ trim(substr($btnLabel, strpos($btnLabel, ' '))) }}
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>
            </form>
            <p class="text-xs text-gray-400">Step berikutnya dalam alur pesanan</p>
        </div>
        @elseif($order->status === 'completed')
        <div class="mt-6 pt-5 border-t border-gray-100 flex items-center gap-3 bg-emerald-50 rounded-xl px-5 py-4">
            <svg class="w-6 h-6 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="font-black text-emerald-800 text-sm">🎉 Pesanan sudah selesai!</p>
                <p class="text-xs text-emerald-600">Semua tahapan sudah dilalui. Order ini Completed.</p>
            </div>
        </div>
        @elseif($order->status === 'pending_verification')
        {{-- Handled in payment proof section below --}}
        @endif

        @else
        {{-- CANCELLED STATE --}}
        <div class="flex items-center gap-4 bg-red-50 border border-red-200 rounded-xl px-5 py-4 mt-4">
            <div class="text-3xl">❌</div>
            <div>
                <p class="font-black text-red-800">Order ini sudah dibatalkan.</p>
                <p class="text-xs text-red-500 mt-0.5">Tidak ada aksi lebih lanjut yang bisa dilakukan.</p>
            </div>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- ============================================================ --}}
        {{-- KIRI: Bukti Pembayaran + Item --}}
        {{-- ============================================================ --}}
        <div class="xl:col-span-2 space-y-6">

            {{-- BUKTI PEMBAYARAN MANUAL --}}
            @if($order->payment_method === 'manual')
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-amber-500 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h2 class="font-black brand-font uppercase tracking-tight text-gray-900">Bukti Transfer</h2>
                            <p class="text-xs text-gray-400">Verifikasi foto/screenshot bukti pembayaran</p>
                        </div>
                    </div>
                    @php
                        $sBadge = [
                            'pending'              => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                            'pending_verification' => 'bg-amber-100 text-amber-700 border-amber-200',
                            'paid'                 => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            'processing'           => 'bg-blue-100 text-blue-700 border-blue-200',
                            'shipped'              => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                            'completed'            => 'bg-green-100 text-green-700 border-green-200',
                            'cancelled'            => 'bg-red-100 text-red-700 border-red-200',
                        ];
                        $badgeCls = $sBadge[$order->status] ?? 'bg-gray-100 text-gray-600 border-gray-200';
                    @endphp
                    <span class="px-3 py-1.5 text-xs font-black rounded-xl border uppercase tracking-wider {{ $badgeCls }}">
                        {{ str_replace('_', ' ', $order->status) }}
                    </span>
                </div>

                @if($order->payment_proof)
                <div class="p-6">
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 bg-gray-50 mb-6 relative group">
                        <img src="{{ Storage::url($order->payment_proof) }}"
                             alt="Bukti Pembayaran"
                             class="max-h-96 mx-auto object-contain block rounded-lg cursor-zoom-in"
                             onclick="document.getElementById('proof-modal').classList.remove('hidden')">
                        <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition">
                            <button onclick="document.getElementById('proof-modal').classList.remove('hidden')"
                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-black/70 text-white text-[10px] font-bold rounded-lg backdrop-blur-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                Perbesar
                            </button>
                        </div>
                        <p class="text-[10px] text-center text-gray-400 mt-3 uppercase tracking-widest">Klik gambar untuk memperbesar</p>
                    </div>

                    @if($order->status === 'pending_verification')
                    @php $formattedTotal = number_format($order->total_price, 0, ',', '.'); @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="paid">
                            <button type="submit"
                                    onclick="return confirm('Konfirmasi pembayaran Rp {{ $formattedTotal }}?')"
                                    class="w-full flex items-center justify-center gap-2 px-5 py-4 bg-emerald-500 hover:bg-emerald-600 active:scale-[0.98] text-white font-black text-sm rounded-xl transition-all duration-200 shadow-lg shadow-emerald-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                ✅ KONFIRMASI PEMBAYARAN
                            </button>
                        </form>
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit"
                                    onclick="return confirm('Tolak & batalkan order ini?')"
                                    class="w-full flex items-center justify-center gap-2 px-5 py-4 bg-red-500 hover:bg-red-600 active:scale-[0.98] text-white font-black text-sm rounded-xl transition-all duration-200 shadow-lg shadow-red-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                ❌ TOLAK / BATALKAN
                            </button>
                        </form>
                    </div>
                    <div class="mt-4 flex items-start gap-2 text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <p>Pastikan nominal sesuai total pesanan <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> sebelum konfirmasi.</p>
                    </div>
                    @endif
                </div>

                @else
                <div class="py-12 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-gray-100">
                        <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Bukti belum diupload</p>
                    <p class="text-xs text-gray-400 mt-1">Pelanggan belum mengupload bukti transfer.</p>
                </div>
                @endif
            </div>

            @else
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 bg-blue-500 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <div>
                        <h2 class="font-black brand-font uppercase tracking-tight text-gray-900">Pembayaran Midtrans</h2>
                        <p class="text-xs text-gray-400">Status otomatis diperbarui oleh sistem</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 bg-blue-50 border border-blue-100 rounded-xl px-5 py-4">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-xs text-blue-700">Pembayaran via Midtrans sudah diverifikasi otomatis. Status: <strong class="uppercase">{{ str_replace('_', ' ', $order->status) }}</strong>. Gunakan pipeline di atas untuk melanjutkan ke tahap berikutnya.</p>
                </div>
            </div>
            @endif

            {{-- ORDER ITEMS --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
                    <div class="w-9 h-9 bg-gray-900 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <div>
                        <h2 class="font-black brand-font uppercase tracking-tight text-gray-900">Item Pesanan</h2>
                        <p class="text-xs text-gray-400">{{ $order->items->sum('quantity') }} total produk</p>
                    </div>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach($order->items as $item)
                    <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50/60 transition">
                        <div class="w-14 h-14 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                            @if($item->product && $item->product->thumbnail)
                                <img src="{{ $item->product->thumbnail }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ $item->product->brand ?? '-' }}</p>
                            <p class="font-bold text-gray-900 text-sm truncate brand-font uppercase">{{ $item->product->name ?? 'Produk Dihapus' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                Size <span class="font-bold text-gray-600">{{ $item->size }}</span>
                                · Qty <span class="font-bold text-gray-600">{{ $item->quantity }}</span>
                                · @<span class="font-bold text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            </p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="font-black text-gray-900 brand-font">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @php
                    $subtotal = $order->items->sum(fn($i) => $i->price * $i->quantity);
                    $tax      = $order->total_price - $subtotal;
                @endphp
                <div class="px-6 py-4 border-t border-dashed border-gray-200 bg-gray-50/50 space-y-2">
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Subtotal</span>
                        <span class="font-semibold text-gray-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>PPN 11%</span>
                        <span class="font-semibold text-gray-800">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Ongkir</span>
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">GRATIS</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-gray-200">
                        <span class="font-black text-gray-900 uppercase tracking-wide">Total</span>
                        <span class="font-black text-xl brand-font text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- KANAN: Info Order + Customer + Update Manual --}}
        {{-- ============================================================ --}}
        <div class="space-y-5">

            {{-- Order Info --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-black brand-font uppercase tracking-tight text-gray-900 mb-5 pb-3 border-b border-gray-100">Informasi Order</h3>
                <div class="space-y-3.5">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">No. Order</p>
                        <p class="font-bold font-mono text-sm tracking-widest text-gray-800">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Tanggal Order</p>
                        <p class="font-semibold text-sm text-gray-800">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Metode Bayar</p>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-lg uppercase tracking-wider {{ $order->payment_method === 'midtrans' ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $order->payment_method === 'midtrans' ? '💳 Midtrans' : '🏦 Manual Transfer' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Total Bayar</p>
                        <p class="font-black text-xl brand-font text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Customer Info --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-black brand-font uppercase tracking-tight text-gray-900 mb-4 pb-3 border-b border-gray-100">Customer</h3>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-gray-900 text-white rounded-full flex items-center justify-center font-black text-lg uppercase">
                        {{ strtoupper(substr($order->user->name ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-900">{{ $order->user->name ?? 'Unknown' }}</p>
                        <p class="text-xs text-gray-400">{{ $order->user->email ?? '-' }}</p>
                    </div>
                </div>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest">Member sejak {{ $order->user?->created_at?->format('M Y') ?? '-' }}</p>
            </div>

            {{-- Update Status Manual (Override) --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-100">
                    <h3 class="font-black brand-font uppercase tracking-tight text-gray-900">Override Status</h3>
                    <span class="text-[10px] font-bold px-2 py-0.5 bg-orange-100 text-orange-600 rounded-full uppercase tracking-wider">Manual</span>
                </div>
                <p class="text-xs text-gray-400 mb-4">Ganti status ke posisi manapun jika diperlukan. Gunakan Pipeline di atas untuk alur normal.</p>

                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="space-y-3">
                    @csrf @method('PATCH')
                    @php
                        $allStatuses = [
                            'pending'              => ['⏳', 'Pending — Belum bayar'],
                            'pending_verification' => ['🔍', 'Menunggu Verifikasi'],
                            'paid'                 => ['✅', 'Paid — Dikonfirmasi'],
                            'processing'           => ['📦', 'Processing — Dikemas'],
                            'shipped'              => ['🚚', 'Shipped — Dikirim'],
                            'completed'            => ['🎉', 'Completed — Selesai'],
                            'cancelled'            => ['❌', 'Cancelled'],
                        ];
                    @endphp
                    <select name="status" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        @foreach($allStatuses as $val => [$ico, $lbl])
                        <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>
                            {{ $ico }} {{ $lbl }}
                        </option>
                        @endforeach
                    </select>
                    @php $overrideConfirm = 'Override status order ' . $order->order_number . '?'; @endphp
                    <button type="submit"
                            onclick="return confirm('{{ $overrideConfirm }}')"
                            class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-gray-900 hover:bg-gray-700 active:scale-[0.98] text-white font-black text-sm rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Update Status
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- MODAL: Zoom Bukti --}}
    @if($order->payment_proof)
    <div id="proof-modal"
         class="hidden fixed inset-0 bg-black/90 z-[9999] flex items-center justify-center p-4"
         onclick="if(event.target===this) this.classList.add('hidden')">
        <div class="relative max-w-4xl w-full">
            <button onclick="document.getElementById('proof-modal').classList.add('hidden')"
                    class="absolute -top-10 right-0 text-white hover:text-gray-300 transition flex items-center gap-2 text-sm font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                Tutup
            </button>
            <img src="{{ Storage::url($order->payment_proof) }}" alt="Bukti Pembayaran" class="w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl">
            @if($order->status === 'pending_verification')
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-3">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="paid">
                    <button type="submit" onclick="return confirm('Konfirmasi?')"
                            class="flex items-center gap-2 px-5 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-black text-sm rounded-xl shadow-lg transition">
                        ✅ Konfirmasi Pembayaran
                    </button>
                </form>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" onclick="return confirm('Tolak order ini?')"
                            class="flex items-center gap-2 px-5 py-3 bg-red-500 hover:bg-red-600 text-white font-black text-sm rounded-xl shadow-lg transition">
                        ❌ Tolak
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
    @endif

@endsection

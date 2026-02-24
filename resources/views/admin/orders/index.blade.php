@extends('layouts.admin')

@section('title', 'Orders Management')
@section('page-title', 'Orders')
@section('page-subtitle', 'Manajemen Pesanan & Verifikasi Pembayaran — ' . now()->format('l, d F Y'))

@section('content')

    {{-- ============================================================ --}}
    {{-- FLASH MESSAGES --}}
    {{-- ============================================================ --}}
    @if(session('success') || session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="mb-6 flex items-center gap-3 px-5 py-4 shadow-lg {{ session('success') ? 'bg-emerald-500' : 'bg-red-500' }} text-white rounded-xl">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ session('success') ? 'M5 13l4 4L19 7' : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}"></path></svg>
        <p class="text-sm font-bold">{{ session('success') ?? session('error') }}</p>
        <button @click="show = false" class="ml-auto hover:opacity-70 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
    </div>
    @endif

    {{-- ============================================================ --}}
    {{-- STAT CARDS --}}
    {{-- ============================================================ --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">

        {{-- Total Orders --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mb-3 group-hover:bg-gray-900 transition-colors duration-300">
                <svg class="w-5 h-5 text-gray-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Total Orders</p>
            <p class="text-2xl font-black brand-font text-gray-900">{{ number_format($stats['total']) }}</p>
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-gray-400 to-gray-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

        {{-- Pending --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
            <div class="w-10 h-10 bg-yellow-50 rounded-xl flex items-center justify-center mb-3 group-hover:bg-yellow-500 transition-colors duration-300">
                <svg class="w-5 h-5 text-yellow-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Pending</p>
            <p class="text-2xl font-black brand-font text-gray-900">{{ number_format($stats['pending']) }}</p>
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-yellow-400 to-yellow-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

        {{-- Needs Verification --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
            <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center mb-3 group-hover:bg-amber-500 transition-colors duration-300">
                <svg class="w-5 h-5 text-amber-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Verifikasi</p>
            <p class="text-2xl font-black brand-font text-gray-900">{{ number_format($stats['pending_verification']) }}</p>
            @if($stats['pending_verification'] > 0)
                <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-amber-500 rounded-full animate-ping"></span>
            @endif
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-amber-400 to-amber-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

        {{-- Paid --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center mb-3 group-hover:bg-emerald-500 transition-colors duration-300">
                <svg class="w-5 h-5 text-emerald-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Paid</p>
            <p class="text-2xl font-black brand-font text-gray-900">{{ number_format($stats['paid']) }}</p>
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-emerald-400 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

        {{-- Revenue --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center mb-3 group-hover:bg-blue-500 transition-colors duration-300">
                <svg class="w-5 h-5 text-blue-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Revenue</p>
            <p class="text-lg font-black brand-font text-gray-900">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-blue-400 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

    </div>

    {{-- ============================================================ --}}
    {{-- FILTER & SEARCH --}}
    {{-- ============================================================ --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 p-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <h3 class="font-bold brand-font uppercase tracking-tight text-gray-900">All Orders</h3>
                    <p class="text-[11px] text-gray-400">{{ $orders->total() }} total pesanan</p>
                </div>
            </div>

            {{-- Filter Forms --}}
            <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap items-center gap-2 w-full lg:w-auto">

                {{-- Status Filter --}}
                <select name="status" onchange="this.form.submit()"
                        class="text-xs border border-gray-200 rounded-xl px-3 py-2.5 bg-gray-50 focus:bg-white focus:border-gray-400 outline-none transition font-medium">
                    <option value="">Semua Status</option>
                    <option value="pending"              {{ request('status') === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                    <option value="pending_verification" {{ request('status') === 'pending_verification' ? 'selected' : '' }}>🔍 Waiting Verification</option>
                    <option value="paid"                 {{ request('status') === 'paid' ? 'selected' : '' }}>✅ Paid</option>
                    <option value="shipped"              {{ request('status') === 'shipped' ? 'selected' : '' }}>🚚 Shipped</option>
                    <option value="completed"            {{ request('status') === 'completed' ? 'selected' : '' }}>🎉 Completed</option>
                    <option value="cancelled"            {{ request('status') === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                </select>

                {{-- Method Filter --}}
                <select name="method" onchange="this.form.submit()"
                        class="text-xs border border-gray-200 rounded-xl px-3 py-2.5 bg-gray-50 focus:bg-white focus:border-gray-400 outline-none transition font-medium">
                    <option value="">Semua Metode</option>
                    <option value="manual"   {{ request('method') === 'manual' ? 'selected' : '' }}>🏦 Manual Transfer</option>
                    <option value="midtrans" {{ request('method') === 'midtrans' ? 'selected' : '' }}>💳 Midtrans</option>
                </select>

                {{-- Search --}}
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari order / nama / email..."
                           class="pl-8 pr-4 py-2.5 text-xs border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:border-gray-400 outline-none transition w-56">
                    <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                <button type="submit" class="px-4 py-2.5 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-gray-700 transition whitespace-nowrap">Cari</button>

                @if(request()->hasAny(['search', 'status', 'method']))
                    <a href="{{ route('admin.orders.index') }}" class="px-3 py-2.5 border border-gray-200 text-xs text-gray-500 rounded-xl hover:bg-gray-100 transition">Reset</a>
                @endif
            </form>
        </div>

        {{-- TABLE --}}
        @if($orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-[10px] uppercase font-bold text-gray-500 tracking-wider">
                    <tr>
                        <th class="px-5 py-4">Order</th>
                        <th class="px-5 py-4">Customer</th>
                        <th class="px-5 py-4">Total</th>
                        <th class="px-5 py-4">Metode</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4">Bukti Bayar</th>
                        <th class="px-5 py-4">Tanggal</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50/60 transition {{ $order->status === 'pending_verification' ? 'bg-amber-50/40' : '' }}">

                        {{-- Order Number --}}
                        <td class="px-5 py-4">
                            <span class="font-bold font-mono text-xs tracking-widest text-gray-800">{{ $order->order_number }}</span>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $order->items->sum('quantity') }} item(s)</p>
                        </td>

                        {{-- Customer --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($order->user->name ?? '?', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 text-sm truncate max-w-[130px]">{{ $order->user->name ?? 'Unknown' }}</p>
                                    <p class="text-[10px] text-gray-400 truncate max-w-[130px]">{{ $order->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Total --}}
                        <td class="px-5 py-4">
                            <span class="font-bold text-gray-900 text-sm">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </td>

                        {{-- Metode --}}
                        <td class="px-5 py-4">
                            @if($order->payment_method === 'midtrans')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    Midtrans
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 text-gray-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                                    Manual
                                </span>
                            @endif
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-5 py-4">
                            @php
                                $statusConfig = [
                                    'pending'              => ['bg-yellow-100 text-yellow-700 border-yellow-200',  '⏳'],
                                    'pending_verification' => ['bg-amber-100 text-amber-700 border-amber-200',     '🔍'],
                                    'paid'                 => ['bg-emerald-100 text-emerald-700 border-emerald-200','✅'],
                                    'shipped'              => ['bg-indigo-100 text-indigo-700 border-indigo-200',  '🚚'],
                                    'completed'            => ['bg-green-100 text-green-700 border-green-200',     '🎉'],
                                    'cancelled'            => ['bg-red-100 text-red-700 border-red-200',           '❌'],
                                ];
                                [$cls, $icon] = $statusConfig[$order->status] ?? ['bg-gray-100 text-gray-600 border-gray-200', '•'];
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold rounded-lg border uppercase tracking-wider {{ $cls }}">
                                {{ $icon }} {{ str_replace('_', ' ', $order->status) }}
                            </span>
                        </td>

                        {{-- Bukti Bayar --}}
                        <td class="px-5 py-4">
                            @if($order->payment_proof)
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-500 text-white text-[10px] font-bold rounded-lg hover:bg-amber-600 transition uppercase tracking-wider">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Lihat Bukti
                                </a>
                            @else
                                <span class="text-[10px] text-gray-300 font-medium">— Belum ada</span>
                            @endif
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-5 py-4 text-gray-400 text-[11px] whitespace-nowrap">
                            {{ $order->created_at->format('d M Y') }}<br>
                            <span class="text-gray-300">{{ $order->created_at->diffForHumans() }}</span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-900 text-white text-xs font-bold rounded-lg hover:bg-gray-700 transition">
                                Detail
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-400">Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }} of {{ $orders->total() }} pesanan</p>
            <div class="flex items-center gap-1">
                @if($orders->onFirstPage())
                    <span class="px-3 py-1.5 text-xs text-gray-300 border border-gray-100 rounded-lg cursor-not-allowed">← Prev</span>
                @else
                    <a href="{{ $orders->previousPageUrl() }}" class="px-3 py-1.5 text-xs font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">← Prev</a>
                @endif

                @foreach($orders->getUrlRange(max(1, $orders->currentPage()-2), min($orders->lastPage(), $orders->currentPage()+2)) as $page => $url)
                    @if($page == $orders->currentPage())
                        <span class="px-3 py-1.5 text-xs font-bold bg-gray-900 text-white rounded-lg">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 text-xs font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">{{ $page }}</a>
                    @endif
                @endforeach

                @if($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}" class="px-3 py-1.5 text-xs font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">Next →</a>
                @else
                    <span class="px-3 py-1.5 text-xs text-gray-300 border border-gray-100 rounded-lg cursor-not-allowed">Next →</span>
                @endif
            </div>
        </div>
        @endif

        @else
        {{-- EMPTY STATE --}}
        <div class="py-20 text-center">
            <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-5 border border-gray-100">
                <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <h4 class="text-lg font-bold brand-font uppercase text-gray-700 mb-2">Belum Ada Pesanan</h4>
            <p class="text-sm text-gray-400 max-w-xs mx-auto">
                @if(request()->hasAny(['search', 'status', 'method']))
                    Tidak ditemukan hasil untuk filter ini. <a href="{{ route('admin.orders.index') }}" class="text-blue-500 hover:underline">Reset filter</a>
                @else
                    Belum ada pesanan yang masuk dari pelanggan.
                @endif
            </p>
        </div>
        @endif
    </div>

@endsection

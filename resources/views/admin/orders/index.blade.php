@extends('layouts.admin')

@section('title', 'Orders')
@section('page-title', 'Orders')
@section('page-subtitle', 'Cart & Order Management — ' . now()->format('l, d F Y'))

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
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        {{-- Total Cart Items --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-5 h-5 text-blue-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Cart Items</p>
            <p class="text-2xl font-black brand-font text-gray-900">{{ number_format($stats['totalItems']) }}</p>
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-blue-400 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

        {{-- Active Customers --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-violet-50 rounded-xl flex items-center justify-center group-hover:bg-violet-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-5 h-5 text-violet-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Active Shoppers</p>
            <p class="text-2xl font-black brand-font text-gray-900">{{ number_format($stats['totalUsers']) }}</p>
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-violet-400 to-violet-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

        {{-- Total Quantity --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-5 h-5 text-amber-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Total Qty</p>
            <p class="text-2xl font-black brand-font text-gray-900">{{ number_format($stats['totalQuantity']) }}</p>
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-amber-400 to-amber-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

        {{-- Potential Revenue --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-5 h-5 text-emerald-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Potential Revenue</p>
            <p class="text-xl font-black brand-font text-gray-900">Rp {{ number_format($stats['totalRevenue'], 0, ',', '.') }}</p>
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-emerald-400 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

    </div>

    {{-- ============================================================ --}}
    {{-- INFO BANNER --}}
    {{-- ============================================================ --}}
    <div class="bg-amber-50 border border-amber-200 rounded-xl px-5 py-4 mb-6 flex items-start gap-3">
        <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <p class="text-sm font-bold text-amber-800">Showing Active Cart Items</p>
            <p class="text-xs text-amber-600 mt-0.5">Order management will be fully integrated once the checkout flow is implemented. Currently displaying all active cart items from customers.</p>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- FILTER & SEARCH --}}
    {{-- ============================================================ --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold brand-font uppercase tracking-tight text-gray-900">Cart Items</h3>
                    <p class="text-[11px] text-gray-400">{{ $cartItems->total() }} total records</p>
                </div>
            </div>

            {{-- Search Form --}}
            <form method="GET" action="{{ route('admin.orders.index') }}" class="flex items-center gap-2 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-72">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search user or product..."
                           class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:border-gray-400 outline-none transition">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <button type="submit" class="px-4 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-gray-700 transition whitespace-nowrap">Search</button>
                @if(request('search'))
                    <a href="{{ route('admin.orders.index') }}" class="px-3 py-2.5 border border-gray-200 text-sm text-gray-500 rounded-xl hover:bg-gray-100 transition">Clear</a>
                @endif
            </form>
        </div>

        {{-- TABLE --}}
        @if($cartItems->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-[10px] uppercase font-bold text-gray-500 tracking-wider">
                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">Size</th>
                        <th class="px-6 py-4">Qty</th>
                        <th class="px-6 py-4">Subtotal</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Added</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @foreach($cartItems as $item)
                    <tr class="hover:bg-gray-50/60 transition">
                        <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                            #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">
                                    {{ substr($item->user->name ?? '?', 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 text-sm truncate">{{ $item->user->name ?? 'Unknown' }}</p>
                                    <p class="text-[11px] text-gray-400 truncate">{{ $item->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($item->product && $item->product->thumbnail)
                                    <img src="{{ $item->product->thumbnail }}" alt="{{ $item->product->name }}"
                                         class="w-10 h-10 object-cover rounded-lg flex-shrink-0 bg-gray-100">
                                @else
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex-shrink-0 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 text-sm truncate max-w-[180px]">{{ $item->product->name ?? 'Product Deleted' }}</p>
                                    <p class="text-[11px] text-gray-400">{{ $item->product->brand ?? '-' }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 text-gray-700 text-[11px] font-bold rounded-lg">
                                {{ $item->size }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-900">{{ $item->quantity }}</span>
                        </td>

                        <td class="px-6 py-4">
                            @if($item->product)
                                <span class="font-bold text-gray-900">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                In Cart
                            </span>
                        </td>

                        <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">
                            {{ $item->created_at->format('d M Y') }}<br>
                            <span class="text-gray-300">{{ $item->created_at->diffForHumans() }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($cartItems->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-400">Showing {{ $cartItems->firstItem() }}–{{ $cartItems->lastItem() }} of {{ $cartItems->total() }} results</p>
            <div class="flex items-center gap-1">
                @if($cartItems->onFirstPage())
                    <span class="px-3 py-1.5 text-xs text-gray-300 border border-gray-100 rounded-lg cursor-not-allowed">← Prev</span>
                @else
                    <a href="{{ $cartItems->previousPageUrl() }}" class="px-3 py-1.5 text-xs font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">← Prev</a>
                @endif

                @foreach($cartItems->getUrlRange(max(1, $cartItems->currentPage()-2), min($cartItems->lastPage(), $cartItems->currentPage()+2)) as $page => $url)
                    @if($page == $cartItems->currentPage())
                        <span class="px-3 py-1.5 text-xs font-bold bg-gray-900 text-white rounded-lg">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 text-xs font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">{{ $page }}</a>
                    @endif
                @endforeach

                @if($cartItems->hasMorePages())
                    <a href="{{ $cartItems->nextPageUrl() }}" class="px-3 py-1.5 text-xs font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">Next →</a>
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
                <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <h4 class="text-lg font-bold brand-font uppercase text-gray-700 mb-2">No Cart Items Found</h4>
            <p class="text-sm text-gray-400 max-w-xs mx-auto">
                @if(request('search'))
                    No results for "{{ request('search') }}". <a href="{{ route('admin.orders.index') }}" class="text-blue-500 hover:underline">Clear search</a>
                @else
                    No customers have added items to their cart yet.
                @endif
            </p>
        </div>
        @endif
    </div>

@endsection

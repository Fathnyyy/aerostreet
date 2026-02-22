@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview & Analytics — ' . now()->format('l, d F Y'))

@section('content')

    {{-- ============================================================ --}}
    {{-- WELCOME BANNER --}}
    {{-- ============================================================ --}}
    <div class="bg-gray-900 text-white p-8 md:p-10 rounded-2xl mb-8 relative overflow-hidden shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-amber-400 mb-2">Admin Panel</p>
                <h1 class="text-3xl md:text-4xl font-black brand-font uppercase tracking-tighter leading-none">
                    Welcome back, {{ explode(' ', Auth::user()->name)[0] }}!
                </h1>
                <p class="text-sm text-gray-400 mt-2">Here's what's happening with your store today.</p>
            </div>
            <div class="flex gap-3">
                <a href="#"
                   class="inline-flex items-center gap-2 bg-amber-400 text-gray-900 px-5 py-3 font-bold uppercase text-xs tracking-wider hover:bg-amber-300 transition rounded-lg shadow-lg shadow-amber-400/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Product
                </a>
            </div>
        </div>
        {{-- Abstract decoration --}}
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-amber-400/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-8 -bottom-8 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
    </div>


    {{-- ============================================================ --}}
    {{-- STATS CARDS --}}
    {{-- ============================================================ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        {{-- Card 1 — Total Revenue --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6 text-emerald-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    +12.5%
                </span>
            </div>
            <p class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-1">Total Revenue</p>
            <p class="text-2xl font-black brand-font text-gray-900 tracking-tight">{{ $stats['totalRevenue'] }}</p>
            {{-- Decorative gradient line --}}
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

        {{-- Card 2 — Total Orders --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6 text-blue-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    +8.2%
                </span>
            </div>
            <p class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-1">Total Orders</p>
            <p class="text-2xl font-black brand-font text-gray-900 tracking-tight">{{ number_format($stats['totalOrders']) }}</p>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-400 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

        {{-- Card 3 — Total Products --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-violet-50 rounded-xl flex items-center justify-center group-hover:bg-violet-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6 text-violet-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-violet-600 bg-violet-50 px-2 py-1 rounded-full">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    +3
                </span>
            </div>
            <p class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-1">Total Products</p>
            <p class="text-2xl font-black brand-font text-gray-900 tracking-tight">{{ number_format($stats['totalProducts']) }}</p>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-violet-400 to-violet-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

        {{-- Card 4 — Total Customers --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6 text-amber-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    +24
                </span>
            </div>
            <p class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-1">Total Customers</p>
            <p class="text-2xl font-black brand-font text-gray-900 tracking-tight">{{ number_format($stats['totalCustomers']) }}</p>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-amber-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

    </div>


    {{-- ============================================================ --}}
    {{-- RECENT ORDERS TABLE + QUICK ACTIONS --}}
    {{-- ============================================================ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Recent Orders (2/3 width) --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <div>
                    <h3 class="text-lg font-bold brand-font uppercase tracking-tight text-gray-900">Recent Orders</h3>
                    <p class="text-[11px] text-gray-400 font-medium mt-0.5">Latest transactions</p>
                </div>
                <a href="#" class="text-[11px] font-bold uppercase tracking-wider text-gray-500 hover:text-black transition px-3 py-1.5 rounded-lg hover:bg-gray-100">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-[10px] uppercase font-bold text-gray-500 tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Order ID</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        {{-- Dummy Row 1 --}}
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900">#KS-2026-001</td>
                            <td class="px-6 py-4 text-gray-600">Andi Setiawan</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">Rp 2.850.000</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                    Processing
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-xs">12 Feb 2026</td>
                        </tr>
                        {{-- Dummy Row 2 --}}
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900">#KS-2026-002</td>
                            <td class="px-6 py-4 text-gray-600">Budi Prasetyo</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">Rp 1.250.000</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                    Completed
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-xs">11 Feb 2026</td>
                        </tr>
                        {{-- Dummy Row 3 --}}
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900">#KS-2026-003</td>
                            <td class="px-6 py-4 text-gray-600">Citra Dewi</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">Rp 4.100.000</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                    Shipped
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-xs">10 Feb 2026</td>
                        </tr>
                        {{-- Dummy Row 4 --}}
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900">#KS-2026-004</td>
                            <td class="px-6 py-4 text-gray-600">Dian Purnama</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">Rp 950.000</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                    Unpaid
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-xs">09 Feb 2026</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Quick Actions (1/3 width) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-lg font-bold brand-font uppercase tracking-tight text-gray-900 mb-1">Quick Actions</h3>
            <p class="text-[11px] text-gray-400 font-medium mb-6">Shortcuts to common tasks</p>

            <div class="space-y-3">
                <a href="#" class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 hover:bg-gray-900 hover:text-white text-gray-700 transition-all duration-300 group">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm group-hover:bg-amber-400 group-hover:text-gray-900 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold">Add New Product</p>
                        <p class="text-[10px] text-gray-400 group-hover:text-gray-300 uppercase tracking-wider">Create a listing</p>
                    </div>
                </a>

                <a href="#" class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 hover:bg-gray-900 hover:text-white text-gray-700 transition-all duration-300 group">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm group-hover:bg-amber-400 group-hover:text-gray-900 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold">Manage Orders</p>
                        <p class="text-[10px] text-gray-400 group-hover:text-gray-300 uppercase tracking-wider">Process pending</p>
                    </div>
                </a>

                <a href="#" class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 hover:bg-gray-900 hover:text-white text-gray-700 transition-all duration-300 group">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm group-hover:bg-amber-400 group-hover:text-gray-900 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold">Manage Users</p>
                        <p class="text-[10px] text-gray-400 group-hover:text-gray-300 uppercase tracking-wider">View members</p>
                    </div>
                </a>

                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 hover:bg-gray-900 hover:text-white text-gray-700 transition-all duration-300 group">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm group-hover:bg-amber-400 group-hover:text-gray-900 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold">Visit Storefront</p>
                        <p class="text-[10px] text-gray-400 group-hover:text-gray-300 uppercase tracking-wider">See live site</p>
                    </div>
                </a>
            </div>
        </div>

    </div>

@endsection

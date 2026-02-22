@extends('layouts.admin')

@section('title', 'Users')
@section('page-title', 'Users')
@section('page-subtitle', 'Member & Admin Management — ' . now()->format('l, d F Y'))

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

        {{-- Total Users --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-500 transition-colors duration-300 mb-3">
                <svg class="w-5 h-5 text-blue-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Total Users</p>
            <p class="text-2xl font-black brand-font text-gray-900">{{ number_format($stats['total']) }}</p>
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-blue-400 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

        {{-- Customers --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-500 transition-colors duration-300 mb-3">
                <svg class="w-5 h-5 text-emerald-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Customers</p>
            <p class="text-2xl font-black brand-font text-gray-900">{{ number_format($stats['customers']) }}</p>
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-emerald-400 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

        {{-- Admins --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
            <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-500 transition-colors duration-300 mb-3">
                <svg class="w-5 h-5 text-amber-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Admins</p>
            <p class="text-2xl font-black brand-font text-gray-900">{{ number_format($stats['admins']) }}</p>
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-amber-400 to-amber-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

        {{-- Verified --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
            <div class="w-10 h-10 bg-violet-50 rounded-xl flex items-center justify-center group-hover:bg-violet-500 transition-colors duration-300 mb-3">
                <svg class="w-5 h-5 text-violet-500 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Verified Email</p>
            <p class="text-2xl font-black brand-font text-gray-900">{{ number_format($stats['verified']) }}</p>
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-violet-400 to-violet-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
        </div>

    </div>

    {{-- ============================================================ --}}
    {{-- FILTER & TABLE --}}
    {{-- ============================================================ --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" x-data="{ deleteId: null }">

        {{-- Table Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-violet-500 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold brand-font uppercase tracking-tight text-gray-900">All Users</h3>
                    <p class="text-[11px] text-gray-400">{{ $users->total() }} total users</p>
                </div>
            </div>

            {{-- Search + Filter --}}
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search name or email..."
                           class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:border-gray-400 outline-none transition">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <select name="role" onchange="this.form.submit()"
                        class="py-2.5 px-3 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:border-gray-400 outline-none transition cursor-pointer">
                    <option value="">All Roles</option>
                    <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>

                <button type="submit" class="px-4 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-gray-700 transition whitespace-nowrap">Search</button>
                @if(request('search') || request('role'))
                    <a href="{{ route('admin.users.index') }}" class="px-3 py-2.5 border border-gray-200 text-sm text-gray-500 rounded-xl hover:bg-gray-100 transition text-center">Clear</a>
                @endif
            </form>
        </div>

        {{-- TABLE --}}
        @if($users->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-[10px] uppercase font-bold text-gray-500 tracking-wider">
                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Email Status</th>
                        <th class="px-6 py-4">Cart Items</th>
                        <th class="px-6 py-4">Joined</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50/60 transition {{ $user->id === auth()->id() ? 'bg-amber-50/30' : '' }}">

                        {{-- ID --}}
                        <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                            #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- User Info --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 {{ $user->role === 'admin' ? 'bg-amber-400 text-gray-900' : 'bg-gray-900 text-white' }} rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 relative">
                                    {{ substr($user->name, 0, 1) }}
                                    @if($user->id === auth()->id())
                                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-white"></span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 text-sm truncate flex items-center gap-1.5">
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                            <span class="text-[9px] font-bold bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded-full uppercase tracking-wide">You</span>
                                        @endif
                                    </p>
                                    <p class="text-[11px] text-gray-400 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Role Badge --}}
                        <td class="px-6 py-4">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    Admin
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Customer
                                </span>
                            @endif
                        </td>

                        {{-- Email Verified --}}
                        <td class="px-6 py-4">
                            @if($user->hasVerifiedEmail())
                                <span class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Verified
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-600 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Unverified
                                </span>
                            @endif
                        </td>

                        {{-- Cart Count --}}
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-900">{{ $user->carts_count }}</span>
                            <span class="text-gray-400 text-xs ml-1">item{{ $user->carts_count !== 1 ? 's' : '' }}</span>
                        </td>

                        {{-- Joined --}}
                        <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">
                            {{ $user->created_at->format('d M Y') }}<br>
                            <span class="text-gray-300">{{ $user->created_at->diffForHumans() }}</span>
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 text-right">
                            @if($user->id !== auth()->id())
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Toggle Role --}}
                                    <form method="POST" action="{{ route('admin.users.toggle-role', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-[11px] font-bold rounded-lg border transition
                                                {{ $user->role === 'admin'
                                                    ? 'border-amber-200 text-amber-700 bg-amber-50 hover:bg-amber-100'
                                                    : 'border-blue-200 text-blue-700 bg-blue-50 hover:bg-blue-100' }}"
                                                title="{{ $user->role === 'admin' ? 'Downgrade to Customer' : 'Promote to Admin' }}">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                            {{ $user->role === 'admin' ? '→ Customer' : '→ Admin' }}
                                        </button>
                                    </form>

                                    {{-- Delete --}}
                                    <button type="button"
                                            @click="deleteId = {{ $user->id }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-[11px] font-bold rounded-lg border border-red-200 text-red-600 bg-red-50 hover:bg-red-100 transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Delete
                                    </button>

                                    {{-- Hidden Delete Form --}}
                                    <form id="delete-form-{{ $user->id }}" method="POST" action="{{ route('admin.users.destroy', $user) }}" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            @else
                                <span class="text-[11px] text-gray-300 italic">Cannot edit yourself</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Delete Confirmation Modal --}}
        <div @keydown.escape.window="deleteId = null">
            {{-- Trigger from table rows via Alpine event --}}
            <template x-if="deleteId">
                <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
                    <div @click="deleteId = null" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
                    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 z-10"
                         x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                        <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                        </div>
                        <h3 class="text-lg font-black brand-font uppercase text-center mb-2">Delete User?</h3>
                        <p class="text-sm text-gray-500 text-center mb-6">This will permanently delete the user and all their cart data. This action cannot be undone.</p>
                        <div class="flex gap-3">
                            <button @click="deleteId = null" class="flex-1 py-2.5 border border-gray-200 text-sm font-bold text-gray-600 rounded-xl hover:bg-gray-50 transition">Cancel</button>
                            <button @click="document.getElementById('delete-form-' + deleteId).submit()" class="flex-1 py-2.5 bg-red-500 text-white text-sm font-bold rounded-xl hover:bg-red-600 transition">Delete</button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-400">Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users</p>
            <div class="flex items-center gap-1">
                @if($users->onFirstPage())
                    <span class="px-3 py-1.5 text-xs text-gray-300 border border-gray-100 rounded-lg cursor-not-allowed">← Prev</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="px-3 py-1.5 text-xs font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">← Prev</a>
                @endif

                @foreach($users->getUrlRange(max(1, $users->currentPage()-2), min($users->lastPage(), $users->currentPage()+2)) as $page => $url)
                    @if($page == $users->currentPage())
                        <span class="px-3 py-1.5 text-xs font-bold bg-gray-900 text-white rounded-lg">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 text-xs font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">{{ $page }}</a>
                    @endif
                @endforeach

                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="px-3 py-1.5 text-xs font-medium text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">Next →</a>
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
                <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <h4 class="text-lg font-bold brand-font uppercase text-gray-700 mb-2">No Users Found</h4>
            <p class="text-sm text-gray-400 max-w-xs mx-auto">
                @if(request('search') || request('role'))
                    No results match your filters. <a href="{{ route('admin.users.index') }}" class="text-blue-500 hover:underline">Clear filters</a>
                @else
                    No users registered yet.
                @endif
            </p>
        </div>
        @endif

    </div>

@endsection

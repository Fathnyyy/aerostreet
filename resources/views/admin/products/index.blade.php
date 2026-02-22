@extends('layouts.admin')

@section('title', 'Products')
@section('page-title', 'Products')
@section('page-subtitle', 'Manage your sneaker inventory')

@section('content')

    {{-- Flash Message --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <p class="text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Header Bar --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-black brand-font uppercase tracking-tight text-gray-900">All Products</h1>
            <p class="text-sm text-gray-400 mt-1">{{ $products->total() }} products in database</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center gap-2 bg-gray-900 text-white px-5 py-3 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-gray-800 transition shadow-lg shadow-gray-900/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Product
        </a>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('admin.products.index') }}" class="mb-6">
        <div class="relative max-w-md">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search products by name or brand..."
                   class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition">
        </div>
    </form>

    {{-- Products Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-[10px] uppercase font-bold text-gray-500 tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">Brand</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Total Stock</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50/50 transition group">
                            {{-- Product Name + Thumbnail --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 border border-gray-200">
                                        <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-gray-900 truncate max-w-[200px] lg:max-w-[300px]">{{ $product->name }}</p>
                                        <p class="text-[11px] text-gray-400 font-mono truncate">{{ $product->slug }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Brand --}}
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold uppercase tracking-wider text-gray-600 bg-gray-100 px-2.5 py-1 rounded-md">{{ $product->brand }}</span>
                            </td>

                            {{-- Category --}}
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category->name ?? '-' }}</td>

                            {{-- Price --}}
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>

                            {{-- Total Stock --}}
                            <td class="px-6 py-4">
                                @php $totalStock = $product->sizes->sum('stock'); @endphp
                                <span class="text-sm font-bold {{ $totalStock > 10 ? 'text-emerald-600' : ($totalStock > 0 ? 'text-amber-600' : 'text-red-600') }}">
                                    {{ $totalStock }} pcs
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if($product->status === 'active')
                                    <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Active
                                    </span>
                                @elseif($product->status === 'draft')
                                    <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> Draft
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span> Archived
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="p-2 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <p class="text-gray-500 font-semibold mb-1">No products found</p>
                                    <p class="text-sm text-gray-400">Start by adding your first product.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $products->links() }}
            </div>
        @endif
    </div>

@endsection

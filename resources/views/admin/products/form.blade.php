@extends('layouts.admin')

@section('title', isset($product) ? 'Edit Product' : 'Add Product')
@section('page-title', isset($product) ? 'Edit Product' : 'Add Product')
@section('page-subtitle', isset($product) ? 'Update product details' : 'Create a new product listing')

@section('content')

    {{-- Back Link --}}
    <a href="{{ route('admin.products.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-gray-900 transition mb-6 group">
        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        Back to Products
    </a>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="font-bold text-sm">Terdapat kesalahan pada form:</p>
            </div>
            <ul class="list-disc list-inside text-sm space-y-1 ml-7">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
          enctype="multipart/form-data"
          x-data="productForm()"
          class="space-y-6">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ============================================================ --}}
            {{-- LEFT COLUMN: Image & Name (1/3) --}}
            {{-- ============================================================ --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Thumbnail Upload --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-4">Product Image</h3>

                    <div class="relative">
                        {{-- Preview --}}
                        <div class="aspect-square bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 overflow-hidden flex items-center justify-center cursor-pointer hover:border-gray-400 transition group"
                             @click="$refs.thumbnailInput.click()">
                            <template x-if="imagePreview">
                                <img :src="imagePreview" class="w-full h-full object-cover rounded-xl">
                            </template>
                            <template x-if="!imagePreview">
                                <div class="text-center p-6">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-gray-200 transition">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-500">Click to upload</p>
                                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP — Max 2MB</p>
                                </div>
                            </template>
                        </div>
                        <input type="file" name="thumbnail" x-ref="thumbnailInput" @change="previewImage($event)" class="hidden" accept="image/*">
                    </div>

                    @if(isset($product))
                        <p class="text-[11px] text-gray-400 mt-3">Leave empty to keep current image.</p>
                    @endif
                </div>

                {{-- Product Name --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-4">Product Name</h3>
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}"
                           placeholder="e.g. Nike Air Jordan 1 High OG"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition"
                           required>
                </div>

                {{-- Description --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-4">Description</h3>
                    <textarea name="description" rows="5"
                              placeholder="Describe the product in detail..."
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition resize-none"
                              required>{{ old('description', $product->description ?? '') }}</textarea>
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- RIGHT COLUMN: Details & Sizes (2/3) --}}
            {{-- ============================================================ --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Product Details --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-6">Product Details</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        {{-- Brand --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Brand</label>
                            <input type="text" name="brand" value="{{ old('brand', $product->brand ?? '') }}"
                                   placeholder="e.g. NIKE"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition"
                                   required>
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Category</label>
                            <select name="category_id"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition appearance-none"
                                    required>
                                <option value="">— Select Category —</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Price --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Price (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}"
                                   placeholder="e.g. 3500000"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition"
                                   min="0" step="1000" required>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Status</label>
                            <select name="status"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition appearance-none"
                                    required>
                                <option value="active" {{ old('status', $product->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="draft" {{ old('status', $product->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="archived" {{ old('status', $product->status ?? '') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- ============================================================ --}}
                {{-- DYNAMIC SIZES & STOCK (Alpine.js) --}}
                {{-- ============================================================ --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400">Sizes & Stock</h3>
                            <p class="text-xs text-gray-400 mt-1">Add available sizes and their stock quantities.</p>
                        </div>
                        <button type="button" @click="addSize()"
                                class="inline-flex items-center gap-1.5 bg-gray-900 text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider hover:bg-gray-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Add Size
                        </button>
                    </div>

                    {{-- Size Rows --}}
                    <div class="space-y-3">
                        <template x-for="(item, index) in sizes" :key="index">
                            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 group hover:border-gray-300 transition">
                                {{-- Size Number --}}
                                <div class="w-12 h-12 bg-gray-900 text-white rounded-lg flex items-center justify-center font-black text-sm brand-font flex-shrink-0"
                                     x-text="item.size || '?'"></div>

                                {{-- Size Input --}}
                                <div class="flex-1">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Size</label>
                                    <input type="text" :name="'sizes['+index+'][size]'" x-model="item.size"
                                           placeholder="e.g. 42"
                                           class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition"
                                           required>
                                </div>

                                {{-- Stock Input --}}
                                <div class="flex-1">
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Stock</label>
                                    <input type="number" :name="'sizes['+index+'][stock]'" x-model="item.stock"
                                           placeholder="0"
                                           class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition"
                                           min="0" required>
                                </div>

                                {{-- Remove Button --}}
                                <button type="button" @click="removeSize(index)"
                                        class="p-2 rounded-lg text-gray-300 hover:text-red-500 hover:bg-red-50 transition mt-5"
                                        x-show="sizes.length > 1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </template>
                    </div>

                    {{-- Quick Add Popular Sizes --}}
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Quick Add Sizes:</p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="s in [36, 37, 38, 39, 40, 41, 42, 43, 44, 45]" :key="s">
                                <button type="button" @click="quickAddSize(s)"
                                        :class="sizes.some(item => item.size == s) ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                                        class="w-10 h-10 rounded-lg text-xs font-bold transition"
                                        x-text="s"
                                        :disabled="sizes.some(item => item.size == s)">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex items-center gap-4">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-gray-900 text-white px-8 py-4 rounded-xl font-bold text-sm uppercase tracking-wider hover:bg-gray-800 transition shadow-lg shadow-gray-900/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ isset($product) ? 'Update Product' : 'Save Product' }}
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                       class="px-6 py-4 rounded-xl text-sm font-bold text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition">
                        Cancel
                    </a>
                </div>

            </div>
        </div>
    </form>

    {{-- Alpine.js Component --}}
    <script>
        function productForm() {
            return {
                imagePreview: {!! isset($product) && $product->thumbnail ? "'" . e($product->thumbnail) . "'" : 'null' !!},
                sizes: {!! isset($product) && $product->sizes->count()
                    ? $product->sizes->map(fn($s) => ['size' => $s->size, 'stock' => $s->stock])->toJson()
                    : json_encode([['size' => '', 'stock' => 0]])
                !!},

                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.imagePreview = URL.createObjectURL(file);
                    }
                },

                addSize() {
                    this.sizes.push({ size: '', stock: 0 });
                },

                removeSize(index) {
                    if (this.sizes.length > 1) {
                        this.sizes.splice(index, 1);
                    }
                },

                quickAddSize(s) {
                    if (!this.sizes.some(item => item.size == s)) {
                        this.sizes.push({ size: String(s), stock: 0 });
                    }
                }
            }
        }
    </script>

@endsection

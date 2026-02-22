<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Tampilkan daftar semua produk beserta jumlah stok total.
     */
    public function index(Request $request)
    {
        $products = Product::with(['category', 'sizes'])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('brand', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Tampilkan form untuk menambah produk baru.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.form', compact('categories'));
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'brand'       => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'status'      => 'required|in:active,draft,archived',
            'thumbnail'   => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sizes'       => 'required|array|min:1',
            'sizes.*.size'  => 'required|string|max:10',
            'sizes.*.stock' => 'required|integer|min:0',
        ]);

        // Upload gambar
        $thumbnailPath = $request->file('thumbnail')->store('products', 'public');

        // Buat produk
        $product = Product::create([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']) . '-' . Str::random(5),
            'brand'       => strtoupper($validated['brand']),
            'category_id' => $validated['category_id'],
            'price'       => $validated['price'],
            'description' => $validated['description'],
            'status'      => $validated['status'],
            'thumbnail'   => '/storage/' . $thumbnailPath,
        ]);

        // Simpan ukuran & stok
        foreach ($validated['sizes'] as $size) {
            ProductSize::create([
                'product_id' => $product->id,
                'size'       => $size['size'],
                'stock'      => $size['stock'],
            ]);
        }

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk "' . $product->name . '" berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit produk.
     */
    public function edit(Product $product)
    {
        $product->load('sizes');
        $categories = Category::all();
        return view('admin.products.form', compact('product', 'categories'));
    }

    /**
     * Update data produk yang ada.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'brand'       => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'status'      => 'required|in:active,draft,archived',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sizes'       => 'required|array|min:1',
            'sizes.*.size'  => 'required|string|max:10',
            'sizes.*.stock' => 'required|integer|min:0',
        ]);

        $data = [
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']) . '-' . Str::random(5),
            'brand'       => strtoupper($validated['brand']),
            'category_id' => $validated['category_id'],
            'price'       => $validated['price'],
            'description' => $validated['description'],
            'status'      => $validated['status'],
        ];

        // Jika ada gambar baru, hapus yang lama dan upload yang baru
        if ($request->hasFile('thumbnail')) {
            // Hapus gambar lama dari storage
            $oldPath = str_replace('/storage/', '', $product->thumbnail);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            $thumbnailPath = $request->file('thumbnail')->store('products', 'public');
            $data['thumbnail'] = '/storage/' . $thumbnailPath;
        }

        $product->update($data);

        // Update ukuran: Hapus semua lalu buat ulang (sync approach)
        $product->sizes()->delete();
        foreach ($validated['sizes'] as $size) {
            ProductSize::create([
                'product_id' => $product->id,
                'size'       => $size['size'],
                'stock'      => $size['stock'],
            ]);
        }

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk "' . $product->name . '" berhasil diperbarui!');
    }

    /**
     * Hapus produk dan file gambar dari storage.
     */
    public function destroy(Product $product)
    {
        // Hapus file gambar dari storage
        $imagePath = str_replace('/storage/', '', $product->thumbnail);
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        // Hapus produk (sizes otomatis terhapus karena cascade)
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil dihapus!');
    }
}

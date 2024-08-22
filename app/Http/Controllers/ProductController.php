<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    // Method untuk menampilkan daftar produk
    public function index()
    {
        $products = Product::orderBy('id')->paginate(20);
        $category = Category::all(); // Ambil semua kategori
        $supplier = Supplier::all(); // Ambil semua supplier
        return view('products.index', ['products' => $products, 'category' => $category, 'supplier' => $supplier]);
    }

    // Method untuk menyimpan produk baru
    public function tambah(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name|regex:/^[a-zA-Z]+$/',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.string' => 'Nama harus berupa angka',
            'name.unique' => 'Nama produk telah digunakan, silakan gunakan nama yang berbeda.',
            'name.regex' => 'Nama produk hanya boleh berisi huruf.',
            'category_id.required' => 'Kategori produk wajib diisi.',
            'category_id.exists' => 'Kategori tidak valid.',
        ]);

        try {
            Product::create($request->only('name', 'quantity', 'category_id', 'supplier_id'));
            return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Produk gagal ditambahkan.');
        }
    }

    // Method untuk memperbarui produk
    public function edit(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Produk tidak ditemukan.');
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')->ignore($product->id),
            ],
            'category_id' => 'required|exists:categories,id'
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.unique' => 'Nama produk telah digunakan, silakan gunakan nama yang berbeda.',
            'category_id.required' => 'Kategori produk wajib diisi.',
            'category_id.exists' => 'Kategori tidak valid.',
        ]);

        try {
            $product->update($request->only('name', 'quantity', 'category_id', 'supplier_id'));
            return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Produk gagal diperbarui. ');
        }
    }

    // Method untuk menghapus produk
    public function hapus($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Produk tidak ditemukan.');
        }

        try {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('products.index')->with('error', 'Data produk digunakan di tabel lain');
            }
            return redirect()->route('products.index')->with('error', 'Produk gagal dihapus.');
        }
    }
}








// namespace App\Http\Controllers;

// use App\Models\Product;
// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;


// class ProductController extends Controller
// {
//     public function index()
//     {
//         $products = Product::all();
//         return view('products.index', compact('products'));
//     }

//     public function create()
//     {
//         return view('products.create');
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'price' => 'required|numeric|min:0',
//         ]);

//         Product::create($request->all());

//         return redirect()->route('products.index')
//                         ->with('success', 'Product created successfully.');
//     }

//     public function show(Product $product)
//     {
//         return view('products.show', compact('product'));
//     }

//     public function edit($id, Request $request)
//     {
//         // return view('products.edit', compact('product'));
//         $product = 
//     }

//     public function update(Request $request, Product $product)
//     {
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'price' => 'required|numeric|min:0',
//         ]);

//         $product->update($request->all());

//         return redirect()->route('products.index')
//                         ->with('success', 'Product updated successfully.');
//     }

//     public function destroy(Product $product)
//     {
//         $product->delete();

//         return redirect()->route('products.index')
//                         ->with('success', 'Product deleted successfully.');
//     }
// }

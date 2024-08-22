<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportRequest;
use App\Models\Import;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Exception;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imports = Import::all();
        $products = Product::all();
        return view('importProduct.index', compact('imports', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('importProduct.create', compact('products', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImportRequest $request)
    {
        try {
            $validatedData = $request->validated();
            Product::increaseQuantity($validatedData['product_id'] , $validatedData['quantity']);
            $importProduct = Import::create($validatedData);
            return redirect()->route('imports.index')->with('success', 'Jumlah produk berhasil diperbarui');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to import product: ' . $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Import $import)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $import = Import::findOrFail($id);
        $products = Product::all(); 
        $suppliers = Supplier::all();
        return view('importProduct.edit', compact('import', 'products', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, ImportRequest $request)
    {
        try {
            $validatedData = $request->validated();
        $oldImport = Import::findOrFail($id);
        $oldProductId = $oldImport->product_id;
        $oldQuantity = $oldImport->quantity;
        $newProductId = $validatedData['product_id'];
        $newQuantity = $validatedData['quantity'];
        Product::decreaseQuantity($oldProductId, $oldQuantity);
        Product::increaseQuantity($newProductId, $newQuantity);
        $oldImport->update($validatedData);
            return redirect()->route('imports.index')->with('success', 'Berhasil Diperbarui');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $oldImport = Import::findOrFail($id);
            $oldProductId = $oldImport->product_id;
            $oldQuantity = $oldImport->quantity;

            Product::decreaseQuantity($oldProductId, $oldQuantity);

            $oldImport->delete();
                return redirect()->route('imports.index')->with('success', 'Berhasil Dihapus');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}

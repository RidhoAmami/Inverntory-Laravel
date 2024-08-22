<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportRequest;
use App\Models\Export;
use Illuminate\Http\Request;
use App\Models\Product;
use Exception;

class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exports = Export::all();
        return view('exportProduct.index', compact('exports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('exportProduct.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExportRequest $request)
    {
        try {
            $validatedData = $request->validated();
            Product::decreaseQuantity($validatedData['product_id'] , $validatedData['quantity']);
            $exportProduct = Export::create($validatedData);
            return redirect()->route('exports.index')->with('success', 'Jumlah produk berhasil diperbarui');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to export product: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Export $export)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $export = Export::findOrFail($id);
        $products = Product::all(); 
        return view('exportProduct.edit', compact('export', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, ExportRequest $request)
    {
        try {
            $validatedData = $request->validated();
        $oldImport = Export::findOrFail($id);
        $oldProductId = $oldImport->product_id;
        $oldQuantity = $oldImport->quantity;
        $newProductId = $validatedData['product_id'];
        $newQuantity = $validatedData['quantity'];
        Product::increaseQuantity($oldProductId, $oldQuantity);
        Product::decreaseQuantity($newProductId, $newQuantity);
        $oldImport->update($validatedData);
            return redirect()->route('exports.index')->with('success', 'Berhasil Diperbarui');
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
            $oldImport = Export::findOrFail($id);
            $oldProductId = $oldImport->product_id;
            $oldQuantity = $oldImport->quantity;

            Product::increaseQuantity($oldProductId, $oldQuantity);

            $oldImport->delete();
                return redirect()->route('exports.index')->with('success', 'Berhasil Dihapus');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}

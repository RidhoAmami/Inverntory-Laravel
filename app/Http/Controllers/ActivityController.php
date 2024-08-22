<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Models\Activity;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::all();
        return view('activities.index', compact('activities'));
    }

    public function create()
    {
        $products = Product::all();
        return view('activities.create', compact('products'));
    }

    public function store(ActivityRequest $request)
    {
        Log::info('Request received in store method', $request->all());
        $validated = $request->validated();
        // dd($validated, $request->all());

        try {
            $activity = Activity::create($validated);

            // Update jumlah produk berdasarkan aksi
            $product = Product::find($request->input('product_id'));

            if (!$product) {
                // Produk tidak ditemukan, redirect dengan error
                return redirect()->route('activities.index')
                    ->with('error', 'Produk tidak ditemukan.');
            }

            // Pastikan kode di bawah ini selalu dijalankan jika kondisi sebelumnya terpenuhi
            if ($request->input('aksi') === 'keluar') {
                if ($request->input('quantity') > $product->quantity) {
                    // Jumlah lebih besar dari yang tersedia, redirect dengan error
                    return redirect()->route('activities.index')
                        ->with('error', 'Jumlah tidak boleh melebihi jumlah produk yang tersedia.');
                }
                // Decrement quantity
                $product->decrement('quantity', $request->input('quantity'));
            } elseif ($request->input('aksi') === 'masuk') {
                // Increment quantity
                $product->increment('quantity', $request->input('quantity'));
            }

            // Redirect dengan sukses jika semua langkah berhasil
            return redirect()->route('activities.index')
                ->with('success', 'Aktivitas berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Redirect dengan error jika ada pengecualian
            return redirect()->route('activities.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }




    public function show(Activity $activity)
    {
        return view('activities.show', compact('activity'));
    }

     public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        $products = Product::all(); // Ambil semua produk untuk dropdown
        return view('activities.edit', compact('activity', 'products'));
    }

    public function update($id, ActivityRequest $request, Activity $activity)
{
    $activity = Activity::findOrFail($id);
    $validated = $request->validated();
    $oldProductId = $activity->product_id;
    $oldQuantity = $activity->quantity;
    $oldAction = $activity->aksi;

    $newProductId = $request->input('product_id');
    $newQuantity = $request->input('quantity');
    $newAction = $request->input('aksi');

    try {
        // Mengembalikan kuantitas produk lama
        $this->restoreOldProductQuantity($oldProductId, $oldQuantity, $oldAction);

        // Perbarui aktivitas
        $activity->update($validated);

        // Terapkan kuantitas dan aksi baru
        $this->applyNewProductQuantity($newProductId, $newQuantity, $newAction);

        return redirect()->route('activities.index')->with('success', 'Aktivitas berhasil diperbarui.');
    } catch (\Exception $e) {
        return redirect()->route('activities.edit', [$id])
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}


protected function restoreOldProductQuantity($productId, $quantity, $action)
{
    $product = Product::find($productId);
    if ($product) {
        if ($action === 'keluar') {
            $product->increment('quantity', $quantity);
        } elseif ($action === 'masuk') {
            $product->decrement('quantity', $quantity);
        }
    } else {
        throw new \Exception('Produk lama tidak ditemukan.');
    }
}

protected function applyNewProductQuantity($productId, $quantity, $action)
{
    $product = Product::find($productId);
    if ($product) {
        if ($action === 'keluar') {
            $product->decrement('quantity', $quantity);
        } elseif ($action === 'masuk') {
            $product->increment('quantity', $quantity);
        }
    } else {
        throw new \Exception('Produk baru tidak ditemukan.');
    }
}



    public function destroy($id)
    {
        try {
            $activity = Activity::findOrFail($id);
            $activity->delete();

            return redirect()->route('activities.index')->with('success', 'Aktivitas berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('activities.index')->with('error', 'Terjadi kesalahan saat menghapus aktivitas.');
        }
    }

}

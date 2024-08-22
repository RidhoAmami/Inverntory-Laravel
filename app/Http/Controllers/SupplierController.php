<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name|',
            'no_telepon' => 'required|string|max:15|unique:suppliers,no_telepon|regex:/^[0-9]+$/',
            'email' => 'required|email|max:255|unique:suppliers,email',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.unique' => 'Nama telah digunakan, silakan gunakan nama yang berbeda.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.string' => 'Nomor telepon harus berupa angka.',
            'no_telepon.max' => 'Nomor telepon maksimal 15 karakter.',
            'no_telepon.unique' => 'No telepon telah digunakan, silakan gunakan no telepon yang berbeda.',
            'no_telepon.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email telah digunakan, silakan gunakan email yang berbeda.',
        ]);

        try {
            Supplier::create($request->only('name', 'no_telepon', 'email'));
            return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('suppliers.index')->with('error', 'Supplier gagal ditambahkan.');
        }
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('suppliers', 'name')->ignore($supplier->id),
            ],
            'no_telepon' => 'required|string|max:20',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('suppliers', 'email')->ignore($supplier->id),
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.unique' => 'Nama telah digunakan, silakan gunakan nama yang berbeda.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.string' => 'Nomor telepon harus berupa string.',
            'no_telepon.max' => 'Nomor telepon maksimal 15 karakter.',
            'no_telepon.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'no_telepon.unique' => 'No telepon telah digunakan, silakan gunakan no telepon yang berbeda.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email telah digunakan, silakan gunakan email yang berbeda.',
        ]);

        try {
            $supplier->update($request->only('name', 'no_telepon', 'email'));
            return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('suppliers.index')->with('error', 'Supplier gagal diperbarui.');
        }
    }

    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('suppliers.index')->with('error', 'Supplier sedang digunakan, tidak bisa dihapus.');
            }
            return redirect()->route('suppliers.index')->with('error', 'Terjadi kesalahan.');
        }
    }
}

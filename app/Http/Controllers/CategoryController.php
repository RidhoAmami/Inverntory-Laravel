<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.unique' => 'Nama telah digunakan, silakan gunakan nama yang berbeda.',
        ]);

        try {
            Category::create($request->only('name'));
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Kategori gagal ditambahkan.');
        }
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($category->id),
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.unique' => 'Nama telah digunakan, silakan gunakan nama yang berbeda.',
        ]);

        try {
            $category->update($request->only('name'));
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Kategori gagal diperbarui.');
        }
    }

public function destroy(Category $category)
{
    try {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category berhasil dihapus.');
    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->getCode() === '23000') {
            return redirect()->route('categories.index')->with('error', 'Kategori sedang digunakan, tidak bisa dihapus');
        }
        return redirect()->route('categories.index')->with('error', 'Terjadi kesalahan');
}
}
}
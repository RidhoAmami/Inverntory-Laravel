<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;
use Illuminate\Validation\Validator;

class ExportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $productId = $this->input('product_id');
            $quantityRequested = $this->input('quantity');

            $product = Product::find($productId);

            if (!$product) {
                $validator->errors()->add('product_id', 'Produk tidak ditemukan.');
                return;
            }

            if ($quantityRequested > $product->quantity) {
                $validator->errors()->add('quantity', 'Jumlah yang diminta melebihi stok yang tersedia.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Produk Wajib Dipilih',
            'product_id.exists' => 'Produk Tidak Valid',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.integer' => 'Jumlah harus berupa angka.',
            'quantity.min' => 'Jumlah tidak boleh kurang dari 1.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal harus berupa format tanggal yang valid.',
        ];
    }
}

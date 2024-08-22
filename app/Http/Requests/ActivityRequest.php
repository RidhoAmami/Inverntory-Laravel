<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Models\Product;
class ActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Atur sesuai kebutuhan otorisasi Anda
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
            'aksi' => 'required|in:masuk,keluar',
            'quantity' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Produk wajib dipilih.',
            'product_id.exists' => 'Produk tidak valid.',
            'aksi.required' => 'Aksi wajib dipilih.',
            'aksi.in' => 'Aksi hanya bisa bernilai "masuk" atau "keluar".',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.integer' => 'Jumlah harus berupa angka.',
            'quantity.min' => 'Jumlah tidak boleh kurang dari 1.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal harus berupa format tanggal yang valid.',
        ];
    }

    
    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $product = Product::find($this->input('product_id'));

            if ($product) {
                if ($this->input('aksi') === 'keluar' && $this->input('quantity') > $product->quantity) {
                    $validator->errors()->add('quantity', 'Jumlah tidak boleh melebihi jumlah produk yang tersedia.');
                }
            } else {
                $validator->errors()->add('product_id', 'Produk tidak ditemukan.');
            }
        });
    }
}

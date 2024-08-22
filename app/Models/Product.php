<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'category_id',
    ];

    public static function increaseQuantity(int $productId, int $quantity)
    {
        $product = self::find($productId);
        if ($product) {
            $product->quantity += $quantity;
            $product->save();
        } else {
            throw new \Exception('Product tidak tersedia');
        }
    }
    public static function decreaseQuantity(int $productId, int $quantity)
    {
        $product = self::find($productId);
        if ($product) {
            if ($quantity > $product->quantity) {
                throw new \Exception('Jumlah barang lebih sedikit daripada Jumlah yang dimasukkan');
            }
            $product->quantity -= $quantity;
            $product->save();
        } else {
            throw new \Exception('Produk tidak tersedia');
        }
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function imports()
    {
        return $this->hasMany(Import::class);
    }

    public function exports(){
        return $this->hasMany(Export::class);
    }
}

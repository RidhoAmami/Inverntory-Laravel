<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $fillable=[
        'product_id',
        'supplier_id',
        'quantity',
        'tanggal'
    ];

    protected $casts=[
        'tanggal'=>'datetime:Y-m-d'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}

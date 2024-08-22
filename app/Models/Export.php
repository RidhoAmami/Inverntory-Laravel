<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    use HasFactory;

    protected $fillable=[
        'product_id',
        'quantity',
        'tanggal'
    ];

    protected $casts=[
        'tanggal'=>'date:Y-m-d'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'no_telepon',
        'email'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function imports()
    {
        return $this->hasMany(Import::class);
    }
}

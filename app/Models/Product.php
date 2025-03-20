<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'product_id');
    }

    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'stock',
        'image',
        'description',
    ];
}

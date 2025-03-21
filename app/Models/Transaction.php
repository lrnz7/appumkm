<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    use HasFactory;

    protected $table = 'transactions'; // Sesuai nama tabel di database
    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'description',
        'transaction_date',
        'product_id',
        'customer_name',
        'quantity'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2'
    ];
}

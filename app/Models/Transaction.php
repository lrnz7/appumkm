<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'description',
        'type',
        'transaction_date',
    ];

    // Relasi ke User (1 transaksi punya 1 user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

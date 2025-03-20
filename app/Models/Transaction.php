<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions'; // Sesuai nama tabel di database
    protected $fillable = ['user_id', 'amount', 'status', 'description', 'type', 'transaction_date', 'product_id'];
}

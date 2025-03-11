<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Primary key (auto increment)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke user
            $table->decimal('amount', 15, 2); // Nominal transaksi (max 15 digit, 2 angka desimal)
            $table->string('description'); // Keterangan transaksi
            $table->enum('type', ['income', 'expense']); // Jenis transaksi: pemasukan atau pengeluaran
            $table->dateTime('transaction_date'); // Waktu transaksi
            $table->timestamps(); // created_at & updated_at otomatis
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

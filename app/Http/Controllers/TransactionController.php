<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Tampilkan semua transaksi
    public function index()
    {
        $transactions = Transaction::all();
        return view('transactions.index', compact('transactions'));
    }

    // Tampilkan form untuk memasukkan transaksi baru
    public function create()
    {
        return view('transactions.create'); // Create a new view for transaction creation
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|min:3|max:100',
            'product_name' => 'required|string|min:3|max:100',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,completed,cancelled',
            'description' => 'required|string|max:255', // Added validation for description
            'amount' => 'required|numeric', // Added validation for amount
            'transaction_date' => 'required|date', // Added validation for transaction_date
        ]);

        \Log::info('Incoming request data:', $request->all()); // Log incoming request data
        $transaction = Transaction::create($request->all()); // Ensure all required fields are included
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    // Tampilkan satu transaksi
    public function show(Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    // Edit transaksi
    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', compact('transaction'));
    }

    // Update transaksi
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'customer_name' => 'required|string|min:3|max:100',
            'product_name' => 'required|string|min:3|max:100',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $transaction->update($request->all());
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    // Hapus transaksi
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus');
    }
}

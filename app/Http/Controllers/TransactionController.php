<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product; // Import the Product model
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
        $products = Product::all(); // Fetch all products for selection
        return view('transactions.create', compact('products')); // Pass products to the view
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|min:3|max:100',
            'product_id' => 'required|exists:products,id', // Validate product_id
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,completed,cancelled',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
        ]);

        \Log::info('Incoming request data:', $request->all());
        $userId = auth()->id();
        $transaction = Transaction::create(array_merge($request->all(), ['user_id' => $userId ? $userId : null]));
        $product = Product::find($request->product_id);
        $product->decrement('stock', $request->quantity); // Decrease stock
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
        $products = Product::all(); // Fetch all products for selection
        return view('transactions.edit', compact('transaction', 'products')); // Pass products to the view
    }

    // Update transaksi
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'customer_name' => 'required|string|min:3|max:100',
            'product_id' => 'required|exists:products,id', // Validate product_id
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $transaction->update($request->all());
        $product = Product::find($request->product_id);
        $product->decrement('stock', $request->quantity); // Decrease stock
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    // Hapus transaksi
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus');
    }
}

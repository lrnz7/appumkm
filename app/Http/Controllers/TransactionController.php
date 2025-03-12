<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Tampilkan semua transaksi
    public function index()
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['message' => 'Unauthorized: No user logged in'], 401);
        }

        $transactions = Transaction::where('user_id', $userId)->get();

        return $transactions->isEmpty()
            ? response()->json(['message' => 'No transactions found', 'user_id' => $userId], 404)
            : response()->json(['transactions' => $transactions]);
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000', // Minimal 1000 biar gak aneh-aneh
            'description' => 'required|string|min:5|max:255', // Deskripsi minimal 5 karakter
            'type' => 'required|in:income,expense', // Hanya bisa "income" atau "expense"
            'transaction_date' => 'required|date',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['message' => 'Unauthorized: No user logged in'], 401);
        }

        $transaction = Transaction::create([
            'user_id' => $userId,
            'amount' => $request->amount,
            'description' => $request->description,
            'type' => $request->type,
            'transaction_date' => $request->transaction_date,
        ]);

        return response()->json(['message' => 'Transaction created', 'transaction' => $transaction], 201);
    }

    // Tampilkan satu transaksi
    public function show(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($transaction);
    }

    // Update transaksi
    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'amount' => 'nullable|numeric|min:1000', // Bisa di-update tapi minimal 1000
            'description' => 'nullable|string|min:5|max:255', // Bisa di-update tapi minimal 5 karakter
            'type' => 'nullable|in:income,expense',
            'transaction_date' => 'nullable|date',
        ]);

        $transaction->update($request->all());
        return response()->json(['message' => 'Transaction updated', 'transaction' => $transaction]);
    }

    // Hapus transaksi
    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $transaction->delete();
        return response()->json(['message' => 'Transaction deleted']);
    }
}

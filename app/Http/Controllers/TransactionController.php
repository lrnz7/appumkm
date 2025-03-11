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
        $transactions = Transaction::where('user_id', Auth::id())->get();
        return response()->json($transactions);
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'type' => 'required|in:income,expense',
            'transaction_date' => 'required|date',
        ]);

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'description' => $request->description,
            'type' => $request->type,
            'transaction_date' => $request->transaction_date,
        ]);

        return response()->json($transaction, 201);
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
            'amount' => 'numeric',
            'description' => 'string',
            'type' => 'in:income,expense',
            'transaction_date' => 'date',
        ]);

        $transaction->update($request->all());
        return response()->json($transaction);
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

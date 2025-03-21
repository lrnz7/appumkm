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
        $products = Product::distinct()->get(); // Fetch all unique products for selection
        return view('transactions.create', compact('products')); // Pass products to the view
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        \Log::info('Request data before validation:', $request->all());

        $request->validate([
            'customer_name' => 'required|string|min:3|max:100',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,completed,cancelled',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date'
        ]);

        try {
            // Check stock availability before creating transaction
            $userId = auth()->id();
            $product = Product::find($request->product_id);
            
            if ($product->stock < $request->quantity) {
                return redirect()->back()
                    ->withErrors(['error' => 'Insufficient stock available.'])
                    ->withInput();
            }

            // Calculate amount based on product price and quantity
            $amount = $product->price * $request->quantity;
            
            // Create transaction
            $transaction = Transaction::create([
                'user_id' => $userId ? $userId : null,
                'customer_name' => $request->customer_name,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'status' => $request->status,
                'description' => $request->description,
                'amount' => $amount,
                'transaction_date' => $request->transaction_date
            ]);
            
            // Decrease stock after successful transaction creation
            $product->decrement('stock', $request->quantity);
            
            \Log::info('Transaction created successfully', [
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'amount' => $amount
            ]);

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil ditambahkan');
                
        } catch (\Exception $e) {
            \Log::error('Failed to create transaction: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create transaction. Please try again.'])
                ->withInput();
        }
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
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,completed,cancelled',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric'
        ]);

        try {
            // Get the old and new products
            $oldProduct = Product::find($transaction->product_id);
            $newProduct = Product::find($request->product_id);
            
            // If product is changed or quantity is different, update stock
            if ($transaction->product_id != $request->product_id || $transaction->quantity != $request->quantity) {
                // Restore old product stock
                $oldProduct->increment('stock', $transaction->quantity);
                
                // Check if new product has enough stock
                if ($newProduct->stock < $request->quantity) {
                    // Revert old product stock change
                    $oldProduct->decrement('stock', $transaction->quantity);
                    return redirect()->back()
                        ->withErrors(['error' => 'Insufficient stock available for the selected product.'])
                        ->withInput();
                }
                
                // Decrease new product stock
                $newProduct->decrement('stock', $request->quantity);
            }

            // Calculate new amount based on product price and quantity
            $amount = $newProduct->price * $request->quantity;
            
            // Update transaction
            $transaction->update([
                'customer_name' => $request->customer_name,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'status' => $request->status,
                'description' => $request->description,
                'transaction_date' => $request->transaction_date,
                'amount' => $amount
            ]);

            return redirect()->route('transactions.index')
                ->with('success', 'Transaction updated successfully');
                
        } catch (\Exception $e) {
            \Log::error('Transaction update error: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update transaction. Please try again.'])
                ->withInput();
        }
    }

    // Hapus transaksi
    public function destroy(Transaction $transaction)
    {
        try {
            $transaction->delete();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete transaction.']);
        }
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus');
    }
}

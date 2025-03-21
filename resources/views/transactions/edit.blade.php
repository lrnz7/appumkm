@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Transaction</h1>
    <style>
        .form-control {
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .text-danger {
            font-size: 0.875em;
        }
    </style>

    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" class="row g-3">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="customer_name">Customer Name</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $transaction->customer_name }}" required>
            @if ($errors->has('customer_name'))
                <div class="text-danger">{{ $errors->first('customer_name') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="product_id">Product</label>
            <select class="form-control" id="product_id" name="product_id" required>
                <option value="">Select a product</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" {{ $transaction->product_id == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
            @if ($errors->has('product_id'))
                <div class="text-danger">{{ $errors->first('product_id') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $transaction->quantity }}" required>
            @if ($errors->has('quantity'))
                <div class="text-danger">{{ $errors->first('quantity') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ $transaction->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $transaction->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @if ($errors->has('status'))
                <div class="text-danger">{{ $errors->first('status') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required>{{ $transaction->description }}</textarea>
            @if ($errors->has('description'))
                <div class="text-danger">{{ $errors->first('description') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" class="form-control" id="amount" name="amount" value="{{ $transaction->amount }}" required>
            @if ($errors->has('amount'))
                <div class="text-danger">{{ $errors->first('amount') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="transaction_date">Transaction Date</label>
            <input type="date" class="form-control" id="transaction_date" name="transaction_date" value="{{ $transaction->transaction_date }}" required>
            @if ($errors->has('transaction_date'))
                <div class="text-danger">{{ $errors->first('transaction_date') }}</div>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Transaction</button>
        </div>
    </form>
</div>
@endsection

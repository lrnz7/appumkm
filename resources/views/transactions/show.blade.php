<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Detail Transaksi</h2>

    <div class="mb-3">
        <strong>ID:</strong> {{ $transaction->id }}<br>
        <strong>Nama Pelanggan:</strong> {{ $transaction->customer_name }}<br>
        <strong>Produk:</strong> {{ $transaction->product ? $transaction->product->name : 'Product not found' }}<br>
        <strong>Deskripsi:</strong> {{ $transaction->description }}<br>
        <strong>Jumlah:</strong> {{ $transaction->quantity }}<br>
        <strong>Status:</strong> {{ ucfirst($transaction->status) }}<br>
        <strong>Tanggal Transaksi:</strong> {{ $transaction->transaction_date }}<br>
    </div>

    <a href="{{ route('transactions.index') }}" class="btn btn-primary">Kembali</a>
</body>
</html>

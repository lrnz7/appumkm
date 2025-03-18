<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController; // Import Controller
use App\Http\Controllers\ProductController; // Import ProductController

Route::resource('products', ProductController::class); // Resource routes for products

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::get('/', function () {
    return redirect()->route('transactions.index');
});

// Product Catalog Route
Route::get('/products/catalog', [ProductController::class, 'catalog'])->name('products.catalog');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('ConvertEmptyStringsToNull');
Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('ConvertEmptyStringsToNull');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('ConvertEmptyStringsToNull');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('ConvertEmptyStringsToNull');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('ConvertEmptyStringsToNull');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('ConvertEmptyStringsToNull');
Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy'); // New route for deleting a transaction

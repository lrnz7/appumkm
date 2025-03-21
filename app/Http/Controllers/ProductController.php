<?php

namespace App\Http\Controllers;

use App\Models\Product; // Import the Product model
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the product catalog.
     *
     * @return \Illuminate\Http\Response
     */
    public function catalog()
    {
        $products = Product::all(); // Fetch all products for the catalog
        return view('products.catalog', compact('products')); // Return the catalog view
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all(); // Fetch all products
        return view('products.index', compact('products')); // Return the view with products
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create'); // Return the view for creating a new product
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        try {
            Product::create($request->all()); // Create a new product
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create product.'])->withInput();
        }
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product')); // Return the view for showing a product
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product')); // Return the view for editing a product
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        try {
            $product->update($request->all()); // Update the product
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update product.'])->withInput();
        }
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete(); // Delete the product
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete product.']);
        }
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}

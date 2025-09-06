<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Cek role, jika bukan administrator logout
        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login');
        }  

        $products = Product::paginate(10);

        return view('products.index', compact('products'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products|max:255',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('product.index')->with('success', 'Product berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $user = Auth::user();

        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login');
        } 

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:products,name,' . $product->id,
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('product.index')->with('success', 'Product berhasil diperbarui!');
    }

    /**
     * Toggle product status (optional)
     */
    public function destroy(Product $product)
    {
        $product->update([
            'status' => !$product->status,
        ]);

        $message = $product->status ? 'Product diaktifkan!' : 'Product dinonaktifkan!';

        return redirect()->route('product.index')->with('success', $message);
    }
}

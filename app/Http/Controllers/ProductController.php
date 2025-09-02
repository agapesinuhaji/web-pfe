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

        // Cek role, jika bukan psikolog logout
        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        }  

        $products = Product::all();

        return view('products.index', compact('products'));
    }


    public function store(Request $request)
    {
        
        Validator::make($request->all(), [
            'name' => 'required|unique:products|max:255',
            'price' => 'required',
        ])->validate();

        // create product
        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // redirect to product
        return redirect('/product')->with(['success' => 'Your product has been created!']);
    }

  
    public function edit(Product $product)
    {
        $user = Auth::user();

        // Cek role, jika bukan psikolog logout
        if ($user->role !== 'administrator') {
            Auth::logout();
            return redirect()->route('login'); // atau redirect ke halaman login
        } 

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:products,name' . $product->id,
            'price' => 'required',
        ])->validate();


        $status = $request->has('status') ? 1 : 0;

        
        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'status' => $status, 
        ]);

        // redirect to show product
        return redirect('/product')->with(['success' => 'Your product has been updated!']);
    }

}

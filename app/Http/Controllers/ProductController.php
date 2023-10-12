<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index() {
        $products = Product::all();

        return view('products.index', ['products' => $products]);
    }

    public function create() {
        return view('products.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|numeric|between:0,999999.99',
            'description' => 'nullable'
        ]);

         // You can format 'price' as a decimal with two decimal places if needed.
         $data['price'] = number_format($data['price'], 2);
        $newProduct = Product::create($data);
        
        return redirect()->route('product.index'); // 'product.index' is assumed to be the correct route name.
    }

    public function edit(Product $product) {
        return view('products.edit', ['product' => $product]);
    }

    public function update(Product $product, Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|numeric|between:0,999999.99',
            'description' => 'nullable'
        ]);

        $product->update($data);

        return redirect()->route('product.index')->with('success', 'Product Update Successfully');
    }

    public function destroy(Product $product) {
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product Deleted Successfully');
    }
}
 
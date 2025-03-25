<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller{
    public function products(){
        $categories = Category::all();
        $products = Product::all();
        return view('admin.dynamcomps.products', compact(['products', 'categories']));
    }

    public function addProduct(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->move('productimages');
        }
    
        Product::create($validated);
        return redirect()->route('products')->with('success', 'Product added!');
    }

    public function updateProduct(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $product = Product::findOrFail($id);
        $oldImage = $product->image;
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->move('products');
            if ($oldImage && file_exists(public_path('products/'.$oldImage))) {
                unlink(public_path('products/'.$oldImage));
            }
        } else {
            $validated['image'] = $product->image;
        }
        $product->update($validated);
        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function deleteProduct($id){
        $product = Product::find($id);
        if ($product->image && file_exists(public_path('products/'.$product->image))) {
            unlink(public_path('products/'.$product->image));
        }
        $product->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');;
    }
}
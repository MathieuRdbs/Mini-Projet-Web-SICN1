<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller{
    public function productsAdmin(){
        $categories = Category::all();
        $products = Product::paginate(4);
        return view('admin.dynamcomps.products', compact(['products', 'categories']));
    }

    public function addProduct(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|max:2048'
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
            'image' => 'nullable|image|max:2048'
        ]);
        $product = Product::findOrFail($id);
        $oldImage = $product->image;
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->move('productimages');
            if ($oldImage && file_exists($product->image)) {
                unlink($product->image);
            }
        } else {
            $validated['image'] = $product->image;
        }
        $product->update($validated);
        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function deleteProduct($id){
        $product = Product::find($id);
        if ($product->image && file_exists($product->image)) {
            unlink($product->image);
        }
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully');
    }
}
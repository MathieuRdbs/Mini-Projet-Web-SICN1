<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\Cart;

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

    public function showProductDetails($id)
    {
    $categories = Category::all();
    $product = Product::findOrFail($id);

    $cartItems = Cart::all();
    $cartItemCount = $cartItems->count();
    return view('products.productDetail', compact('product','categories','cartItemCount'));
    }
    public function buy()
    {
        $searchQuery = request('query');
        $categoryFilter = request('category');
        $priceFilter = request('price');
    
        $products = Product::with('category')
            ->when($searchQuery, function($query) use ($searchQuery) {
                $query->where(function($q) use ($searchQuery) {
                    $q->where('name', 'like', '%'.$searchQuery.'%')
                      ->orWhere('description', 'like', '%'.$searchQuery.'%')
                      ->orWhere('price', 'like', '%'.$searchQuery.'%')
                      ->orWhereHas('category', function($catQuery) use ($searchQuery) {
                          $catQuery->where('name', 'like', '%'.$searchQuery.'%');
                      });
                });
            })
            ->when($categoryFilter, function($query) use ($categoryFilter) {
                $query->whereHas('category', function($catQuery) use ($categoryFilter) {
                    $catQuery->where('category_name', $categoryFilter);
                });
            })
            ->when($priceFilter, function($query) use ($priceFilter) {
                switch($priceFilter) {
                    case 'price1': $query->where('price', '<', 100); break;
                    case 'price2': $query->whereBetween('price', [100, 400]); break;
                    case 'price3': $query->whereBetween('price', [400, 1000]); break;
                    case 'price4': $query->where('price', '>', 1000); break;
                }
            })
            ->orderBy('created_at', 'desc') // 👈 Sorting by newest
            ->paginate(12);
    
        return view('shop.buy', [
            'products' => $products,
            'categories' => Category::all(),
            'cartItemCount' => Cart::count()
        ]);
    }
    
}

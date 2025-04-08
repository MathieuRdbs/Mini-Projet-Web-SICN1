<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;

use App\Models\Category;

use App\Models\Cart;

use App\Models\Order;


class ContactController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        // Récupérer les 3 premiers produits (ou tous les produits que tu souhaites)
        $products = Product::limit(6)->get();

        //Retourne toutes les catégories
        $categories = Category::all();
        if(!$user){
            $orderId = [];
            $cartItemCount= 0;
        }else{
            $orderIds = Order::where('user_id', $user->id)->pluck('id');
            $cartItems = Cart::all();
            $cartItemCount = $cartItems->count();
        }


        // Retourner la vue principale en passant les produits récupérés
        return view('contact.contact', compact('categories','products','cartItemCount'));
    }
}


<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;

use App\Models\Category;

class homeController extends Controller{

    public function showhome(Request $request){
        $user = Auth::user();

        return view('homepage', compact(['user']));
    }
    
    //pour afficher quelques produits sur la page d'accueil
    public function index()
    {
        // Récupérer les 3 premiers produits (ou tous les produits que tu souhaites)
        $products = Product::limit(6)->get();

        //Retourne toutes les catégories
        $categories = Category::all();

        // Retourner la vue principale en passant les produits récupérés
        return view('homepage', compact('categories','products'));
    }

}
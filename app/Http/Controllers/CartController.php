<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;



class CartController extends Controller
{
    //pour afficher les éléments du navbar dans la page index.blade.php
    public function showCart(){
        $user = Auth::user();
        //Retourne toutes les catégories
        $categories = Category::all();
        //Retourne les elements du Cart
        // $cartItems = Cart::where('order_id', $orderId)->get();

        if(!$user){
            $orderId = [];
            $cartItems = collect();
            $cartItemCount= 0;
        }else{
            $orderIds = Order::where('user_id', $user->id)->pluck('id');
            // $cartItems = Cart::all();
            $cartItems = Cart::whereIn('order_id', $orderIds)->get();
            $cartItemCount = $cartItems->count();
        }

       
        $products = Product::all();

        

        return view('cart.index',compact('user', 'categories','cartItems','products','cartItemCount'));
    }


    public function addToCart(Request $request)
    {
        // Récupérer l'ID du produit envoyé par le formulaire
        $productId = $request->input('product_id');
        
        // Vérifier si le produit existe
        $product = Product::find($productId);
        if (!$product) {
            return back()->withErrors('Produit non trouvé.');
        }
    

         // Vider la session pour être sûr de supprimer l'ancien order_id
        session()->forget('order_id');
        // Vérifier si une commande existe déjà dans la session
        $orderId = session()->get('order_id');

        Log::info('Vérification de order_id dans la session: ' . $orderId);
        
    
        // Si aucune commande n'existe dans la session, créer une commande dans Orders
        if (!$orderId) {

            // Si aucune commande n'existe dans la session, créer un nouvel `orderId`
            $orderId = rand(100000, 999999);  // Générer un ID de commande aléatoire
            session()->put('order_id', $orderId);  // Sauvegarder dans la session
            
            // Créer un nouvel enregistrement dans la table Orders
            try {
                $order = Order::create([
                    'user_id' => auth()->id(), // Associer l'utilisateur à la commande
                    'status' => 'pending',  // Statut de la commande
                    'shipping_address' => 'Adresse non définie',  // Exemple, tu peux ajouter l'adresse réelle
                    'total_price' => 0, // Par exemple, on initialise à 0
                    'payment_methode' => 'Non défini',  // Exemple de méthode de paiement
                ]);
                // Sauvegarder l'ID de la commande dans la session
                session()->put('order_id', $order->id);  // Utiliser l'ID généré automatiquement
                Log::info('Vérification de order_id dans la session: ' . session()->get('order_id'));
            } catch (\Exception $e) {
                // Si une erreur se produit lors de la création de la commande
                Log::error('Erreur lors de la création de la commande: ' . $e->getMessage());
                return back()->withErrors('Erreur lors de la création de la commande.');
            }
        }

    
        // Vérifier si l'élément est déjà dans le panier
        $cartItem = Cart::where('order_id', $orderId)
                        ->where('product_id', $productId)
                        ->first();
    
        if ($cartItem) {
            // Si le produit est déjà dans le panier, augmenter la quantité
            $cartItem->q_bought += 1;
            $cartItem->t_price = $cartItem->q_bought * $product->price;
            $cartItem->save();
        } else {
            // Si le produit n'est pas encore dans le panier, l'ajouter
            Cart::create([
                'order_id' => session()->get('order_id'),
                'product_id' => $productId,
                'q_bought' => 1,
                't_price' => $product->price,
            ]);
        }

        return redirect()->route('cart'); // Rediriger vers la vue du panier
    }

//methode pour augmenter et diminuer dynamiquement les produits dans le panier
    public function updateQuantity(Request $request)
{
    // Récupérer l'ID de l'élément du panier et l'action (augmenter ou diminuer)
    $cartItemId = $request->input('cart_item_id');
    $action = $request->input('action');
    
    // Trouver l'élément du panier
    $cartItem = Cart::find($cartItemId);
    
    if (!$cartItem) {
        return response()->json(['message' => 'Produit non trouvé dans le panier.'], 404);
    }
    
    // Modifier la quantité en fonction de l'action
    if ($action == 'increase') {
        $cartItem->q_bought += 1;
    } elseif ($action == 'decrease' && $cartItem->q_bought > 1) {
        $cartItem->q_bought -= 1;
    }

    // Recalculer le prix total
    $cartItem->t_price = $cartItem->q_bought * $cartItem->product->price;
    $cartItem->save();

    // Retourner la réponse avec les nouvelles données
    return response()->json([
        'message' => 'Quantité mise à jour avec succès.',
        'new_quantity' => $cartItem->q_bought,
        'new_total' => $cartItem->t_price
    ]);
}


public function destroy($cartItemId)
{
    // Trouver l'élément du panier à supprimer
    $cartItem = Cart::find($cartItemId);

    // Si l'élément existe, supprimer
    if ($cartItem) {
        $cartItem->delete(); // Supprimer l'élément
        return response()->json(['success' => true]);
    }

    // Si l'élément n'est pas trouvé, retourner une erreur
    return response()->json(['message' => 'Produit non trouvé dans le panier.'], 404);
}

        
    public function confirmOrder()
{
    // Récupérer l'ID de la commande de la session
    $orderId = session()->get('order_id');

    if (!$orderId) {
        return back()->withErrors('Aucune commande trouvée.');
    }

    // Créer une commande confirmée dans la table Orders
    $order = Order::find($orderId);
    $order->status = 'confirmée'; // Mettre à jour le statut de la commande
    $order->save();

    // Transférer les produits du panier vers la table OrderItems ou effectuer d'autres actions
    $cartItems = Cart::where('order_id', $orderId)->get();
    
    // Exemple pour transférer dans une table OrderItems :
    foreach ($cartItems as $cartItem) {
        OrderItem::create([
            'order_id' => $orderId,
            'product_id' => $cartItem->product_id,
            'quantity' => $cartItem->q_bought,
            'total_price' => $cartItem->t_price,
        ]);
        
        // Supprimer l'élément du panier
        $cartItem->delete();
    }

    // Finalement, vider l'ID de la commande de la session
    session()->forget('order_id');

    // Rediriger l'utilisateur vers la page de confirmation de commande
    return redirect()->route('order.confirmation');
}




}

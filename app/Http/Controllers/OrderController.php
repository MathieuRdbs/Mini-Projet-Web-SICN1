<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;


class OrderController extends Controller
{
    public function showOrdersAdmin()
    {
        $orders = Order::with(['user', 'carts.product'])->paginate(5);
        return view('admin.dynamcomps.orders', compact('orders'));
    }

    public function shipOrder($id)
    {
        try {

            $order = Order::findOrFail($id);
            foreach ($order->carts as $cart) {
                $product = Product::find($cart->Product->id);
                if (!$product) {
                    return redirect()->back()->with('error', "Product {$cart->Product->id} not found");
                }

                if ($product->quantity < $cart->q_bought) {
                    return redirect()->back()->with('error', "Insufficient quantity for product: {$product->name}");
                }

                if ($product->quantity == 0) {
                    return redirect()->back()->with('error', "Cannot ship order - product {$product->name} would be out of stock");
                }
            }
            foreach ($order->carts as $cart) {
                $product = Product::find($cart->Product->id);
                if ($product) {
                    $product->quantity -= $cart->q_bought;
                    $product->save();
                }
            }
            $order->update([
                'status' => 'shipping'
            ]);

            return redirect()->back()->with('success', 'Order shiped successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cancelOrder($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->update([
                'status' => 'canceled'
            ]);
            return redirect()->back()->with('success', 'Order canceled ');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

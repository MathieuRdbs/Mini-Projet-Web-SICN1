<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller{
    public function showOrdersAdmin(){
        $orders = Order::with(['user', 'carts.product'])->paginate(5);
        return view('admin.dynamcomps.orders', compact('orders'));
    }

    public function shipOrder($id){
        try {
            $order = Order::findOrFail($id);
            $order->update([
                'status' => 'shipping'
            ]);
            return redirect()->back()->with('success', 'Order shiped successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cancelOrder($id){  
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
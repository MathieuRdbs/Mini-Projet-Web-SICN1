<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;

use Stripe\Stripe;


class CartController extends Controller
{
    public function showCart()
    {
        $categories = Category::all();
        return view('cart.cartview', compact('categories'));
    }

    public function cashpayement(Request $request)
    {
        $orderData = json_decode($request->order_data, true);

        if (!$orderData) {
            return redirect()->back()->with('error', 'Invalid order data');
        }

        try {
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->total_price = $orderData['total'];
            $order->shipping_address = $orderData['address'];
            $order->save();

            foreach ($orderData['items'] as $item) {
                $cart = new Cart();
                $cart->order_id = $order->id;
                $cart->product_id = $item['id'];
                $cart->q_bought = $item['q_bought'];
                $cart->t_price = $item['price'] * $item['q_bought'];
                $cart->save();
            }

            return redirect()->back()
                ->with('success', 'Your order has been placed successfully!')
                ->with('clear_cart', true);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }

    public function showCardPaymentPage(){
        $categories = Category::all();
        return view('payment.card', compact('categories'));
    }

    public function processCardPayment(Request $request)
{
    Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    $orderData = json_decode($request->order_data, true);
    
    if (!$orderData) {
        return redirect()->route('cart')->with('error', 'Order data is missing');
    }

    try {
        $customer = \Stripe\Customer::create([
            'email' => Auth::user()->email,
            'name' => $request->cardholder_name,
            'payment_method' => $request->payment_method_id,
            'invoice_settings' => [
                'default_payment_method' => $request->payment_method_id
            ]
        ]);

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $orderData['total'] * 100,
            'currency' => 'usd',
            'customer' => $customer->id,
            'payment_method' => $request->payment_method_id,
            'off_session' => false,
            'confirm' => true,
            'return_url' => route('cart'),
            'description' => 'Order from ' . Auth::user()->email,
        ]);

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->total_price = $orderData['total'];
        $order->shipping_address = $orderData['address'];
        $order->payment_methode = 'card';
        $order->save();

        foreach ($orderData['items'] as $item) {
            $cart = new Cart();
            $cart->order_id = $order->id;
            $cart->product_id = $item['id'];
            $cart->q_bought = $item['q_bought'];
            $cart->t_price = $item['price'] * $item['q_bought'];
            $cart->save();
        }

        return redirect()->route('cart')
        ->with('success', 'Your order has been placed successfully!')
        ->with('clear_cart', true);

    } catch (\Stripe\Exception\CardException $e) {
        return redirect()->back()->with('error', $e->getMessage());
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
    }
}
    
}

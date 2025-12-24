<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function show(Product $product)
    {
        $paymentMethods = PaymentMethod::all();

        $defaultPaymentMethod = $paymentMethods->firstWhere('code','convenience');

        return view('purchase.purchase',compact('product','paymentMethods','defaultPaymentMethod'));
    }

    public function store(Request $request,Product $product)
    {

        Order::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'payment_method_id' => $request->payment_method_id,
            'price' => $product->price,
        ]);

        $product->update([
            'status' => 'sold',
        ]);


        if ($request->payment_method_id == 2) {
            Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $product->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('items.index'),
            'cancel_url' => route('purchase.show',$product),
            ]);

            return redirect($session->url);
        }
            return redirect()->route('items.index');
    }

}

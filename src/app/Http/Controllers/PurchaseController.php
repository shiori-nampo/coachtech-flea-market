<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Order;

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
        return redirect()->route('items.index');
    }
}

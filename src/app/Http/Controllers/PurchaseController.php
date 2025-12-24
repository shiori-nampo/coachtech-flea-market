<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;

    class PurchaseController extends Controller
    {
    public function show(Product $product)
    {
        $user = Auth::user();

        $paymentMethods = PaymentMethod::all();

        $defaultPaymentMethod = $paymentMethods->firstWhere('code','convenience');

        return view('purchase.purchase',compact('product','paymentMethods','defaultPaymentMethod','user'));
    }

    public function store(Request $request,Product $product)
    {
        $user = Auth::user();

        if ($product->status === 'sold') {
            return redirect()->back()->with('error','この商品はすでに購入されています');
        }


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

            $product->update([
            'status' => 'sold',
        ]);

            return redirect($session->url);
        }

        Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'payment_method_id' => $request->payment_method_id,
            'price' => $product->price,
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);
        
        $product->update([
            'status' => 'sold',
        ]);

        \Log::info('Product updated',['id' => $product->id, 'status' => $product->status]);

            return redirect()->route('items.index');
    }

    public function showAddressForm(Product $product)
    {
        $user = Auth::user();
        return view('purchase.address',compact('product','user'));
    }

    public function updateAddress(Request $request, Product $product)
    {
        $user = Auth::user();
        $user->update([
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('purchase.show',$product->id)
                        ->with('success','住所を更新しました');
    }

}

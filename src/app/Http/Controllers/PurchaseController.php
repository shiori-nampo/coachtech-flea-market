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

        $paymentMethodId = session("payment_method_{$product->id}");
        $paymentMethod = $paymentMethodId
        ? PaymentMethod::find($paymentMethodId)
        : null;

        return view('purchase.purchase',compact('product','user','paymentMethod'));
    }

    public function showPayment(Product $product)
    {
        $user = Auth::user();
        $paymentMethods = PaymentMethod::all();

        return view('purchase.payment',compact('product','paymentMethods','user'
        ));
    }


    public function updatePayment(Request $request, Product $product)
    {

        session([
            "payment_method_{$product->id}" => $request->payment_method_id,
        ]);

        return redirect()->route('purchase.show',$product->id);
    }



    public function store(PurchaseRequest $request,Product $product)
    {
        $user = Auth::user();

        if ($product->status === 'sold') {
            return redirect()->back();
        }

        $paymentMethodId = session("payment_method_{$product->id}");
        $paymentMethod = PaymentMethod::findOrFail($paymentMethodId);

        $orderData = [
            'user_id'=> $user->id,
            'product_id' => $product->id,
            'payment_method_id' => $paymentMethod->id,
            'price' => $product->price,
            'postal_code' => session("postal_code_{$product->id}") ?? $user->postal_code,
            'address' => session("address_{$product->id}") ?? $user->address,
            'building' => session("building_{$product->id}") ?? $user->building,
        ];

        if ($paymentMethod->code === 'card') {

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

        Order::create($orderData);
        $product->update(['status' => 'sold']);

        return redirect()->route('items.index');
    }


    public function showAddressForm(Product $product)
    {
        $user = Auth::user();
        return view('purchase.address',compact('product','user'));
    }

    public function updateAddress(Request $request, Product $product)
    {
        session([
            "postal_code_{$product->id}" => $request->postal_code,
            "address_{$product->id}" => $request->address,
            "building_{$product->id}" => $request->building,
        ]);

        return redirect()->route('purchase.show',$product->id);
    }

}

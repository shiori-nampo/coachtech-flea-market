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
    public function show($item_id)
    {
        $product = Product::findOrFail($item_id);
        $user = Auth::user();

        $paymentMethodId = session("payment_method_{$product->id}");
        $paymentMethod = $paymentMethodId
        ? PaymentMethod::find($paymentMethodId)
        : null;

        $postalCode = session("postal_code_{$product->id}") ?? $user->postal_code;
        $address = session("address_{$product->id}") ?? $user->address;
        $building = session("building_{$product->id}") ?? $user->building;

        return view('purchase.purchase',compact(
            'product','user','paymentMethod',
            'postalCode','address','building'
    ));
    }

    public function showPayment($item_id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($item_id);
        $paymentMethods = PaymentMethod::all();

        $postalCode = session("postal_code_{$product->id}") ?? $user->postal_code;
        $address = session("address_{$product->id}") ?? $user->address;
        $building = session("building_{$product->id}") ?? $user->building;

        return view('purchase.payment',compact(
            'product',
            'paymentMethods',
            'user',
            'postalCode',
            'address',
            'building'
        ));
    }


    public function updatePayment(Request $request,$item_id)
    {
        $product = Product::findOrFail($item_id);
        $user = auth()->user();

        session([
            "payment_method_{$product->id}" => $request->payment_method_id,
        ]);

        return redirect()->route('purchase.show',$product->id);
    }



    public function store(PurchaseRequest $request,$item_id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($item_id);

        if ($product->order) {
            abort(403,'この商品はすでに購入されています');
        }

        $paymentMethodId = session("payment_method_{$product->id}");
        $paymentMethod = PaymentMethod::findOrFail($paymentMethodId);

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
        'success_url' => route('purchase.success',$product->id),
        'cancel_url' => route('purchase.show',$product->id),
            ]);

            return redirect($session->url);
        }

        Order::create([
            'user_id'=> $user->id,
            'product_id' => $product->id,
            'payment_method_id' => $paymentMethod->id,
            'price' => $product->price,
            'postal_code' => session("postal_code_{$product->id}") ?? $user->postal_code,
            'address' => session("address_{$product->id}") ?? $user->address,
            'building' => session("building_{$product->id}") ?? $user->building,
        ]);

        $product->update(['status' => 'sold']);

        return redirect()->route('items.index');
    }

    // すでに注文が作成されている場合は二重登録防止
    public function success($item_id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($item_id);

        if ($product->order) {
            return redirect()->route('items.index');
        }

        $paymentMethodId = session("payment_method_{$product->id}");
        $paymentMethod = PaymentMethod::findOrFail($paymentMethodId);

        Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'payment_method_id' => $paymentMethod->id,
            'price' => $product->price,
            'postal_code' => session("postal_code_{$product->id}") ?? $user->postal_code,
            'address' => session("address_{$product->id}") ?? $user->address,
            'building' => session("building_{$product->id}") ?? $user->building,
        ]);

        $product->update([
            'status' => 'sold',
        ]);

        return redirect()->route('items.index');
    }


    public function showAddressForm($item_id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($item_id);

        return view('purchase.address',compact('product','user'));
    }

    public function updateAddress(AddressRequest $request, $item_id)
    {
        $product = Product::findOrFail($item_id);
        $user = auth()->user();

        session([
            "postal_code_{$product->id}" => $request->postal_code,
            "address_{$product->id}" => $request->address,
            "building_{$product->id}" => $request->building,
        ]);

        return redirect()->route('purchase.show',$product->id);
    }

}

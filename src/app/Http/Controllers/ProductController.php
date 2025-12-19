<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if($request->tab === 'mylist') {
            $products = auth()->user()->favorites()->with('product')->get()->pluck('product');
        } else {
            $products = Product::where('user_id','!=',auth()->id())
            ->where('status','!=','sold')
            ->get();
        }

        return view('items.index',compact('products'));
    }

    public function show(Product $product)
    {
        return view('items.detail',compact('product'));
    }
}

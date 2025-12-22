<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->tab;
        $keyword = $request->keyword;

        if($tab === 'mylist' && !auth()->check()) {
            return redirect()->route('login');
        }

        if ($tab === 'mylist') {
            $products = auth()->user()->favorites()->with('product')->get()->pluck('product');
            if ($keyword) {
                $products = $products->filter(fn($product) => str_contains($product->name, $keyword));
            }
        } else {
            $query = Product::query()
            ->where('user_id','!=',auth()->id()  ?? 0)
            ->where('status','!=','sold');
            if ($keyword) {
                $query->where('name','like',"%{$keyword}%");
            }
            $products = $query->get();
        }

        return view('items.index',compact('products'));
    }

    public function show($id)
    {
        $product = Product::with('categories','comments.user','user')->findOrFail($id);
        return view('items.detail',compact('product'));
    }
}

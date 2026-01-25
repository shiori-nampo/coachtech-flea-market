<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favorite;
use App\Models\Condition;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->tab ?? 'all';
        $keyword = $request->keyword;

        $query = Product::query();

        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        if ($tab === 'mylist') {
            if (Auth::check()) {
                $query->whereHas('favorites', function($q) {
                    $q->where('user_id',auth()->id());
                });
            } else {
            $query->whereRaw('0 = 1');

            }
        }

        if ($keyword) {
            $query->where('name','like',"%{$keyword}%");
        }

        $products = $query->get();

        return view('items.index',compact('products','tab','keyword'));
    }



    public function show($item_id)
    {
        $product = Product::with('categories','comments.user','user')->findOrFail($item_id);

        $isFavorited = false;

        if (auth()->check()) {
            $isFavorited = $product->favorites()
                ->where('user_id', auth()->id())
                ->exists();
        }

        return view('items.detail',compact('product','isFavorited'));
    }

    public function toggleFavorite($item_id)
    {
        $user = auth()->user();
        $product = Product::findOrFail($item_id);

        $favorite = Favorite::where('user_id',$user->id)
            ->where('product_id',$product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }
        return back();
    }


    public function create()
    {
        $conditions = Condition::all();
        $categories = Category::all();

        return view('items.sell', compact('conditions','categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $user = Auth::user();

        $path = null;
        if ($request->hasFile('image')) {
            $filename = time() . '_' .$request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('products',$filename,'public');
        }


        $product = Product::create([
            'user_id' => $user->id,
            'image' => $path,
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'condition_id' => $request->condition_id,
            'status' => 'selling',
        ]);

        $product->categories()->sync($request->category_ids);

        return redirect()->route('items.index');
    }


}

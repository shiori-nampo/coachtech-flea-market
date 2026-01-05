<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favorite;
use App\Models\Condition;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;
use ILLuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->tab ?? 'all';
        $keyword = $request->keyword;

        if($tab === 'mylist' && !auth()->check()) {
            return redirect()->route('login');
        }

        $query = Product::query();

        if ($tab === 'mylist') {
            $query->whereHas('favorites', function($q) {
                $q->where('user_id',auth()->id());
            });

        } else {
            $query->where('user_id', '!=', auth()->id() ?? 0);
                //->where('status','!=','sold');
        }
            if ($keyword) {
                $query->where('name','like',"%{$keyword}%");
            }

            $products = $query->get();
            return view('items.index',compact('products','tab','keyword'));
        }



    public function show($id)
    {
        $product = Product::with('categories','comments.user','user')->findOrFail($id);
        return view('items.detail',compact('product'));
    }

    public function toggleFavorite(Product $product)
    {
        $user = auth()->user();

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
            $path = $request->file('image')->store('products','public');
        }

        Product::create([
            'user_id' => $user->id,
            'image' => $path ?? null,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'condition_id' => $request->condition_id,
        ]);

        $product->categories()->sync($request->category_ids);

        return redirect()->route('items.index');
    }

}

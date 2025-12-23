<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $product->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $item_id)
    {
        $product = Product::findOrFail($item_id);
        $product->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);
        return back();
    }
}

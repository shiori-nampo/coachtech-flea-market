@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}"/>
@endsection


@section('content')
<div class="detail-content">
  <div class="detail-content__inner">
    <img class="detail-image" src="{{ $product->image }}" alt="{{ $product->name }}">
    <div class="detail-items">
      <h1 class="detail-items__name">{{ $product->name }}</h1>
      <p class="detail-items__brand">{{ $product->brand }}</p>
      <p class="detail-items__price">¥{{ number_format($product->price) }}</p>
    <div class="detail-icons">
      <form action="{{ route('products.toggleFavorite',$product) }}" method="post">
        @csrf
        <button class="icon-box heart" type="submit">
          <img src="{{ $product->favorites->contains('user_id',auth()->id()) ? asset('images/heart_pink.png') : asset('images/heart_logo.png') }}" alt="いいね">
            <span>{{ $product->favorites->count() }}</span>
        </button>
      </form>
      <div class="icon-box comment">
        <img src="{{ asset('images/comment_logo.png') }}" alt="コメント">
          <span>{{ $product->comments->count() }}</span>
      </div>
    </div>
    <a class="purchase__link" href="{{ route('purchase.show',$product ) }}">購入手続きへ</a>
    <h2 class="section-title">商品説明</h2>
    <p class="description-text">{{ $product->description }}</p>
    <h3 class="section-title">商品の情報</h3>
    <div class="product-info">
      <div class="product-info__row">
        <span class="product-info__label">カテゴリー</span>
      <div class="category-list">
        @foreach($product->categories as $category)
        <span class="info-label">{{ $category->name }}</span>
        @endforeach
      </div>
      </div>
      <div class="product-info__row">
        <span class="product-info__label">商品の状態</span>
        <span class="condition-text">{{ $product->condition->name }}</span>
      </div>
    </div>
    <div class="product-info__row">
      <span class="comments-count">コメント({{ $product->comments->count() }})
      </span>
    </div>
    @foreach($product->comments as $comment)
    <div class="comment">
      <div class="comment-user">
        <img class="comment-user__image" src="{{ $comment->user->image ? asset('storage/'.$comment->user->image) : asset('images/no-image.png') }}" alt="{{ $comment->user->name }}">
        <span class="comment-user__name">{{ $comment->user->name }}</span>
      </div>
      <p class="comment-text">{{ $comment->content }}</p>
    </div>
    @endforeach
    <div class="comments">
      <h3 class="comment-title">商品へのコメント</h3>
      <form class="comment-form" action="{{ route('comments.store', $product) }}" method="post">
        @csrf
        <textarea class="comment-input" name="content">{{ old('content') }}</textarea>
          <button class="comment-submit" type="submit">コメントを送信する</button>
      </form>
    </div>
    </div>
  </div>
</div>

@endsection
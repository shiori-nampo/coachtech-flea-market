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
      <div class="icon-box heart">
      <img src="{{ asset('images/heart_logo.png') }}" alt="いいね">
      <span></span>
      </div>
      <div class="icon-box comment">
      <img src="{{ asset('images/comment_logo.png') }}" alt="コメント">
      <span></span>
      </div>
    </div>
      <a class="purchase__link" href="">購入手続きへ</a>
      <h2 class="section-title">商品説明</h2>
      <p class="description-text">{{ $product->description }}</p>
      <h3 class="section-title">商品の情報</h3>
      <div class="product-info">
        <div class="product-info__row">
          <span class="product-info-label">カテゴリー</span>
          <div class="category-list">
            @foreach($product->categories as $category)
            <span class="info-label">{{ $category->name }}</span>
            @endforeach
          </div>
        </div>
        <div class="product-info__row">
          <span class="inf-label">商品の状態</span>
          <span class="condition-text">{{ $product->condition->name }}</span>
        </div>
      </div>
      @foreach($product->comments as $comment)
      <div class="comment">
        <div class="comment-user">
          <img src="{{ $comment->user->profile_image ?? asset('images/default_user.png') }}" alt="{{ $comment->user->name }}">
          <span>{{ $comment->user->name }}</span>
        </div>
        <p class="comment-text">{{ $comment->body }}</p>
      </div>
      @endforeach
      <h3 class="comment-title">商品へのコメント</h3>
      <textarea class="comment-input"></textarea>
      <button class="comment-submit">コメントを送信する</button>
    </div>
  </div>
</div>

@endsection
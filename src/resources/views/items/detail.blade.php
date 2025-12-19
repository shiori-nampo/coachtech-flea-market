@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}"/>
@endsection


@section('content')
<div class="detail-content">
  <div class="detail-content__inner">
    <img class="detail-image" src="" alt="">
    <div class="detail-items">
      <h1 class="detail-items__name">商品名</h1>
      <p class="detail-items__brand">ブランド名</p>
      <p class="detail-items__price">価格</p>
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
      <p class="description-text"></p>
      <h3 class="section-title">商品の情報</h3>
      <div class="product-info">
        <div class="product-info__row">
          <span class="product-info-label">カテゴリー</span>
          <div class="category-list">
            <span class="info-label">ファッション</span>
            <span class="condition-text">良好</span>
          </div>
        </div>
        <div class="product-info__row">
          <span class="inf-label">商品の状態</span>
          <span class="condition-text">良好</span>
        </div>
      </div>
      <h2 class="detail-comment">コメント(1)</h2>
      <div class="comment">
        <div class="comment-user">
          <img src="" alt="">
          <span>ユーザー名</span>
        </div>
        <p class="comment-text">コメント内容</p>
      </div>
      <h3 class="comment-title">商品へのコメント</h3>
      <textarea class="comment-input"></textarea>
      <button class="comment-submit">コメントを送信する</button>
    </div>
  </div>
</div>

@endsection
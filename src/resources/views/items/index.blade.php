@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}"/>
@endsection


@section('content')
<div class="product-content">
  <div class="product-content__tab">
    <a href="/" class=" tab__item {{ request('tab') !== 'mylist' ? 'active' : '' }}">おすすめ</a>
    <a href="/?tab=mylist" class="tab__item mylist {{ request('tab') === 'mylist' ? 'active' : '' }}">マイリスト</a>
  </div>
  <div class="product-content__inner">
    {{--@foreach--}}
    <div class="product-content__group">
      <img src="{{ asset('images/heart.logo.png') }}" class="product-picture" alt="商品画像">
      <p class="product-text"></p>
    </div>
  </div>
</div>
@endsection
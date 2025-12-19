@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}"/>
@endsection


@section('content')
<div class="product-content">
  <div class="product-content__tab">
    <a href="/?tab=recommend" class=" tab__item {{ request('tab') !== 'mylist' ? 'active' : '' }}">おすすめ</a>
    <a href="/?tab=mylist" class="tab__item mylist {{ request('tab') === 'mylist' ? 'active' : '' }}">マイリスト</a>
  </div>
  <div class="product-content__inner">
    @foreach ($products as $product)
    <div class="product-group">
      <a href="{{route('items.detail', $product->id) }}">
      <img class="product-group__image"
          src="{{ $product->image }}" alt="{{ $product->name }}">
      <p class="product-group__name">{{ $product->name }}</p>
      </a>
      @if($product->status === 'sold')
      <span class="sold-badge">SOLD</span>
      @endif
    </div>
    @endforeach
  </div>
</div>
@endsection
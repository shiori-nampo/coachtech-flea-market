@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}"/>
@endsection


@section('content')
<div class="product-content">
  <div class="product-content__tab">
    <a href="{{ route('items.index', ['tab' => 'all', 'keyword' => request('keyword')]) }}" class="tab__item {{ request('tab') != 'mylist' ? 'active' : '' }}">おすすめ</a>
    <a href="{{ route('items.index',['tab' => 'mylist', 'keyword' => request('keyword')]) }}" class= "tab__item {{ request('tab') == 'mylist' ? 'active' : '' }}">マイリスト</a>
  </div>
  <div class="product-content__inner">
    @foreach ($products as $product)
    <div class="product-group">
      <a href="{{ route('items.detail', ['item_id' => $product->id]) }}" class="product-group__link">
        <img class="product-group__image"
          src="{{ $product->image_url }}" alt= "{{ $product->name }}">
        <p class="product-group__name">{{ $product->name }}</p>
        @if($product->status === 'sold')
          <span class="sold-badge">sold</span>
        @endif
      </a>
    </div>
    @endforeach
  </div>
</div>
@endsection
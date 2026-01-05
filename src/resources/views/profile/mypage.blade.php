@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}"/>
@endsection


@section('content')
<div class="mypage-content">
  <div class="mypage-content__header">
    <div class="mypage-content__user">
      <img class="mypage-content__image" src="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : asset('images/no-image.png') }}" alt="">
      <h1 class="mypage-content__name">{{ $user->name }}</h1>
    </div>
    <a class="mypage-content__link" href="{{ route('profile.edit') }}">プロフィールを編集</a>
  </div>
  <div class="mypage-content__tabs">
    <div class="mypage-content__tab">
      <a href="{{ route('mypage',['tab' => 'sell']) }}" class="{{ request('tab','sell') === 'sell' ? 'active' : '' }}">出品した商品</a>
      <a href="{{ route('mypage', ['tab' => 'buy']) }}" class="{{ request('tab') === 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>
  </div>
  <div class="mypage-content__tab-inner">
    @forelse ($products as $product)
    <div class="mypage-content__group">
      <a href="{{route('items.detail', $product->id) }}">
        <img class="mypage-content__group-image"
          src="{{ $product->image }}" alt="{{ $product->name }}">
        <p class="mypage-content__group-name">{{ $product->name }}</p>
      </a>
    </div>
    @empty
    @endforelse
  </div>
</div>
@endsection
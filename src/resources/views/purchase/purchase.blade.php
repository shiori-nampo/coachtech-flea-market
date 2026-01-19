@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection


@section('content')
<form class="purchase-form" action="{{ route('purchase.store', $product->id) }}" method="post">
  @csrf
  <div class="purchase-content">
    <div class="purchase-left">
      <section class="purchase-section purchase-section--product">
        <img class="purchase-product__image" src="{{ $product->image_url }}" alt="{{ $product->name }}">
        <div class="purchase-product__info">
          <h1 class="purchase-product__name">{{ $product->name }}</h1>
          <div class="purchase-product__prices">
            <span class="purchase-product__yen">¥</span>
            <p class="purchase-product__price">{{ number_format($product->price) }}</p>
          </div>
        </div>
      </section>
      <section class="purchase-section purchase-section--payment">
        <h2 class="purchase-title">支払い方法</h2>
      <div class="purchase-payment__select-wrapper">
        <a href="{{ route('purchase.payment',$product->id) }}" class="fake-select">
          {{ $paymentMethod?->name ?? '選択してください' }}
          <span class="fake-select__arrow">▼</span>
        </a>
        @error('payment_method')
          <p class="purchase-form__error">{{ $message }}</p>
        @enderror
      </section>
      <section class="purchase-section  purchase-section--address">
        <div class="purchase-address__header">
          <h2 class="purchase-title">配送先</h2>
          <a class="purchase-address__link" href="{{ route('purchase.address',$product->id) }}">変更する</a>
        </div>

        @php
        $postalCode = session("postal_code_{$product->id}", $user->postal_code);
        $address = session("address_{$product->id}", $user->address);
        $building = session("building_{$product->id}", $user->building);
        @endphp

        <div class="purchase-addresses">
          <span class="purchase-address__post">〒</span>
          <p class="purchase-address__postal-code">{{ preg_replace('/(\d{3})(\d{4})/','$1-$2', $postalCode) }}</p>
        </div>
        <p class="purchase-address__address">{{ $address }} {{ $building ?? '' }}</p>
        @error('address')
        <p class="purchase-form__error">{{ $message }}</p>
        @enderror
      </section>
    </div>
    <div class="purchase-right">
      <div class="purchase-payment__info">
        <table class="payment-info__inner">
          <tr class="payment-info__row">
            <th class="payment-info__header">商品代金</th>
            <td class="payment-info__price">
              <span class="payment-info__yen">¥</span>
              <span class="payment-info__amount">{{ number_format($product->price) }}</span>
            </td>
          </tr>
          <tr class="payment-info__row">
            <th class="payment-info__header">支払い方法</th>
            <td class="payment-info__text" id="payment-method-display">
              {{ $paymentMethod?->name ?? 'コンビニ払い' }}
            </td>
          </tr>
        </table>
        <button class="purchase-btn" type="submit">購入する</button>
      </div>
    </div>
  </div>
</form>
@endsection


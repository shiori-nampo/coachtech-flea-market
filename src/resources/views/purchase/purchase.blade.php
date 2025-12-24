@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection


@section('content')
<form class="purchase-form" action="{{ route('purchase.store',$product) }}" method="post">
  @csrf
  <div class="purchase-content">
    <div class="purchase-left">
      <section class="purchase-section purchase-section--product">
        <img class="purchase-product__image" src="{{ $product->image }}" alt="{{ $product->name }}">
        <div class="purchase-product__info">
          <h1 class="purchase-product__name">{{ $product->name }}</h1>
          <p class="purchase-product__price">¥{{ number_format($product->price) }}</p>
        </div>
      </section>
      <section class="purchase-section purchase-section--payment">
        <h2 class="purchase-title">支払い方法</h2>
      <div class="purchase-payment__select-wrapper">
      <select class="purchase-payment__select" name="payment_method_id">
        <option disabled selected>選択してください</option>
      @foreach($paymentMethods as $method)
        <option value="{{ $method->id }}">{{ $method->name }}</option>
        @endforeach
      </select>
      </div>
      </section>
      <section class="purchase-section  purchase-section--address">
      <div class="purchase-address__header">
        <h2 class="purchase-title">配送先</h2>
        <a class="purchase-address__link" href="#">変更する</a>
      </div>
      <p class="purchase-address__postal-code"></p>
      <p class="purchase-address__address"></p>
      </section>
    </div>
    <div class="purchase-right">
      <div class="purchase-payment__info">
        <table class="payment-info__inner">
          <tr class="payment-info__row">
            <th class="payment-info__header">商品代金</th>
            <td class="payment-info__text">¥</td>
          </tr>
          <tr class="payment-info__row">
            <th class="payment-info__header">支払い方法</th>
            <td class="payment-info__text">{{ old('payment_method_id') ? $paymentMethods->firstWhere('id', old('payment_method_id'))?->name : '未選択' }}            </td>
          </tr>
        </table>
        <button class="purchase-btn" type="submit">購入する</button>
      </div>
    </div>
  </div>
</form>
@endsection
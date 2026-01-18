@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/payment.css') }}"/>
@endsection


@section('content')
<form class="payment-form" action="{{ route('purchase.payment.update',$product->id) }}" method="post">
  @csrf
  @method('PATCH')
  <div class="payment-content">
    <div class="payment-left">
      <section class="payment-section payment-section--product">
        <img class="payment-product__image" src="{{ $product->image }}" alt="{{ $product->name }}">
        <div class="payment-product__info">
          <h1 class="payment-product__name">{{ $product->name }}</h1>
          <div class="payment-product__prices">
            <span class="payment-product__yen">¥</span>
            <p class="payment-product__price">{{ number_format($product->price) }}</p>
          </div>
        </div>
      </section>
      <section class="payment-section payment-section--payment">
        <h2 class="payment-title">支払い方法</h2>
      <div class="payment-select__wrapper">
        <select
        class="payment-payment__select"
        name="payment_method_id"
        id="payment-method-select">
          <option value="" disabled {{ old('payment_method_id') === null ? 'selected' : '' }} hidden>選択してください
          </option>
          @foreach($paymentMethods as $method)
          <option value="{{ $method->id }}"
                {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                {{ $method->name }}
          </option>
          @endforeach
        </select>
        <span class="select-arrow">▼</span>
      </div>
      </section>
      <section class="payment-section  payment-section--address">
        <div class="payment-address__header">
          <h2 class="payment-title">配送先</h2>
          <a class="payment-address__link" href="{{ route('purchase.address',$product->id) }}">変更する</a>
        </div>
        <div class="payment-addresses">
          <span class="payment-address__post">〒</span>
          <p class="payment-address__postal-code">{{ preg_replace('/(\d{3})(\d{4})/','$1-$2', $user->postal_code) }}</p>
        </div>
        <p class="payment-address__address">{{ $user->address }} {{ $user->building ?? '' }}</p>
      </section>
    </div>
    <div class="payment-right">
      <div class="payment-info">
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
            <td class="payment-info__text" id="payment-method-display">コンビニ払い</td>
          </tr>
        </table>
        <button class="payment-btn" type="submit">購入する</button>
      </div>
    </div>
  </div>
</form>
@endsection
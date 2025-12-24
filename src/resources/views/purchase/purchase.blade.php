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
          <div class="purchase-product__prices">
            <span class="purchase-product__yen">¥</span>
            <p class="purchase-product__price">{{ number_format($product->price) }}</p>
          </div>
        </div>
      </section>
      <section class="purchase-section purchase-section--payment">
        <h2 class="purchase-title">支払い方法</h2>
      <div class="purchase-payment__select-wrapper">
        <select class="purchase-payment__select" name="payment_method_id" id="payment-method-select">
          <option disabled selected>選択してください</option>
          @foreach($paymentMethods as $method)
          <option value="{{ $method->id }}" {{ old('payment_method_id', $defaultPaymentMethod?->id) == $method->id ? 'selected' : '' }}>{{ $method->name }}</option>
          @endforeach
        </select>
        @error('payment_method_id')
        {{ $message }}
        @enderror
      </div>
      </section>
      <section class="purchase-section  purchase-section--address">
        <div class="purchase-address__header">
          <h2 class="purchase-title">配送先</h2>
          <a class="purchase-address__link" href="{{ route('purchase.address',$product->id) }}">変更する</a>
        </div>
        <div class="purchase-addresses">
          <span class="purchase-address__post">〒</span>
          <p class="purchase-address__postal-code">{{ preg_replace('/(\d{3})(\d{4})/','$1-$2', $user->postal_code) }}</p>
        </div>
        <p class="purchase-address__address">{{ $user->address }} {{ $user->building ?? '' }}</p>

        @error('address_id')
        {{ $message }}
        @enderror
      </section>
    </div>
    <div class="purchase-right">

    @php
      $selectedMethodId = old('payment_method_id', $defaultPaymentMethod?->id);
      $selectedMethod = $paymentMethods->firstWhere('id',$selectedMethodId);
    @endphp


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
            <td class="payment-info__text" id="payment-method-display">{{ $selectedMethod?->name ?? 'コンビニ払い' }}</td>
          </tr>
        </table>
        <button class="purchase-btn" type="submit">購入する</button>
      </div>
    </div>
  </div>
</form>
@endsection

@section('js')
<script>
  document.addEventListener('DOMContentLoaded',function() {
    const select = document.getElementById('payment-method-select');
    const display = document.getElementById('payment-method-display');

    if (!select || !display) return;

    select.addEventListener('change', function() {
      const selectedText = select.options[select.selectedIndex].text;
      display.textContent = selectedText;
    });
  });
  </script>
  @endsection
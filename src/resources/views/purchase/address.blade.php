@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address-content">
  <h1 class="address-content__header">住所の変更</h1>
  <form class="address-form">
    <div class="address-form__group">
      <label class="address-form__label" for="postal_code">
        郵便番号</label>
        <input class="address-form__input" type="text" name="postal_code" id="postal_cose"/>
    </div>
    <div class="address-form__group">
      <label class="address-form__label" for="address">
        住所</label>
        <input class="address-form__input" type="text" name="address" id="address"/>
    </div>
    <div class="address-form__group">
      <label class="address-form__label" for="building">
        建物名</label>
        <input class="address-form__input" type="text" name="building" id="building"/>
    </div>
    <button class="address-form__btn" type="submit">
      更新する</button>
  </form>
</div>
@endsection
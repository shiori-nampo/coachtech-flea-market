@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address-content">
  <h1 class="address-content__header">住所の変更</h1>
  <form class="address-form" action="{{ route('purchase.address.update',$product->id) }}" method="post">
    @csrf
    <div class="address-form__group">
      <label class="address-form__label" for="postal_code">
        郵便番号</label>
        <input class="address-form__input" type="text" name="postal_code" id="postal_code" value="{{ old('postal_code',$user->postal_code ?? '') }}"/>
        <p class="address-form__error">
        @error('postal_code')
        {{ $message }}
        @enderror
        </p>
    </div>
    <div class="address-form__group">
      <label class="address-form__label" for="address">
        住所</label>
      <input class="address-form__input" type="text" name="address" id="address" value="{{ old('address',$user->address ?? '') }}"/>
        @error('postal_code')
        <p class="address-form__error">{{ $message }}</p>
        @enderror
    </div>
    <div class="address-form__group">
      <label class="address-form__label" for="building">
        建物名</label>
      <input class="address-form__input" type="text" name="building" id="building" value="{{ old('building',$user->building ?? '') }}"/>
    </div>
    <button class="address-form__btn" type="submit">
      更新する</button>
  </form>
</div>
@endsection
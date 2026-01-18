@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}"/>
@endsection


@section('content')
<div class="profile-form">
  <h1 class="profile-form__title">プロフィール設定</h1>
  <div class="profile-form__inner">
    <form class="profile-form__form" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="profile-form__images">
        <img class="profile-form__image" src="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : asset('images/no-image.png') }}" alt="">
        <label class="profile-form__image-btn">画像を選択する
          <input type="file" name="image" hidden>
        </label>
        <p class="edit-form__error">
          @error('image')
          {{ $message }}
          @enderror
        </p>
      </div>
      <div class="profile-form__group">
        <label class="profile-form__label" for="name">ユーザー名</label>
        <input class="profile-form__input" type="text" name="name" id="name" value="{{ old('name', $user->name) }}">
        <p class="edit-form__error">
        @error('name')
        {{ $message }}
        @enderror
        </p>
      </div>
      <div class="profile-form__group">
        <label class="profile-form__label" for="postal_code">郵便番号</label>
        <input class="profile-form__input" type="text" name="postal_code" id="postal_code" value="{{ old('postal_code',$user->postal_code) }}">
        <p class="edit-form__error">
        @error('postal_code')
        {{ $message }}
        @enderror
        </p>
      </div>
      <div class="profile-form__group">
        <label class="profile-form__label" for="address">住所</label>
        <input class="profile-form__input" type="text" name="address" id="address" value="{{ old('address',$user->address) }}">
        <p class="edit-form__error">
        @error('address')
        {{ $message }}
        @enderror
        </p>
      </div>
      <div class="profile-form__group">
        <label class="profile-form__label" for="building">建物名</label>
        <input class="profile-form__input" type="text" name="building" id="building" value="{{ old('building',$user->building) }}">
      </div>
      <button class="profile-form__btn" type="submit">更新する</button>
    </form>
  </div>
</div>
@endsection
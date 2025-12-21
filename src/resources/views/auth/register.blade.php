@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}"/>
@endsection


@section('content')
<div class="register-form">
  <h1 class="register-form__heading">会員登録</h1>
  <div class="register-form__inner">
    <form class="register-form__form" action="/register" method="post">
      @csrf
      <div class="register-form__group">
        <label class="register-form__label" for="name">ユーザー名</label>
        <input class="register-form__input" type="text" name="name" id="name" value="{{ old('name') }}">
        <p class="register-form__error">
        @error('name')
        {{ $message }}
        @enderror
        </p>
      </div>
      <div class="register-form__group">
        <label class="register-form__label" for="email">メールアドレス</label>
        <input class="register-form__input" type="email" name="email" id="email" value="{{ old('email') }}">
        <p class="register-form__error">
        @error('email')
        {{ $message }}
        @enderror
        </p>
      </div>
      <div class="register-form__group">
        <label class="register-form__label" for="password">パスワード</label>
        <input class="register-form__input" type="password" name="password" id="password">
        <p class="register-form__error">
        @error('password')
        {{ $message }}
        @enderror
        </p>
      </div>
      <div class="register-form__group">
        <label class="register-form__label" for="password_confirmation">確認用パスワード</label>
        <input class="register-form__input" type="password" name="password_confirmation" id="password_confirmation">
      </div>
      <button class="register-form__btn" type="submit">登録する</button>
      <a class="register-form__link" href="{{ route('login') }}">ログインはこちら</a>
    </form>
  </div>
</div>
@endsection
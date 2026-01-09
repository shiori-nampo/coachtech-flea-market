@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset ('css/verify.css') }}">
@endsection



@section('content')
<div class="email-content">
  <h1 class="email-title">
    登録していただいたメールアドレスに認証メールを送付しました。<br>メール認証を完了してください。</h1>
    <a class="email-content__link" href="{{ route('verification.notice') }}">認証はこちらから</a>

    @if (session('status') === 'verification-link-sent')
    <p class="email-success">
      認証メールを再送しました。
    </p>
    @endif

    <form class="email-content__form" action="{{ route('verification.send') }}" method="post">
      @csrf
      <button class="email-content__resend" type="submit">認証メールを再送する</button>
    </form>
</div>
@endsection
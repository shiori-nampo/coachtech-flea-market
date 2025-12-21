<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>coachtechフリマ</title>
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
  <link rel="stylesheet" href="{{ asset('css/common.css') }}"/>
  @yield('css')
</head>
<body>
  <div class="app">
    <header class="header">
      <div class="header__inner">
      <a href="{{ route('items.index') }}">
      <img src="{{ asset('images/logo.png') }}"/>
      </a>

      @if (!Route::is('register') && !Route::is('login'))
      @auth
      <form class="search-form">
        <input class="search-form__input" type="text" name="keyword" placeholder="なにをお探しですか？">
      </form>
      <form action="/logout" method="post">
        @csrf
        <button class="logout__link header__nav" type="submit">ログアウト</button>
      </form>
      <a class="mypage__link header__nav" href="">マイページ</a>
      <div class="header-sell">
        <a class="sell__link header__nav" href="">出品</a>
      </div>
      @endauth

      @guest
      <form class="search-form">
        <input class="search-form__input" type="text" name="keyword" placeholder="なにをお探しですか？">
      </form>
        <a class="login__link header__nav" href="{{ route('login') }}">ログイン</a>
        <a class="mypage__link header__nav" href="{{ route('login') }}">マイページ</a>
      <div class="header-sell">
      <a class="sell__link header__nav" href="{{ route('login') }}">出品</a>
      </div>
      @endguest
      @endif
    </div>
    </header>
    @yield('content')
  </div>
</body>
</html>
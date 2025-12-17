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
      <!--<a href="{{ route('items.index') }}">-->
      <img src="{{ asset('images/logo.png') }}"/>
      <!--</a>-->

      @auth
      <form class="search-form">
        <input class="search-form__input" type="text" name="keyword" placeholder="なにをお探しですか？">
      </form>
      <form>
        <button class="logout__link" type="submit">ログアウト</button>
      </form>
      <a class="mypage__link" href="">マイページ</a>
      <div class="header-sell">
        <a class="sell__link" href="">出品</a>
      </div>
      @endauth

      
    </header>
    @yield('content')
  </div>
</body>
</html>
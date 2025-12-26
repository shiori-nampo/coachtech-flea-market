@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}"/>
@endsection


@section('content')
<div class="sell-form">
  <h1 class="sell-form__title">商品の出品</h1>
  <div class="sell-form__inner">
    <form class="sell-form__form">

      <section class="sell-section">
        <h2 class="sell-section__title">商品画像</h2>
        <label class="sell-image__box">
          <span class="sell-image__btn">画像を選択する</span>
        <input type="file" name="image" hidden>
        </label>
      </section>
      <section class="sell-section">
        <h2 class="sell-section__header">商品の詳細</h2>

        <div class="sell-field">
          <p class="sell-field__label">カテゴリー</p>
          <div class="sell-category">
            <button type="submit" class="sell-category__item">ファッション</button>
            <button type="submit" class="sell-category__item">家電</button>
            <button type="submit" class="sell-category__item">インテリア</button>
            <button type="submit" class="sell-category__item">レディース</button>
            <button type="submit" class="sell-category__item">メンズ</button>
            <button type="submit" class="sell-category__item">コスメ</button>
            <button type="submit" class="sell-category__item">本</button>
            <button type="submit" class="sell-category__item">ゲーム</button>
            <button type="submit" class="sell-category__item">スポーツ</button>
            <button type="submit" class="sell-category__item">キッチン</button>
            <button type="submit" class="sell-category__item">ハンドメイド</button>
            <button type="submit" class="sell-category__item">アクセサリー</button>
            <button type="submit" class="sell-category__item">おもちゃ</button>
            <button type="submit" class="sell-category__item">ベビー・キッズ</button>
          </div>
      </div>
      <div class="sell-field">
        <label class="sell-field__label">商品の状態</label>
        <select class="sell-field__select">
          <option disabled selected>選択してください</option>
        </select>
      </div>
      </section>

      <section class="sell-section">
        <h2 class="sell-section__header">商品名と説明</h2>
        <div class="sell-field">
          <label class="sell-field__label" for="name">商品名</label>
          <input class="sell-field__input" type="text" id="name">
        </div>
        <div class="sell-field">
          <label class="sell-field__label" for="brand_name">ブランド名</label>
          <input class="sell-field__input" type="text" id="brand_name">
        </div>
        <div class="sell-field">
          <label class="sell-field__label">商品の説明</label>
          <textarea class="sell-field__input"></textarea>
        </div>
      </section>
      <section class="sell-field">
        <label class="sell-field__label" for="price">販売価格</label>
        <div class="sell_price">
          <span class="sell-price__yen">¥</span>
          <input class="sell-field__input" type="text" id="price" >
        </div>
      </section>

      <button class="sell-form__submit" type="submit">出品する</button>
    </form>
  </div>
</div>

@endsection
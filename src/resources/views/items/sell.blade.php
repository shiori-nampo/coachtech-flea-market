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
        <input type="file" name="image" accept=".jpg,.jpeg,.png" hidden>
        </label>
        @error('image')
        <p class="error">{{ $message }}</p>
        @enderror
      </section>
      <section class="sell-section">
        <h2 class="sell-section__header">商品の詳細</h2>

        <div class="sell-field">
          <p class="sell-field__label">カテゴリー</p>
          <div class="sell-category">
            @foreach($categories as $category)
            <label class="sell-category__item">
              <input type="checkbox" name="category_ids[]" value="{{ $category->id }}"
              {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }}>
              <span>{{ $category->name }}</span>
            </label>
            @endforeach
          </div>
          @error('category_ids')
        <p class="error">{{ $message }}</p>
        @enderror
      </div>
      <div class="sell-field">
        <label class="sell-field__label">商品の状態</label>
        <div class="sell-select__wrapper">
          <select class="sell-field__select" name="condition_id">
            <option value="" hidden disabled selected>選択してください</option>

            @foreach($conditions as $condition)
              <option value="{{ $condition->id }}"
                {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                {{ $condition->name }}
              </option>
            @endforeach
          </select>

          <span class="select-arrow">▼</span>
        </div>

        @error('condition_id')
        <p class="error">{{ $message }}</p>
        @enderror
      </div>
      </section>

      <section class="sell-section">
        <h2 class="sell-section__header">商品名と説明</h2>
        <div class="sell-field">
          <label class="sell-field__label" for="name">商品名</label>
          <input class="sell-field__input" type="text" id="name" value="{{ old('name') }}">
          @error('name')
        <p class="error">{{ $message }}</p>
        @enderror
        </div>
        <div class="sell-field">
          <label class="sell-field__label" for="brand_name">ブランド名</label>
          <input class="sell-field__input" type="text" id="brand_name">
        </div>
        <div class="sell-field">
          <label class="sell-field__label">商品の説明</label>
          <textarea class="sell-field__input" name="description" maxlength="255">{{ old('description') }}</textarea>
          @error('description')
        <p class="error">{{ $message }}</p>
        @enderror
        </div>
      </section>
      <section class="sell-field">
        <label class="sell-field__label" for="price">販売価格</label>
        <div class="sell_price">
          <span class="sell-price__yen">¥</span>
          <input class="sell-field__input" type="number" id="price" name="price" value="{{ old('price') }}">
          @error('price')
        <p class="error">{{ $message }}</p>
        @enderror
        </div>
      </section>

      <button class="sell-form__submit" type="submit">出品する</button>
    </form>
  </div>
</div>

@endsection
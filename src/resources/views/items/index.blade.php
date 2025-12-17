@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}"/>
@endsection


@section('content')
<div class="product-content">
  <div class="product-content__tab">
    <!--<a href="/" class="{{ request('tab') !== 'mylist' ? 'active' : '' }}">おすすめ</a>
    <a href="/?tab=mylist" class="{{ request('tab') === 'mylist' ? 'active' : '' }}">マイリスト</a>-->
  </div>
</div>
@endsection
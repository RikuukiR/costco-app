{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'HOME')

@section('content')
<h2>ダッシュボード</h2>
<p>こちらはCOSTCO業務効率化アプリのホーム画面です。</p>

{{-- <ul>
    <li><a href="{{ route('products.index') }}">商品管理</a></li>
    <li><a href="{{ route('ingredients.index') }}">在庫管理</a></li>
    <li><a href="{{ route('sales.index') }}">売上管理</a></li>
    <li><a href="{{ route('sales_forecasts.index') }}">売上予測</a></li>
    <li><a href="{{ route('schedules.index') }}">製造予定</a></li>
    <li><a href="{{ route('weights.index') }}">重量管理</a></li>
    <li><a href="{{ route('volumes.index') }}">発注管理</a></li>
    <li><a href="{{ route('destroys.index') }}">廃棄管理</a></li>
</ul> --}}
@endsection
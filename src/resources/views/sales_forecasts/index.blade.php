@extends('layouts.app')

@section('title', 'SALES FORECASTS')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sales_forecasts/index.css') }}">
@endsection

@section('content')

<div class="p-6">

    {{-- タブ切替 --}}
    <div class="tab-container">
        @foreach (['day' => 'DAY', 'week' => 'WEEK', 'year' => 'YEAR'] as $key => $label)
        <a href="{{ route('sales_forecasts.index', ['mode' => $key] + request()->except('page')) }}"
            class="tab-button {{ request('mode', 'week') === $key ? 'active' : '' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- 検索フォーム --}}

    {{-- グラフ表示 --}}
    <canvas id="salesChart" class="w-full h-64 mb-6"></canvas>

    {{-- コメントセクション --}}
    <div class="chatgpt-box">
        <div class="chatgpt-title">ChatGPT</div>
        <p class="chatgpt-message">{{ $comment }}</p>
    </div>
</div>




@endsection
@extends('layouts.app')

@section('title', 'SPEC')

@section('css')
<link rel="stylesheet" href="{{ asset('css/specs/index.css') }}">
@endsection

@section('content')
<div class="spec-container">
    
    <!-- 検索機能 -->
    <div class="search-section">
        <form action="{{ route('specs.index') }}" method="GET">
            <input type="text" name="keyword" class="search-input" 
                   placeholder="製造番号または商品名で検索..." 
                   value="{{ request('keyword') }}">
            <button type="submit" class="search-button">
                検索
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- 商品カード一覧 -->
    <div class="spec-grid">
        @forelse ($products as $product)
            <a href="{{ route('specs.show', $product) }}" class="spec-card">
                <div class="spec-card-image">
                    @if($product->image_path)
                        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}">
                    @else
                        <div class="no-image">画像なし</div>
                    @endif
                </div>
                <div class="spec-card-content">
                    <div class="spec-card-code">{{ $product->spec_code }}</div>
                    <div class="spec-card-name">{{ $product->name }}</div>
                    @if($product->category)
                        <div class="spec-card-category">{{ $product->category }}</div>
                    @endif
                </div>
            </a>
        @empty
            <div class="no-recipes">
                登録されているレシピがありません。
            </div>
        @endforelse
    </div>
</div>
@endsection

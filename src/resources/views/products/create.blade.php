@extends('layouts.app')

@section('title', 'レシピ(SPEC)新規登録')

@section('content')
<div class="container">
    <h1>レシピ(SPEC)新規登録</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="spec_code" class="form-label">製造番号</label>
            <input type="text" class="form-control" id="spec_code" name="spec_code" value="{{ old('spec_code') }}" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">商品名</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">カテゴリ</label>
            <input type="text" class="form-control" id="category" name="category" value="{{ old('category') }}">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">価格 (100gあたり)</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}">
        </div>
        <div class="mb-3">
            <label for="target_weight" class="form-label">目標重量 (g)</label>
            <input type="number" step="0.01" class="form-control" id="target_weight" name="target_weight" value="{{ old('target_weight') }}" required>
        </div>
        <div class="mb-3">
            <label for="image_path" class="form-label">商品画像パス</label>
            <input type="text" class="form-control" id="image_path" name="image_path" value="{{ old('image_path') }}">
        </div>
        
        <button type="submit" class="btn btn-primary">登録</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection

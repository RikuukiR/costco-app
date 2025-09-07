@extends('layouts.app')

@section('title', 'レシピ(SPEC)詳細')

@section('content')
<div class="container">
    <h1>{{ $product->name }} の詳細</h1>

    <div class="card">
        <div class="card-header">
            製造番号: {{ $product->spec_code }}
        </div>
        <div class="card-body">
            <p><strong>商品名:</strong> {{ $product->name }}</p>
            <p><strong>カテゴリ:</strong> {{ $product->category }}</p>
            <p><strong>価格 (100gあたり):</strong> {{ $product->price }}円</p>
            <p><strong>目標重量:</strong> {{ $product->target_weight }}g</p>
            <p><strong>画像パス:</strong> {{ $product->image_path }}</p>
            
            <hr>
            
            <h3>使用食材</h3>
            @if($product->specIngredients->count() > 0)
                <ul>
                    @foreach($product->specIngredients as $specIngredient)
                        <li>{{ $specIngredient->ingredient->name ?? 'N/A' }}: {{ $specIngredient->quantity_per_unit }} {{ $specIngredient->unit }}</li>
                    @endforeach
                </ul>
            @else
                <p>登録されている使用食材はありません。</p>
            @endif

            <hr>

            <h3>調理手順</h3>
            @if($product->recipeSteps->count() > 0)
                <ol>
                    @foreach($product->recipeSteps as $step)
                        <li>{{ $step->step_description }}</li>
                    @endforeach
                </ol>
            @else
                <p>登録されている調理手順はありません。</p>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">編集</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">一覧へ戻る</a>
        </div>
    </div>
</div>
@endsection

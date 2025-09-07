@extends('layouts.app')

@section('title', 'SPEC DETAIL')

@section('css')
<link rel="stylesheet" href="{{ asset('css/specs/show.css') }}">
@endsection

@section('content')
<div class="spec-container">
    <!-- ヘッダー情報 -->
    <div class="spec-header">
        <div class="spec-code">製造番号: {{ $product->spec_code }}</div>
        <h1 class="spec-name">{{ $product->name }}</h1>
        <div class="spec-info">
            @if($product->target_weight)
                <div class="spec-info-item">
                    <div class="spec-info-label">目標重量</div>
                    <div class="spec-info-value">{{ $product->target_weight }}g</div>
                </div>
            @endif
            @if($product->price)
                <div class="spec-info-item">
                    <div class="spec-info-label">価格(100gあたり)</div>
                    <div class="spec-info-value">{{ $product->price }}円</div>
                </div>
            @endif
            @if($product->category)
                <div class="spec-info-item">
                    <div class="spec-info-label">カテゴリ</div>
                    <div class="spec-info-value">{{ $product->category }}</div>
                </div>
            @endif
        </div>
    </div>

    <!-- 商品画像 -->
    @if($product->image_path || !$product->image_path)
        <div class="product-image">
            @if($product->image_path)
                <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}">
            @else
                <div class="no-image-placeholder">画像未登録</div>
            @endif
        </div>
    @endif

    <!-- 使用食材と調理手順 -->
    <div class="content-grid">
        <!-- 使用食材 -->
        <div class="content-section">
            <div class="section-header">
                <i class="fas fa-list-ul"></i> 使用食材
            </div>
            <div class="section-content">
                @if($product->specIngredients->count() > 0)
                    @foreach($product->specIngredients as $specIngredient)
                        <div class="ingredient-item">
                            <span class="ingredient-name">
                                {{ $specIngredient->ingredient->name ?? 'N/A' }}
                            </span>
                            <span class="ingredient-amount">
                                {{ $specIngredient->quantity_per_unit }} {{ $specIngredient->unit }}
                            </span>
                        </div>
                    @endforeach
                @else
                    <div class="no-data">使用食材が登録されていません</div>
                @endif
            </div>
        </div>

        <!-- 調理手順 -->
        <div class="content-section">
            <div class="section-header">
                <i class="fas fa-tasks"></i> 調理手順
            </div>
            <div class="section-content">
                @if($product->recipeSteps->count() > 0)
                    @foreach($product->recipeSteps->sortBy('step_order') as $step)
                        <div class="recipe-step">
                            <span class="step-number">{{ $step->step_order }}</span>
                            <span class="step-description">{{ $step->step_description }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="no-data">調理手順が登録されていません</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

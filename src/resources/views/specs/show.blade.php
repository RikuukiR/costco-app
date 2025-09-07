@extends('layouts.app')

@section('title', 'SPEC DETAIL')

@section('css')
<link rel="stylesheet" href="{{ asset('css/specs/show.css') }}">
@endsection

@section('content')
<div class="spec-container">
    <!-- メインコンテンツ（2カラムレイアウト） -->
    <div class="spec-body-grid">
        <!-- 左カラム -->
        <div class="left-column">
            <!-- 商品情報ヘッダー -->
            <div class="product-info-header">
                <div class="product-title-row">
                    <h1 class="product-name">{{ $product->name }}</h1>
                </div>
                <div class="product-details">
                    @if($product->spec_code)
                        <div class="product-detail-item">
                            <span class="product-detail-label">製造番号</span>
                            <span class="product-detail-value">{{ $product->spec_code ?? 'N/A' }}</span>
                        </div>
                    @endif
                    @if($product->target_weight)
                        <div class="product-detail-item">
                            <div class="product-detail-label">目標重量</div>
                            <div class="product-detail-value">{{ $product->target_weight }}g</div>
                        </div>
                    @endif
                    @if($product->price)
                        <div class="product-detail-item">
                            <div class="product-detail-label">価格(100gあたり)</div>
                            <div class="product-detail-value">{{ $product->price }}円</div>
                        </div>
                    @endif
                    @if($product->category)
                        <div class="product-detail-item">
                            <div class="product-detail-label">カテゴリ</div>
                            <div class="product-detail-value">{{ $product->category }}</div>
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
        </div>

        <!-- 右カラム -->
        <div class="right-column">
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
</div>
@endsection

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SpecController extends Controller
{
    /**
     * スタッフ向けレシピ一覧（カード形式）
     */
    public function index()
    {
        $products = Product::all();
        return view('specs.index', compact('products'));
    }

    /**
     * レシピ詳細（調理手順・使用食材中心）
     */
    public function show(Product $product)
    {
        $product->load('recipeSteps', 'specIngredients.ingredient');
        return view('specs.show', compact('product'));
    }

    // スタッフ向けなので新規作成・編集・削除機能は無効化
    // 必要に応じて将来的に限定的な編集機能を追加可能
}

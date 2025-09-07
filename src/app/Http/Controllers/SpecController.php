<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Product;

class SpecController extends Controller
{
    /**
     * スタッフ向けレシピ一覧（カード形式）
     */
    public function index()
    {
        // 集計用商品（000000）を除外
        $products = Product::where('spec_code', '!=', '00000')->get();
        return view('specs.index', compact('products'));
    }

    /**
     * レシピ詳細（調理手順・使用食材中心）
     */
    public function show($spec_code)
    {
        // 手動で商品を取得（Route Model Bindingを使わない）
        $product = Product::where('spec_code', $spec_code)->first();
        
        if (!$product) {
            abort(404, '商品が見つかりません');
        }
        
        $product->load('recipeSteps', 'specIngredients.ingredient');
        return view('specs.show', compact('product'));
    }

    // スタッフ向けなので新規作成・編集・削除機能は無効化
    // 必要に応じて将来的に限定的な編集機能を追加可能
}

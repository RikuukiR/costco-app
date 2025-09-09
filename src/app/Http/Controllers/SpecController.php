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

    // ここから管理者向けのメソッドを追加
    public function create()
    {
        //
    }

    public function store()
    {
        //
    }

    public function edit()
    {
        //
    }

    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }
}

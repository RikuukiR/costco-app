<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // 一覧表示
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // 新規作成フォーム表示
    public function create()
    {
        return view('products.create');
    }

    // 新規登録処理
    public function store(Request $request)
    {
        $validated = $request->validate([
            'spec_code' => 'required|string|unique:products,spec_code|max:10',
            'name' => 'required|string|max:100',
            'image_path' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'target_weight' => 'required|numeric',
            'category' => 'nullable|string|max:50',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    // 詳細表示
    public function show(Product $product)
    {
        $product->load('recipeSteps', 'specIngredients.ingredient');
        return view('products.show', compact('product'));
    }

    // 編集フォーム表示
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // 更新処理
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'image_path' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'target_weight' => 'required|numeric',
            'category' => 'nullable|string|max:50',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', '商品情報を更新しました');
    }

    // 削除処理
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }
}

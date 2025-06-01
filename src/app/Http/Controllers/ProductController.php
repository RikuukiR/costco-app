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
        // バリデーションは後で追加
        $product = new Product();
        $product->spec_code = $request->spec_code;
        $product->name = $request->name;
        $product->image_path = $request->image_path;
        $product->price = $request->price;
        $product->target_weight = $request->target_weight;
        $product->category = $request->category;
        $product->save();

        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    // 詳細表示
    public function show($spec_code)
    {
        $product = Product::findOrFail($spec_code);
        return view('products.show', compact('product'));
    }

    // 編集フォーム表示
    public function edit($spec_code)
    {
        $product = Product::findOrFail($spec_code);
        return view('products.edit', compact('product'));
    }

    // 更新処理
    public function update(Request $request, $spec_code)
    {
        $product = Product::findOrFail($spec_code);
        $product->name = $request->name;
        $product->image_path = $request->image_path;
        $product->price = $request->price;
        $product->target_weight = $request->target_weight;
        $product->category = $request->category;
        $product->save();

        return redirect()->route('products.index')->with('success', '商品情報を更新しました');
    }

    // 削除処理
    public function destroy($spec_code)
    {
        $product = Product::findOrFail($spec_code);
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }
}

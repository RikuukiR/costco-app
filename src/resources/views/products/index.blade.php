@extends('layouts.app')

@section('content')
<h1>商品一覧</h1>

<a href="{{ route('products.create') }}">新規登録</a>

<table border="1">
    <tr>
        <th>製造番号</th>
        <th>商品名</th>
        <th>価格</th>
        <th>目標重量</th>
        <th>カテゴリー</th>
        <th>操作</th>
    </tr>
    @foreach ($products as $product)
    <tr>
        <td>{{ $product->spec_code }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->price }}円</td>
        <td>{{ $product->target_weight }}g</td>
        <td>{{ $product->category }}</td>
        <td>
            <a href="{{ route('products.edit', $product->spec_code) }}">編集</a>
            <form action="{{ route('products.destroy', $product->spec_code) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">削除</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
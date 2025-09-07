@extends('layouts.app')

@section('title', 'レシピ(SPEC)管理')

@section('content')
<div class="container">
    <h1>レシピ(SPEC)一覧</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">新規登録</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>製造番号</th>
                <th>商品名</th>
                <th>カテゴリ</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->spec_code }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category }}</td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm">詳細</a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">編集</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？')">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>商品一覧</title>
</head>

<body>
    <h1>商品一覧</h1>

    <a href="{{ route('products.create') }}">新規商品登録</a>

    <table border="1">
        <thead>
            <tr>
                <th>製造番号</th>
                <th>商品名</th>
                <th>価格</th>
                <th>目標重量</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->spec_code }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->target_weight }}</td>
                <td>
                    <a href="{{ route('products.show', $product->spec_code) }}">詳細</a>
                    <a href="{{ route('products.edit', $product->spec_code) }}">編集</a>
                    <form action="{{ route('products.destroy', $product->spec_code) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
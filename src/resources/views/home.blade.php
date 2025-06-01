<!-- resources/views/home.blade.php -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>トップページ</title>
</head>

<body>
    <h1>COSTCO 業務効率化アプリ</h1>
    <p>ようこそ！ダッシュボードへ</p>

    <nav>
        <ul>
            <li><a href="{{ route('products.index') }}">商品一覧へ</a></li>
            <li><a href="#">レシピ管理へ</a></li>
            <li><a href="#">VOLUME管理へ</a></li>
            <li><a href="#">在庫管理へ</a></li>
        </ul>
    </nav>
</body>

</html>
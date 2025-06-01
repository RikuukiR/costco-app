<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', '業務効率化アプリ')</title>
</head>

<body>
    <header>
        <h1>業務効率化アプリ</h1>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">ホーム</a></li>
                <li><a href="{{ route('products.index') }}">商品一覧</a></li>
            </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2025 Costco DEILチーム</p>
    </footer>
</body>

</html>
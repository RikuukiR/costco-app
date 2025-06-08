<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COSTCO業務効率化アプリケーション</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__logo">
            <img src="{{ asset('images/logo.png') }}" alt="ロゴ" class="header__logo-img">
        </div>

        <h1 class="header__title">
            @yield('title')
        </h1>

        <div class="header__right">
            <div class="header__search">
                <form action="{{ url()->current() }}" method="GET">
                    <input type="text" name="keyword" placeholder="商品名で検索">
                    <button type="submit">検索</button>
                </form>
            </div>

            <div class="header__logout">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <p>© 2025 COSTCO業務効率化アプリケーション</p>
    </footer>
</body>

</html>
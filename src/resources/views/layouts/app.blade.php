<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COSTCO業務効率化アプリケーション</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="ロゴ" class="header__logo-img">
            </a>
        </div>

        <h1 class="header__title">
            @yield('title')
        </h1>

        <div class="header__right">
            @if (!Route::is('login') && !Route::is('home'))
            <div class="header__search">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="keyword" placeholder="spec-code">
                    </div>
                    <button type="submit">search</button>
                </form>
            </div>
            @endif

            @if (!Route::is('login'))
            <div class="header__logout">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <img src="{{ asset('images/logout.png') }}" alt="" class="header__logout-logo">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            @endif
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
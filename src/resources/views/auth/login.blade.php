<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>

<body>
    <h1>ログイン</h1>

    @if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
        <p style="color:red;">{{ $error }}</p>
        @endforeach
    </div>
    @endif
    
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="login_id">ログインID:</label>
            <input type="text" name="login_id" id="login_id" value="{{ old('login_id') }}" required autofocus>
        </div>

        <div>
            <label for="password">パスワード:</label>
            <input type="password" name="password" id="password" required>
        </div>

        <button type="submit">ログイン</button>
    </form>
</body>

</html>
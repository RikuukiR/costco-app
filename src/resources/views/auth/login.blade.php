{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('title', 'Login')

@section('content')

@if(session('status'))
<div class="alert">{{ session('status') }}</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="login-container">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="login_id">Login ID :</label>
            <input type="text" name="login_id" id="login_id" value="{{ old('login_id') }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password :</label>
            <input type="password" name="password" id="password" required>
        </div>

        <button type="submit" class="login-button">Login</button>
    </form>
</div>
@endsection
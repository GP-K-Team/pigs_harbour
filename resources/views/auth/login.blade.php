@extends('layouts.main', ['background' => 'texture-light'])

@push('additionalHeader')
    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/form.css') }}">
@endpush

@section('title')
    Вход
@endsection

@section('content')
<div class="login-form-wrapper">
    <form class="login-form" action="{{ route('auth.login') }}" method="POST">
        <div class="input-container">
            <input type="text" name="login" id="login" placeholder="Логин" value="{{ old('login', '') }}" autocomplete="username">
            <x-error-bag name="login"/>
        </div>

        <div class="input-container">
            <input type="password" name="password" id="password" placeholder="Пароль" autocomplete="current-password">
            <x-error-bag name="password"/>
        </div>

        <div class="form-button">
            <button class="button" type="submit">Войти</button>
        </div>

        @csrf
    </form>
</div>
@endsection

<style>
    .login-form-wrapper {
        width: 50vw;
        max-width: 350px;
        margin: auto;
    }

    .login-form {
        display: flex;
        flex-direction: column;
        row-gap: 25px;
    }

    @media (max-width: 768px) {
        .login-form-wrapper {
            width: 80vw;
        }
    }
</style>

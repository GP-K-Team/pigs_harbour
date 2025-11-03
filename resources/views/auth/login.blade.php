@extends('layouts.main', ['background' => 'texture-light'])

@push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/form.css') }}">
@endpush

@section('content')
<div class="login_form_wrapper">
    <form class="login_form" action="{{ route('auth.login') }}" method="POST">
        <div class="input-container">
            <input type="text" name="login" id="login" placeholder="Логин" value="{{ old('login', '') }}">
            <x-error-bag name="login"/>
        </div>

        <div class="input-container">
            <input type="password" name="password" id="password" placeholder="Пароль">
            <x-error-bag name="password"/>
        </div>

        <div class="form-button">
            <button type="submit">Войти</button>
        </div>

        @csrf
    </form>
</div>
@endsection

<style>
    .login_form_wrapper {
        width: 50vw;
        max-width: 350px;
        margin: auto;
    }

    .login_form {
        display: flex;
        flex-direction: column;
        row-gap: 25px;
    }

    @media (max-width: 768px) {
        .login_form_wrapper {
            width: 80vw;
        }
    }
</style>

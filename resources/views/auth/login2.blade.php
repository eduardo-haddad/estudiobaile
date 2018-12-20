@extends('layouts.app')

@section('login')

<!-- Styles -->

<div class="container login" id="login">
    <div class="login-page">
        <div class="form">
            <form class="register-form" method="POST" action="{{ route('login') }}">
                <input type="text" placeholder="name"/>
                <input type="password" placeholder="password"/>
                <input type="text" placeholder="email address"/>
                <button>create</button>
                <p class="message">Already registered? <a href="#">Sign In</a></p>
            </form>
            <form class="login-form">
                <input type="text" class="{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="usuário" name="username" value="{{ old('username') }}" required autofocus/>
                @if ($errors->has('username'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
                <input type="password" placeholder="senha" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required />
                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <button type="submit">Entrar</button>
            </form>
        </div>
    </div>
</div>
@endsection

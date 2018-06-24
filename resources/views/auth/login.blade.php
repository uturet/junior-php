@extends('layouts.app')

@section('form')
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth login-full-bg">
            <div class="row w-100">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-dark text-left p-5">
                        <h2>Авторизация</h2>
                        <h4 class="font-weight-light">Давайте начнем!</h4>
                        {!! Form::open(['url' => route('login'), 'method' => 'POST']) !!}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">Email</label>
                            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" value="{{ old('email') }}">
                            <i class="mdi mdi-account"></i>

                            @if ($errors->has('email'))
                                <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Пароль</label>
                            <input name="password" type="password" class="form-control" id="password">
                            <i class="mdi mdi-eye"></i>

                            @if ($errors->has('password'))
                                <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                            @endif
                        </div>
                        <div class="mt-5">
                            <button type="submit" class="btn btn-block btn-warning btn-lg font-weight-medium">Войти</button>
                        </div>
                        <div class="mt-3 text-center">
                            <a href="{{ route('password.request') }}" class="auth-link text-white">Восстановление пароля</a>
                        </div>
                        <div class="mt-3 text-center">
                            <a href="{{ route('register') }}" class="auth-link text-white">Регистрация</a>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
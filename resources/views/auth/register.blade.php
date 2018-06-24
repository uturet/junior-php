@extends('layouts.app')

@section('form')
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth register-full-bg">
            <div class="row w-100">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <h2>Регистрация</h2>
                        <h4 class="font-weight-light">Приступим!</h4>
                        {!! Form::open(['url' => route('register'), 'method' => 'POST']) !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Имя пользователя</label>
                            <input name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp" value="{{ old('name') }}">
                            <i class="mdi mdi-account"></i>

                            @if ($errors->has('name'))
                                <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                            @endif
                        </div>
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
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password-confirm">Подтвердите пароль</label>
                            <input name="password_confirmation" type="password" class="form-control" id="password-confirm">
                            <i class="mdi mdi-eye"></i>
                        </div>
                        <div class="mt-5">
                            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium">Зарегистрироваться</button>
                        </div>
                        <div class="mt-2 text-center">
                            <a href="{{ route('login') }}" class="auth-link text-black">Уже есть аккаунт? <span class="font-weight-medium">Авторизация</span></a>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
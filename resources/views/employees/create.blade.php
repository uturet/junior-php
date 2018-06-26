@extends('layouts.admin_app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">

                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            @include('layouts.errors')

                            <h4 class="card-title">Создать сотрудника</h4>
                            {!! Form::open([
                            'url' => route('employees.store'), 'method' => 'POST', 'files' => true
                            ]) !!}
                            <div class="row">
                                <div class="col-sm-9">

                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Фамилия:</label>
                                        <div class="col">
                                            <input type="text" name="last_name" class="form-control" placeholder="Фамилия" value="{{ old('last_name')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row py-3">
                                        <label class="col-3 col-form-label">Имя:</label>
                                        <div class="col">
                                            <input type="text" name="name" class="form-control" placeholder="Имя" value="{{ old('name')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row py-3">
                                        <label class="col-3 col-form-label">Отчество:</label>
                                        <div class="col">
                                            <input type="text" name="patronymic" class="form-control" placeholder="Отчество" value="{{ old('patronymic')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-between py-3">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label class="col-4 col-form-label">Дата Рождения:</label>
                                                <div class="col">
                                                    <input type="date" name="burn_date" class="form-control" value="{{ old('burn_date')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            <div class="row">
                                                <label class="col-4 col-form-label">Пол:</label>
                                                <div class="col input-group">
                                                    <select name="gender" class="form-control" id="gender" value="{{ old('gender')}}">
                                                        <option value="1">Мужской</option>
                                                        <option value="0">Женский</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-between py-3">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label class="col-4 col-form-label">Email:</label>
                                                <div class="col">
                                                    <input type="email" name="email" class="form-control" value="{{ old('email')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            <div class="row">
                                                <label class="col-4 col-form-label">Телефон:</label>
                                                <div class="col input-group">
                                                    <input type="text" name="phone" class="form-control" value="{{ old('phone')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row py-3">
                                        <label class="col-4 col-form-label">Фотография:</label>
                                        <div class="form-group">
                                            <input type="file" name="avatar" class="btn-sm btn-light form-control-file" id="photo" value="{{ old('avatar')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-around">
                                        <div class="col-3">
                                            <button class="btn btn-primary btn-block" type="submit">Записать</button>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

            </div>

            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->
            <footer class="footer">
                <div class="container-fluid clearfix">
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018 <a href="http://www.bootstrapdash.com/" target="_blank">Bootstrapdash</a>. All rights reserved.</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
@endsection
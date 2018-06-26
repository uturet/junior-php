@extends('layouts.admin_app')

@section('content')

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">

                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Редактировать должность</h4>
                            {!! Form::open(['url' => route('positions.store')], ['method' => 'PUT']) !!}
                            <div class="row">
                                <div class="col-sm-9">

                                    <div class="form-group row py-3">
                                        <label class="col-3 col-form-label">Название:</label>
                                        <div class="col">
                                            <input name="name" type="text" class="form-control" placeholder="Название должности" value="{{ $position->name }}">
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-between py-3">
                                        <label class="col-3 col-form-label">Описание должности:</label>
                                        <div class="col">
                                            <textarea type="text" name="description" class="form-control">{{ $position->description }}</textarea>
                                        </div>

                                    </div>

                                    <div class="form-group row justify-content-around">
                                        <div class="col-5">
                                            <button class="btn btn-primary btn-block" type="submit">Обновить</button>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
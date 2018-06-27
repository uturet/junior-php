@extends('layouts.admin_app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">

                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $employee->full_name }}
                                <a href="{{ route('employees.edit', ['id' => $employee->id]) }}" class={'btn-lg'}
                                    title="Редактировать личные данные сотрудника">
                                <i class="fa fa-pencil d-inline"></i>
                                </a>
                            </h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Номер телефона:</label>
                                        <div class="col">
                                            <label class="col col-form-label">{{ $employee->phone }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Email:</label>
                                        <div class="col">
                                            <label class="col col-form-label">{{ $employee->email }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Дата Рождения:</label>
                                        <div class="col">
                                            <label class="col col-form-label">{{ $employee->burn_date }}</label>
                                        </div>
                                    </div>

                                    @if($employee->mediator)

                                        @if($employee->mediator->is_archive)
                                            <div class="row">
                                                <div class="col text-muted">
                                        @endif

                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Начальник:</label>
                                            <div class="col">
                                                <label class="col col-form-label">{{ $employee->mediator->headEmployeeFullName() }}</label>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Должность:</label>
                                            <div class="col">
                                                <label class="col col-form-label">{{ $employee->mediator->positionName() }}</label>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Подразделение:</label>
                                            <div class="col">
                                                <label class="col col-form-label">{{ $employee->mediator->departmentName() }}</label>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Зароботная плата:</label>
                                            <div class="col">
                                                <label class="col col-form-label">{{ $employee->mediator->wage }}</label>
                                            </div>
                                        </div>

                                        @if($employee->mediator->is_archive)
                                                </div>
                                            </div>
                                        @endif

                                    @else
                                        <div class="form-group row">
                                            <label class="col col-form-label">Сотрудник Неоформлен</label>
                                        </div>
                                    @endif

                                    <div class="card p3 text-center">
                                        <a href="{{ route('events.show', $employee->id) }}">Создать событие</a>
                                    </div>

                                    @foreach($employee->events as $event)
                                        <div class="card p-3">
                                            <blockquote class="blockquote mb-0">
                                                <p>{{ $event->description }}</p>
                                                <footer class="blockquote-footer">
                                                    <small class="text-muted">
                                                        Событие от:  <cite title="Source Title">{{ $event->createdDate() }}</cite>
                                                    </small>
                                                </footer>
                                            </blockquote>
                                        </div>
                                    @endforeach

                                </div>

                                <div class="col-sm-6">
                                    <div class="card">
                                        <img class="card-img" src="{{ $employee->getImage()  }}" alt="avatar">
                                    </div>
                                </div>

                            </div>
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
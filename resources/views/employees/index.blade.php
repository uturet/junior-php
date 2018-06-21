@extends('layouts.admin_app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">

                <div class="col-12 grid-margin stretch-card">

                    <div class="card">

                        <div class="card-body" id="search-form-app">
                        </div>

                        <div class="card-body">
                            <h4 class="card-title">{{ $formatting === 'unformed' ? 'Неоформленные Сотрудники' : 'Оформленные Сотрудники' }}</h4>
                            <div class="table-responsive" id="employees_table">
                                <div class="table-responsive">
                                    <table class="table table-hover hierarchy_table" style="min-width: 1600px">
                                        <thead>
                                        <tr>
                                            @foreach($fields as $key => $value)

                                                @if(in_array($key, $filtered))
                                                    @if($key !== $search['key'])
                                                        <td class="{{ $filtered['direction'] === 'asc' ? 'dropup' : '' }}">
                                                            <a class="dropdown-toggle" href="{{ route('employees.index', [
                                                                'formatting' => $formatting,
                                                                $key => '_query',
                                                                $search['key'] => $search['value'],
                                                                'direction' => $filtered['direction'] ===  'asc' ? 'desc' : 'asc'
                                                                ]) }}">
                                                    @else
                                                    <td>
                                                        <a class="disabled">
                                                    @endif

                                                @else
                                                <td>
                                                    <a href="{{ route('employees.index', [
                                                        'formatting' => $formatting,
                                                        $key => '_query',
                                                        $search['key'] => $search['value']
                                                        ]) }}">
                                                @endif
                                                    {{ $value }}
                                                    </a>
                                                </td>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($collection as $model)
                                                <tr>
                                                    @foreach($fields as $key => $value)
                                                        <td>
                                                            {{ isset($model->$key) ? $model->$key : null }}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $collection->links('pagination.default') }}
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
        <!-- content-wrapper ends -->
        <footer class="footer" id="table">
            <div class="container-fluid clearfix">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018 <a href="http://www.bootstrapdash.com/" target="_blank">Bootstrapdash</a>. All rights reserved.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
            </div>
        </footer>
        <!-- partial -->
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('/js/search-form-app.js') }}"></script>
@endsection

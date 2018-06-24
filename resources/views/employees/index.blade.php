@extends('layouts.admin_app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper" id="index-app">
            <div class="row">

                <div class="col-12 grid-margin stretch-card">

                    <div class="card">

                        <div class="card-body" id="search-form-app">
                        </div>

                        <div class="card-body">
                            <h4 class="card-title">Неоформленные Сотрудники</h4>
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

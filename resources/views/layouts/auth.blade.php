<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'ForestTwin') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('back/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('back/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('back/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('back/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('back/dist/css/adminlte.css')}}">
    <link rel="stylesheet" href="{{asset('back/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('back/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('back/css/custom.css')}}">

 <style>
       #login_submit1{
    background-color: #6c63ff;
}
 </style>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ asset('back/plugins/jquery/jquery.min.js') }}"></script>
 
    <script src="{{ asset('back/js/custom.js') }}" defer></script>
    <script>
        var BASE_URL = "<?= env('APP_URL') ?>";
    </script>
</head>
<body class="hold-transition login-page">
    @yield('content')
    <script src="{{ asset('back/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('back/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('back/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('back/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('back/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('back/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('back/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('back/plugins/datepicker/bootstrap-datepicker.js') }}"></script>

    @yield('page-js-script')
</body>
</html>

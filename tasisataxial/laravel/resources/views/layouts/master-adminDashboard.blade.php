<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <!-- Fonts -->



    <!-- Styles -->
    <link href="{{ asset('dashboard/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/ionicons/ionicons.min.css')}}" rel="stylesheet" >
    <link href="{{ asset('dashboard/dist/css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/plugins/iCheck/flat/blue.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/dist/css/bootstrap-rtl.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/dist/css/custom-style.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/dist/css/custom-dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/dist/css/persian-datepicker.min.css') }}" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="{{asset('js/chart.js')}}"></script>
    <script src="{{ asset('dashboard/js/jquery.min.js') }}"></script>

    <script src="{{ asset('js/app.js') }}" defer></script>
    

</head>
<style>
.ck-editor__editable_inline {
    min-height: 300px;
}
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        
        @include ('layouts/inc/admin-navbar')
        @include ('layouts/inc/admin-sidebar')
        
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@yield('page')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">خانه</a></li>
                        <li class="breadcrumb-item active">@yield('page') </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <div>
                    @yield ('content')
                </div>
            </div><!-- /.container-fluid -->
        </div>
    </div>
   <!-- Bootstrap core JavaScript-->

   <script src="{{ asset('dashboard/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('dashboard/dist/js/persian-date.js') }}"></script>
    <script src="{{ asset('dashboard/dist/js/persian-datepicker.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.js" integrity="sha512-RTxmGPtGtFBja+6BCvELEfuUdzlPcgf5TZ7qOVRmDfI9fDdX2f1IwBq+ChiELfWt72WY34n0Ti1oo2Q3cWn+kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    
    
    <!-- <script>
         $.widget.bridge('uibutton', $.ui.button)
    </script> -->

    <!-- bootstrap4-->

    
    <!-- bootstrap-wysihtml5-->

    <!-- AdminLTE App -->
    <script src="{{ asset('dashboard/dist/js/adminlte.js')}}"></script>
    <!-- slelect 2  -->
    <script src="{{asset('dashboard/dist/js/select2.full.min.js')}}"></script>
</body>
</html>
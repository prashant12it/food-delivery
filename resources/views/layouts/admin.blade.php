<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{env('APP_NAME')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('components.admin.head')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    @include('components.admin.header')
    @include('components.admin.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    @include('components.admin.footer')
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@include('components.admin.script')
</body>
</html>

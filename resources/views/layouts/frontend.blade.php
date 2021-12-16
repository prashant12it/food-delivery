<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | {{env('APP_NAME')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    @include('components.frontend.head')
</head>
<body>
<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

@include('components.frontend.header')
@yield('content')
@include('components.frontend.footer')

@include('components.frontend.script')
</body>
</html>

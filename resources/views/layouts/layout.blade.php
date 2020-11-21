<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{ config('app.name', 'Matrix') }}</title>
    <link href=" {{ mix('css/app.css') }}" rel="stylesheet">
    <meta name="robots" content="noindex,nofollow">
    @yield('header')
</head>
<body>
<div>
    @yield('content')
</div>
<script src="{{asset('js/app.js') }}"></script>

@include('footer')
</body>
</html>

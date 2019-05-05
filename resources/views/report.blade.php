<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    <link href="/css/app.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/semantic.min.css') }}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/semantic.min.js') }}"></script>
    <style>
        #table {
            margin-top: 50px;
        }
    </style>
</head>
<body>
<h3 class="ui block header">
    Reports
</h3>
<div id="app">
    <demo
        fetch-url="{{url('users/data-table')}}"
        :columns="['name', 'email', 'created_at']"
    ></demo>
</div>
</div>
</body>
</html>
<script src="{{ asset('js/app.js') }}"></script>

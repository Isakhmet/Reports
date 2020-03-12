<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('global.site_title') }} | {{ trans('global.company_name_title') }}</title>
    <link href="/css/app.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/semantic.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/main.css') }}">
    <script src="{{ secure_asset('js/jquery.min.js') }}"></script>
    <script src="{{ secure_asset('js/semantic.min.js') }}"></script>
</head>
<body>
<h2 class="ui block header inverted">
    <div class="">
        {{ trans('global.site_title') }} <sub>{{ trans('global.company_name_title') }}</sub>
        @can('user_management_access')
            <a class="ui right floated primary button inverted" href="{{ route('admin.home_admin') }}">Панель</a>
        @endcan
        <a class="ui right floated primary button inverted" href="{{ route('logout') }}">
            Выйти
        </a>
    </div>
</h2>
@can('report_access')
    <div id="app">
        <demo
                fetch-url="{{ secure_url('api/reports/getReports') }}"
        ></demo>
    </div>
@endcan
</body>
</html>
<script src="{{ secure_asset('js/app.js') }}"></script>

<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@lang('main::lang.text_maintenance_enabled')</title>
    <link rel="shortcut icon" href="{{ asset('app/admin/assets/images/favicon.ico') }}" type="image/ico">
    <link href="{{ asset('app/admin/assets/css/static.css') }}" rel="stylesheet">
</head>
<body>
    <article>
        {!! $message !!}
    </article>
</body>
</html>

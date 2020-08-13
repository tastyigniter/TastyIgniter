<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ 'Access denied' }}</title>
    <link rel="shortcut icon" href="{{ asset('app/admin/assets/images/favicon.ico') }}" type="image/ico">
    <link href="{{ asset('app/admin/assets/css/static.css') }}" rel="stylesheet">
</head>
<body>
<article>
    <h1>{{ 'Access denied' }}</h1>
    <p class="lead">@lang('admin::lang.alert_user_restricted')</p>
    <a href="javascript:;" onclick="history.go(-1); return false;">@lang('admin::lang.text_back_link')</a>
    <br><br>
    <a href="{{ Admin::url('') }}">@lang('admin::lang.text_admin_link')</a>
</article>
</body>
</html>

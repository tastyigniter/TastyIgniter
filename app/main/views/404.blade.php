<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@lang('main::lang.not_found.page_label')</title>
    <link rel="shortcut icon" href="{{ asset('app/admin/assets/images/favicon.ico') }}" type="image/ico">
    <link href="{{ asset('app/admin/assets/css/static.css') }}" rel="stylesheet">
</head>
<body>
    <article>
        <h1>@lang('main::lang.not_found.page_label')</h1>
        <p class="lead">@lang('main::lang.not_found.page_message')</p>
    </article>
</body>
</html>

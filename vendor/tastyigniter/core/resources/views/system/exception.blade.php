<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exception</title>
    <link rel="shortcut icon" href="{{ asset('vendor/igniter/images/favicon.svg') }}" type="image/ico">
    <link rel="stylesheet" href="{{ asset('vendor/igniter/css/static.css') }}" type="text/css">
</head>
<body>
<article>
    <h1>Exception</h1>
    <p class="lead">We're sorry, but an unhandled error occurred. Please see logs for more information.</p>
    <p>{!! $exception->getMessage() !!}</p>
</article>
</body>
</html>

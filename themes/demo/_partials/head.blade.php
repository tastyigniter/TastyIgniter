{!! get_metas() !!}
<link href="{{ asset('favicon.svg') }}" rel="shortcut icon" type="image/ico">
<title>{{ sprintf(lang('igniter::main.site_title'), lang(get_title()), setting('site_name')) }}</title>
<link href="{{ asset('vendor/igniter/css/app.css') }}" rel="stylesheet" type="text/css" id="igniter-css">
@styles

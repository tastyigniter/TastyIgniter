{!! get_metas() !!}
<meta name="csrf-token" content="{{ csrf_token() }}">
@if ($favicon = $theme->favicon)
    <link href="{{ media_url($favicon) }}" rel="shortcut icon" type="image/ico">
@elseif ($site_logo !== 'no_photo.png')
    <link href="{{ media_thumb($site_logo, ['width' => 64, 'height' => 64]) }}" rel="shortcut icon" type="image/ico">
@else
    {!! get_favicon() !!}
@endif
<title>{{ lang(get_title()).lang('igniter.orange::default.title_separator').setting('site_name') }}</title>
@if ($page->description)
    <meta name="description" content="{{ $page->description }}">
@endif
@if ($page->keywords)
    <meta name="keywords" content="{{ $page->keywords }}">
@endif
@unless($theme->font['download'] ?? FALSE)
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="{{$theme->font['url'] ?? 'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap'}}" rel="stylesheet">
@else
    @googlefonts
@endunless
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@themeStyles
@if (!empty($theme->custom_css))
    <style>{{$theme->custom_css}}</style>
@endif

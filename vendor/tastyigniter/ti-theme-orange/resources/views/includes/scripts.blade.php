{!! Assets::getJsVars() !!}
@themeScripts
@stack('scripts')
{!! $theme->ga_tracking_code !!}
@if (!empty($theme->custom_js))
    <script type="text/javascript">{!! $theme->custom_js !!}</script>
@endif

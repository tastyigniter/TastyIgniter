@if ($captchaSettings->version !== 'v2')
    @themePartial('@invisible')
@else
    <div class="g-recaptcha" data-sitekey="{{ $captchaSettings->api_site_key }}"></div>
    {!! form_error('g-recaptcha-response', '<span class="text-danger">', '</span>') !!}
    <script
        type="text/javascript"
        src="https://www.google.com/recaptcha/api.js?hl={{ $captchaSettings->lang }}"
        async defer
    ></script>
@endif

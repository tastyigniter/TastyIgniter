<div class="g-recaptcha" data-sitekey="{{ $captchaSettings->api_site_key }}"></div>
{!! form_error('g-recaptcha-response', '<span class="text-danger">', '</span>') !!}
<button
    class="g-recaptcha btn btn-primary"
    data-sitekey="{{ $captchaSettings->api_site_key }}"
    data-callback="recaptchaCallback"
>Submit</button>
<script
    type="text/javascript"
    src="https://www.google.com/recaptcha/api.js?hl={{ $captchaSettings->lang }}"
    async defer
></script>
<script type="application/javascript">
    function recaptchaCallback(token) {
        $('button.g-recaptcha').closest('form').submit();
        // document.getElementById("' . $formId . '").submit();
    }
</script>
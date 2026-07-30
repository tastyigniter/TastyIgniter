<div>
    <div class="g-recaptcha" data-sitekey="{{ $apiKey }}"></div>
    <x-igniter-orange::forms.error field="g-recaptcha-response" class="text-danger"/>
    <script
            type="text/javascript"
            src="https://www.google.com/recaptcha/api.js?hl={{ $lang }}"
            async defer
    ></script>
</div>

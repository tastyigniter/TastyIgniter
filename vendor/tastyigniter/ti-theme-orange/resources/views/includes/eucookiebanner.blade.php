@php
    $privacyPage = \Igniter\Pages\Models\Page::find($theme->gdpr_more_info_link)
@endphp
<div
    id="euCookieBanner"
    data-control="cookie-banner"
    data-active="{{ $theme->enable_gdpr }}"
    style="display:none;"
>
    <div
        style="background-color: {{ $theme->gdpr_background_color }}; color: {{ $theme->gdpr_text_color }};"
    >
        <div class="container">
            <div class="d-flex align-items-center">
                <p id="eu-cookie-message" class="mb-0">
                    <span>{{ $theme->gdpr_cookie_message }}</span>
                    <a
                        href="{{ page_url($privacyPage ? $privacyPage->permalink_slug : '') }}"
                    >{{ $theme->gdpr_more_info_text }}</a>
                </p>
                <a
                    id="eu-cookie-action"
                    class="btn btn-secondary ms-auto"
                    href="javascript:void(0);"
                >{{ $theme->gdpr_accept_text }}</a>
            </div>
        </div>
    </div>
</div>

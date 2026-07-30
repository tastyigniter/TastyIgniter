<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mt-4 mt-lg-0">
                <x-igniter-orange::nav code="footer-menu" />
            </div>

            <div class="col-lg-3 mt-4 mt-lg-0">
                <div class="social-bottom">
                    <h6 class="footer-title">@lang('igniter::main.text_follow_us')</h6>
                    @include('igniter-orange::includes.social-icons')
                </div>
            </div>

            <div class="col-lg-3 mt-4 mt-lg-0">
                <div id="newsletter-box">
                    <h5 class="mb-4">@lang('igniter.orange::default.newsletter.text_subscribe')</h5>
                    <livewire:igniter-orange::newsletter-subscribe-form />
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <hr class="mb-3">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col p-2">
                {!! sprintf(
                    lang('igniter::main.site_copyright'),
                    date('Y'),
                    $site_name,
                    lang('system::lang.system_name')
                ) !!}
            </div>
        </div>
    </div>
</div>

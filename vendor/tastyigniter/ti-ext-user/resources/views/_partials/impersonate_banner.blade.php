@if(app('main.auth')->isImpersonator())
    <div
        id="impersonate-banner"
        class="bg-dark position-fixed w-100 bottom-0 z-3 d-flex text-white justify-content-center align-items-center py-2"
    >
        <div class="fs-6">
            @lang('igniter.user::default.text_impersonating_user'): <strong>{{app('main.auth')->getFullName()}}</strong>
        </div>

        <a
            class="btn btn-light ms-3"
            href="{{page_url('logout')}}"
        >@lang('igniter.user::default.text_leave')</a>
    </div>
@endif

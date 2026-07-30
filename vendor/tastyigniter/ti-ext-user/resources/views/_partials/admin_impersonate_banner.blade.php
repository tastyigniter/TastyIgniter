@if(AdminAuth::isImpersonator())
    <div
        id="impersonate-banner"
        class="bg-dark position-fixed w-100 bottom-0 z-3 d-flex text-white justify-content-center align-items-center py-2"
    >
        <div class="fs-5">
            @lang('igniter.user::default.text_impersonating_user'): <strong>{{AdminAuth::getStaffName()}}</strong>
        </div>

        <a
            class="btn btn-light ms-3"
            href="{{admin_url('logout')}}"
        >@lang('igniter.user::default.text_leave')</a>
    </div>
@endif
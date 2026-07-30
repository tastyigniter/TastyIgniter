<div class="card p-4 shadow-sm m-4">
    <div class="text-center my-5 m-auto">
        <i class="fa fa-ban fa-4x text-muted mb-4"></i>
        <h1>@lang('igniter::admin.title_access_denied')</h1>
        <p class="lead mt-3">@lang('igniter::admin.alert_user_restricted')</p>
        <a href="javascript:;" onclick="history.go(-1); return false;">@lang('igniter::admin.text_back_link')</a>
        <br><br>
        <a href="{{ admin_url('/') }}">@lang('igniter::admin.text_admin_link')</a>
    </div>
</div>

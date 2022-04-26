<div class="container-fluid">
    <div class="login-container">
        <div class="card">
            <div class="card-body">
                <h5>@lang('admin::lang.login.text_reset_password_title')</h5>
                {!! form_open(current_url(),
                    [
                        'id' => 'edit-form',
                        'role' => 'form',
                        'method' => 'POST',
                        'data-request' => empty($resetCode) ? 'onRequestResetPassword' : 'onResetPassword',
                    ]
                ) !!}

                @empty($resetCode)
                    <div class="form-group">
                        <label
                            for="input-user"
                            class="form-label"
                        >@lang('admin::lang.label_email')</label>
                        <div class="">
                            <input name="email" type="text" id="input-user" class="form-control"/>
                            {!! form_error('email', '<span class="text-danger">', '</span>') !!}
                        </div>
                    </div>
                @else
                    <input type="hidden" name="code" value="{{ $resetCode }}">
                    <div class="form-group">
                        <input
                            type="password"
                            id="password"
                            class="form-control"
                            name="password"
                            placeholder="@lang('admin::lang.login.label_password')"
                        />
                        {!! form_error('password', '<span class="text-danger">', '</span>') !!}
                    </div>
                    <div class="form-group">
                        <input
                            type="password"
                            id="password-confirm"
                            class="form-control"
                            name="password_confirm"
                            placeholder="@lang('admin::lang.login.label_password_confirm')"
                        />
                        {!! form_error('password_confirm', '<span class="text-danger">', '</span>') !!}
                    </div>
                @endempty
                <div class="form-group">
                    <div class="pull-left">
                        <a
                            class="btn btn-default"
                            href="{{ admin_url('login') }}"
                        >@lang('admin::lang.login.text_back_to_login')</a>
                    </div>
                    <button
                        type="submit"
                        class="btn btn-primary pull-right"
                        data-attach-loading=""
                    >@lang('admin::lang.login.button_reset_password')</button>
                </div>
                {!! form_close() !!}
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="login-container">
        <div class="card">
            <div class="card-body">
                <h4>@lang('igniter.user::default.login.text_reset_password_title')</h4>
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
                        >@lang('igniter::admin.label_email')</label>
                        <div class="">
                            <input name="email" type="email" id="input-user" class="form-control"/>
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
                            placeholder="@lang('igniter.user::default.login.label_password')"
                        />
                        {!! form_error('password', '<span class="text-danger">', '</span>') !!}
                    </div>
                    <div class="form-group">
                        <input
                            type="password"
                            id="password-confirm"
                            class="form-control"
                            name="password_confirm"
                            placeholder="@lang('igniter.user::default.login.label_password_confirm')"
                        />
                        {!! form_error('password_confirm', '<span class="text-danger">', '</span>') !!}
                    </div>
                @endempty
                <div class="form-group">
                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                        data-attach-loading=""
                    >@lang('igniter.user::default.login.button_reset_password')</button>
                </div>

                <div class="form-group">
                    <p class="reset-password text-right">
                        <a
                            href="{{ admin_url('login') }}"
                        >@lang('igniter.user::default.login.text_back_to_login')</a>
                    </p>
                </div>
                {!! form_close() !!}
            </div>
        </div>
    </div>
</div>

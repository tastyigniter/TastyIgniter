<div>
    <h1 class="card-title h4 mb-4 font-weight-normal">
        @lang('igniter.orange::default.text_login')
    </h1>
    <x-igniter-orange::forms.form id="login-form" wire:submit="onLogin">
        <div class="form-group">
            <div class="input-group">
                <input
                    type="email"
                    class="form-control input-lg"
                    wire:model="form.email"
                    placeholder="@lang('igniter.user::default.settings.label_email')"
                    required
                />
                <span class="input-group-text">@</span>
            </div>
            <x-igniter-orange::forms.error field="form.email" class="text-danger"/>
        </div>

        <div class="form-group">
            <div class="input-group">
                <input
                    type="password"
                    wire:model="form.password"
                    class="form-control input-lg"
                    placeholder="@lang('igniter.user::default.login.label_password')"
                    required
                />
                <span class="input-group-text"><i class="fa fa-lock"></i></span>
            </div>
            <x-igniter-orange::forms.error field="form.password" class="text-danger"/>
        </div>

        <div class="form-group">
            <div class="d-md-flex justify-content-between">
                <div class="form-check">
                    <input
                        id="rememberLogin"
                        class="form-check-input"
                        type="checkbox"
                        wire:model="form.remember"
                        name="remember"
                        value="1"
                    />
                    <label class="form-check-label" for="rememberLogin">
                        @lang('igniter.user::default.login.label_remember')
                    </label>
                </div>
                <a
                    class="text-link text-nowrap"
                    href="{{ page_url('account.reset') }}"
                >@lang('igniter.orange::default.text_forgot')</a>
            </div>
            <x-igniter-orange::forms.error field="form.remember" class="text-danger"/>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-12">
                    <button
                        type="submit"
                        class="btn btn-primary w-100 btn-lg"
                        wire:loading.class="disabled"
                    >@lang('igniter.user::default.login.button_login')</button>
                </div>
            </div>
        </div>
    </x-igniter-orange::forms.form>

    <div class="text-center">
        @if ((bool)$registrationAllowed)
            @lang('igniter.orange::default.text_signup_no_account')
            <a
                class=""
                href="{{ page_url('account.register') }}"
            >@lang('igniter.orange::default.button_register')</a>
        @endif
    </div>
</div>

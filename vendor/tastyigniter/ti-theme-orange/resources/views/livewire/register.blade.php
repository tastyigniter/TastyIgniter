<div class="card border">
    <div class="card-body">
        <h1 class="card-title h4 mb-4 font-weight-normal">
            @lang('igniter.orange::default.text_register')
        </h1>

        @if ($registrationAllowed)
            <x-igniter-orange::forms.form id="register-form" wire:submit="onRegister">
                <div class="form-row mb-3">
                    <div class="col-sm-6">
                        <div @class(['form-floating', 'is-invalid' => has_form_error('form.first_name')])>
                            <input
                                wire:model="form.first_name"
                                id="first-name"
                                class="form-control"
                            />
                            <label for="first_name">@lang('igniter.user::default.settings.label_first_name')</label>
                        </div>
                        <x-igniter-orange::forms.error field="form.first_name" class="text-danger"/>
                    </div>
                    <div class="col-sm-6">
                        <div @class(['form-floating', 'is-invalid' => has_form_error('form.last_name')])>
                            <input
                                wire:model="form.last_name"
                                id="last-name"
                                class="form-control"
                            />
                            <label for="last_name">@lang('igniter.user::default.settings.label_last_name')</label>
                        </div>
                        <x-igniter-orange::forms.error field="form.last_name" class="text-danger"/>
                    </div>
                </div>
                <div class="form-group">
                    <div @class(['form-floating', 'is-invalid' => has_form_error('form.email')])>
                        <input
                            wire:model="form.email"
                            type="email"
                            id="email"
                            class="form-control"
                        />
                        <label for="email">@lang('igniter.user::default.settings.label_email')</label>
                    </div>
                    <x-igniter-orange::forms.error field="form.email" class="text-danger"/>
                </div>
                <div class="form-row mb-3">
                    <div class="col-sm-6">
                        <div @class(['form-floating', 'is-invalid' => has_form_error('form.password')])>
                            <input
                                type="password"
                                id="password"
                                class="form-control input-lg"
                                wire:model="form.password"
                            />
                            <label for="password">@lang('igniter.user::default.login.label_password')</label>
                        </div>
                        <x-igniter-orange::forms.error field="form.password" class="text-danger"/>
                    </div>
                    <div class="col-sm-6">
                        <div @class(['form-floating', 'is-invalid' => has_form_error('form.password_confirmation')])>
                            <input
                                type="password"
                                id="password-confirm"
                                class="form-control input-lg"
                                wire:model="form.password_confirmation"
                            />
                            <label for="password-confirm">@lang('igniter.user::default.login.label_password_confirm')</label>
                        </div>
                        <x-igniter-orange::forms.error field="form.password_confirmation" class="text-danger"/>
                    </div>
                </div>

                <div class="form-group">
                    <x-igniter-orange::forms.telephone
                        id="input-telephone"
                        :number="$form->telephone"
                        field="form.telephone"
                        :label="lang('igniter.user::default.settings.label_telephone')"
                    />
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input
                            id="newsletter"
                            type="checkbox"
                            wire:model="form.newsletter"
                            value="1"
                            class="form-check-input"
                        />
                        <label class="form-check-label" for="newsletter">
                            @lang('igniter.user::default.login.label_newsletter')
                        </label>
                    </div>
                    <x-igniter-orange::forms.error field="form.newsletter" class="text-danger"/>
                </div>

                @if ($requireRegistrationTerms && $agreeTermsSlug)
                    <div class="form-group">
                        <div class="form-check">
                            <input
                                type="checkbox"
                                id="agree-terms"
                                wire:model="form.terms"
                                value="1"
                                class="form-check-input"
                            />
                            <label class="form-check-label" for="agree-terms">
                                {!! sprintf(lang('igniter.user::default.login.label_terms'), url($agreeTermsSlug)) !!}
                            </label>
                        </div>
                        <x-igniter-orange::forms.error field="form.terms" class="text-danger"/>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12 mb-2">
                        <button
                            type="submit"
                            class="btn btn-primary w-100 btn-lg"
                            wire:loading.class="disabled"
                        >@lang('igniter.orange::default.button_register')</button>
                    </div>
                </div>
            </x-igniter-orange::forms.form>
            <div class="text-center">
                                <a
                    href="{{ page_url('account.login') }}"
                    class="btn btn-link"
                >@lang('igniter.orange::default.text_login_has_account')</a>
            </div>
        @else
            <p>@lang('igniter.user::default.login.alert_registration_disabled')</p>
        @endif
    </div>
</div>

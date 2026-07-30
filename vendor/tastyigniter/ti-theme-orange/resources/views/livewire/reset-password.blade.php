<div>
    @if($message)
        <div class="alert alert-info">
            {{ $message }}
        </div>
    @elseif($resetCode)
        <x-igniter-orange::forms.form wire:submit="onResetPassword">
            <input wire:model="resetCode" name="resetCode" type="hidden" />
            <div class="form-group">
                <div @class(['form-floating', 'is-invalid' => has_form_error('subject')])>
                    <input
                        wire:model="password"
                        name="password"
                        type="password"
                        class="form-control input-lg"
                    />
                    <label for="password">@lang('igniter.user::default.reset.label_password')</label>
                </div>
                <x-igniter-orange::forms.error field="password" class="text-danger"/>
            </div>
            <div class="form-group">
                <div @class(['form-floating', 'is-invalid' => has_form_error('subject')])>
                    <input
                        wire:model="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        class="form-control input-lg"
                        placeholder="@lang('igniter.user::.reset.label_password_confirm')"
                    />
                    <label for="password_confirmation">@lang('igniter.user::default.reset.label_password_confirm')</label>
                </div>
                <x-igniter-orange::forms.error field="passwordConfirm" class="text-danger"/>
            </div>
            <div class="clearfix">
                <button
                    type="submit"
                    class="btn btn-primary w-100 btn-lg"
                >@lang('igniter.user::default.reset.button_reset')</button>
            </div>
        </x-igniter-orange::forms.form>
    @else
        <p>@lang('igniter.user::default.reset.text_summary')</p>
        <x-igniter-orange::forms.form wire:submit="onForgotPassword">
            <div class="form-group">
                <div @class(['form-floating', 'is-invalid' => has_form_error('subject')])>
                    <input
                        wire:model="email"
                        name="email"
                        type="text"
                        id="email"
                        class="form-control input-lg"
                    />
                    <label for="email">@lang('igniter.user::default.reset.label_email')</label>
                </div>
                <x-igniter-orange::forms.error field="email" class="text-danger"/>
            </div>
            <div class="clearfix">
                <button
                    type="submit"
                    class="btn btn-primary btn-lg w-100 pull-right"
                >@lang('igniter.user::default.reset.button_reset')</button>
            </div>
        </x-igniter-orange::forms.form>
    @endif
</div>

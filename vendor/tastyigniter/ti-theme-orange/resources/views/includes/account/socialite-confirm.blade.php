<h1 class="card-title h4 mb-4 font-weight-normal">
    @lang('igniter.socialite::default.text_confirm_email')
</h1>

<p>@lang('igniter.socialite::default.help_confirm_email')</p>

<x-igniter-orange::forms.form id="confirm-email-form" wire:submit="onConfirmEmail">
    <div class="form-group">
        <input
            wire:model="email"
            type="text"
            id="email"
            class="form-control input-lg"
            value="{{ set_value('email') }}"
            placeholder="@lang('igniter.user::default.reset.label_email')"
        />
        {!! form_error('email', '<span class="text-danger">', '</span>') !!}
    </div>

    <button
        type="submit"
        class="btn btn-primary btn-lg w-100"
    >@lang('igniter.socialite::default.button_confirm')</button>
</x-igniter-orange::forms.form>

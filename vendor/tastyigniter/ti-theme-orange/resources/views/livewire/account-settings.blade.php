<div class="card">
    <div class="card-body">
        <h5 class="font-weight-normal mb-3">@lang('igniter.user::default.text_edit_details')</h5>
        <x-igniter-orange::forms.form wire:submit="onUpdate">
            <div class="form-row">
                <div class="col col-sm-6">
                    <div class="form-group">
                        <div @class(['form-floating'])>
                            <input
                                wire:model="form.first_name"
                                class="form-control"
                                name="first_name"
                            />
                            <label for="firstName">@lang('igniter.user::default.settings.label_first_name')</label>
                        </div>
                        <x-igniter-orange::forms.error field="form.first_name" class="text-danger"/>
                    </div>
                </div>
                <div class="col col-sm-6">
                    <div class="form-group">
                        <div @class(['form-floating'])>
                            <input
                                wire:model="form.last_name"
                                class="form-control"
                                name="last_name"
                            />
                            <label for="last_name">@lang('igniter.user::default.settings.label_last_name')</label>
                        </div>
                        <x-igniter-orange::forms.error field="form.first_name" class="text-danger"/>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col col-sm-6">
                    <div class="form-group">
                        <x-igniter-orange::forms.telephone
                            id="input-telephone"
                            :number="$form->telephone"
                            field="form.telephone"
                            :label="lang('igniter.user::default.settings.label_telephone')"
                        />
                    </div>
                </div>
                <div class="col col-sm-6">
                    <div class="form-group">
                        <div @class(['form-floating'])>
                            <input
                                wire:model="form.email"
                                class="form-control"
                                type="email"
                                :placeholder="@lang('igniter.user::default.settings.label_email')"
                            />
                            <label for="email">@lang('igniter.user::default.settings.label_email')</label>
                        </div>
                        <x-igniter-orange::forms.error field="form.email" class="text-danger"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input
                        type="checkbox"
                        wire:model="form.newsletter"
                        id="newsletter"
                        class="form-check-input"
                        value="1"
                    />
                    <label for="newsletter" class="form-check-label">
                        @lang('igniter.user::default.settings.label_newsletter')
                    </label>
                </div>
                <x-igniter-orange::forms.error field="form.newsletter" class="text-danger"/>
            </div>

            <div class="my-3">
                <h5 class="font-weight-normal">@lang('igniter.user::default.settings.text_password_heading')</h5>
            </div>

            <div class="form-group">
                <div @class(['form-floating'])>
                    <input
                        type="password"
                        class="form-control"
                        wire:model="form.old_password"
                    />
                    <label for="password" class="form-check-label">
                        @lang('igniter.user::default.settings.label_old_password')
                    </label>
                </div>
                <x-igniter-orange::forms.error field="form.old_password" class="text-danger"/>
            </div>

            <div class="form-row">
                <div class="col col-sm-6">
                    <div class="form-group">
                        <div @class(['form-floating'])>
                            <input
                                type="password"
                                class="form-control"
                                wire:model="form.password"
                                placeholder="@lang('igniter.user::default.settings.label_password')"
                            >
                            <label for="password" class="form-check-label">
                                @lang('igniter.user::default.settings.label_password')
                            </label>
                        </div>
                        <x-igniter-orange::forms.error field="form.password" class="text-danger"/>
                    </div>
                </div>
                <div class="col col-sm-6">
                    <div class="form-group">
                        <div @class(['form-floating'])>
                            <input
                                type="password"
                                class="form-control"
                                wire:model="form.password_confirmation"
                            >
                            <label for="password" class="form-check-label">
                                @lang('igniter.user::default.settings.label_password_confirm')
                            </label>
                        </div>
                        <x-igniter-orange::forms.error field="form.password_confirmation" class="text-danger"/>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <button
                    type="submit"
                    class="btn btn-primary"
                >@lang('igniter.user::default.settings.button_save')</button>
            </div>
        </x-igniter-orange::forms.form>
    </div>
</div>

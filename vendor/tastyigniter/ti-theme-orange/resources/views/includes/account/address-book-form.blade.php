<div
    id="addressBookFormModal"
    @class(['modal fade'])
    role="dialog"
    tabindex="-1"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <x-igniter-orange::forms.form
                    wire:submit="onSave"
                    role="form"
                >
                    <input
                        type="hidden"
                        wire:model="form.address_id"
                    />
                    <div class="form-group">
                        <label for="address1">@lang('igniter.user::default.account.label_address_1')</label>
                        <input
                            id="address1"
                            wire:model="form.address_1"
                            class="form-control"
                        />
                        <x-igniter-orange::forms.error field="form.address_1" class="text-danger"/>
                    </div>

                    <div class="form-group">
                        <label for="address2">@lang('igniter.user::default.account.label_address_2')</label>
                        <input
                            id="address2"
                            wire:model="form.address_2"
                            class="form-control"
                        />
                        <x-igniter-orange::forms.error field="form.address_2" class="text-danger"/>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="city">@lang('igniter.user::default.account.label_city')</label>
                                <input
                                    id="city"
                                    class="form-control"
                                    wire:model="form.city"
                                />
                                <x-igniter-orange::forms.error field="form.city" class="text-danger"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="state">@lang('igniter.user::default.account.label_state')</label>
                                <input
                                    id="state"
                                    class="form-control"
                                    wire:model="form.state"
                                />
                                <x-igniter-orange::forms.error field="form.state" class="text-danger"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="postcode">@lang('igniter.user::default.account.label_postcode')</label>
                                <input
                                    id="postcode"
                                    class="form-control"
                                    wire:model="form.postcode"
                                />
                                <x-igniter-orange::forms.error field="form.postcode" class="text-danger"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>@lang('igniter.user::default.account.label_country')</label>
                        <select
                            class="form-select"
                            wire:model="form.country_id"
                        >
                            <option>@lang('admin::lang.text_select')</option>
                            @foreach (countries() as $key => $value)
                                <option
                                    value="{{ $key }}"
                                    {!! $key == $selectAddress?->country_id ? ' selected="selected"' : '' !!}
                                >{{ $value }}</option>
                            @endforeach
                        </select>
                        <x-igniter-orange::forms.error field="form.country_id" class="text-danger"/>
                    </div>

                    <div class="form-group">
                        <div class="form-check py-2">
                            <input
                                wire:model="form.is_default"
                                wire:loading.attr="disabled"
                                type="checkbox"
                                id="isDefaultAddress"
                                class="form-check-input"
                                value="1"
                            />
                            <label
                                class="form-check-label w-100"
                                for="isDefaultAddress"
                            >@lang('igniter.user::default.text_set_default')</label>
                        </div>
                        <x-igniter-orange::forms.error field="form.is_default" class="text-danger"/>
                    </div>

                    <div class="d-flex justify-content-between">
                        @if($selectAddress)
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >@lang('igniter.user::default.account.button_update')</button>
                            <button
                                type="button"
                                class="btn btn-light text-danger"
                                wire:click="onDelete({{ $selectAddress->address_id }})"
                                wire:loading.class="disabled"
                            >@lang('igniter.user::default.account.text_delete')</button>
                            <a
                                class="btn btn-light"
                                data-bs-dismiss="modal"
                            >@lang('igniter::admin.button_close')</a>
                        @else
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >@lang('igniter.user::default.account.button_add')</button>
                            <a
                                class="btn btn-light"
                                data-bs-dismiss="modal"
                            >@lang('igniter::admin.button_close')</a>
                        @endif
                    </div>
                </x-igniter-orange::forms.form>
            </div>
        </div>
    </div>
</div>

@script
<script>
    $(document).render(function () {
        $('#addressBookFormModal').modal('show');
        $('#addressBookFormModal').on('hidden.bs.modal', function () {
            $wire.$set('addressId', null);
        });

        Livewire.hook('morph.removing', ({ el, component }) => {
            if ($(el).is('#addressBookFormModal')) {
                $('#addressBookFormModal').modal('hide');
            }
        })

        Livewire.hook('morph.updated', ({ el, component }) => {
            if ($(el).is('#addressBookFormModal')) {
                $('#addressBookFormModal').modal('dispose');
                $('#addressBookFormModal').modal('show');
            }
        })
    });
</script>
@endscript

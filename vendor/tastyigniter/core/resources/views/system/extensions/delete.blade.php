<div class="d-flex p-3">
    @if($previousUrl = AdminMenu::getPreviousUrl())
        <a
            class="btn shadow-none border-none ps-0"
            href="{{$previousUrl}}"
        ><i class="fa fa-angle-left fs-4 align-bottom"></i></a>
    @endif
    <h4 class="page-title mb-0 lh-base">
        <span>{!! Template::getHeading() !!}</span>
    </h4>
</div>
<div class="row-fluid">
    <div class="card shadow-sm mx-3">
        {!! form_open(current_url(),
            [
                'id' => 'edit-form',
                'role' => 'form',
                'method' => 'DELETE',
            ]
        ) !!}

        <input type="hidden" name="_handler" value="onDelete">

        <div class="toolbar px-3 py-2 border-bottom">
            <button
                type="submit"
                class="btn btn-danger"
                data-request="onDelete"
            >@lang('igniter::system.extensions.button_yes_delete')</button>
            <a class="btn btn-default" href="{{ admin_url('extensions') }}">
                @lang('igniter::system.extensions.button_return_to_list')
            </a>
        </div>

        <div class="form-fields p-3">
            @php $deleteAction = $extensionData
    ? lang('igniter::system.extensions.text_files_data')
    : lang('igniter::system.extensions.text_files');
            @endphp
            <p>
                {!! sprintf(lang('igniter::system.extensions.alert_delete_warning'), $deleteAction, $extensionName) !!}
                <br/>
                {!! sprintf(lang('igniter::system.extensions.alert_delete_confirm'), $deleteAction) !!}
            </p>
            @if ($extensionData)
                <div class="form-group span-full">
                    <label
                        for="input-delete-data"
                        class="form-label"
                    >@lang('igniter::system.extensions.label_delete_data')</label>
                    <div
                        id="input-delete-data"
                    >
                        <input
                            type="hidden"
                            name="delete_data"
                            value="0"
                        >
                        <div class="form-check form-switch">
                            <input
                                type="checkbox"
                                name="delete_data"
                                id="delete-data"
                                class="form-check-input"
                                value="1"
                            />
                            <label
                                class="form-check-label"
                                for="delete-data"
                            >@lang('igniter::admin.text_no')/@lang('igniter::admin.text_yes')</label>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        {!! form_close() !!}
    </div>
</div>

@php
    $fieldOptions = $field->value;
@endphp
<div class="field-flexible-hours">
    <div class="table-responsive">
        <table class="table table-stripped">
            <thead>
            <tr>
                <th></th>
                <th>@lang('admin::lang.locations.label_schedule_hours')</th>
                <th class="text-right">@lang('admin::lang.label_status')</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($formModel->getWeekDaysOptions() as $key => $day)
                @php
                    $hour = $fieldOptions[$key] ?? ['day' => $key, 'open' => '00:00', 'close' => '23:59', 'status' => 1]
                @endphp
                <tr>
                    <td>
                        <span>{{ $day }}</span>
                        <input
                            type="hidden"
                            name="{{ $field->getName().'['.$loop->index.'][day]' }}"
                            value="{{ $hour['day'] }}"
                        />
                    </td>
                    <td>
                        <div class="input-group" data-control="input-mask" data-autoclose="true">
                            <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                            <input
                                type="text"
                                name="{{ $field->getName().'['.$loop->index.'][hours]' }}"
                                class="form-control"
                                data-control="inputmask"
                                data-inputmask-regex="(([01][0-9]|2[0-3]):([0-5][0-9])\-([01][0-9]|2[0-3]):([0-5][0-9])((,)( )?))*$"
                                placeholder=""
                                value="{{ $hour['hours'] }}"
                                autocomplete="off"
                            />
                        </div>
                    </td>
                    <td class="text-right">
                        <input
                            type="hidden"
                            name="{{ $field->getName().'['.$loop->index.'][status]' }}"
                            value="0"
                            {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
                        >
                        <div class="form-check form-switch">
                            <input
                                type="checkbox"
                                name="{{ $field->getName().'['.$loop->index.'][status]' }}"
                                id="{{ $field->getId($loop->index.'status') }}"
                                class="form-check-input"
                                value="1"
                                {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
                                {!! $hour['status'] == 1 ? 'checked="checked"' : '' !!}
                                {!! $field->getAttributes() !!}
                            />
                            <label
                                class="form-check-label"
                                for="{{ $field->getId($loop->index.'status') }}"
                            ></label>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

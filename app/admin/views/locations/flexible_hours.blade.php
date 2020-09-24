@php
    $fieldOptions = $field->value;
@endphp
<div class="field-flexible-hours">
    <div class="row">
        <div class="col-sm-7">
            <div class="table-responsive">
                <table class="table table-stripped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>@lang('admin::lang.locations.label_open_hour')</th>
                        <th>@lang('admin::lang.locations.label_close_hour')</th>
                        <th>@lang('admin::lang.label_status')</th>
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
                                <div class="input-group" data-control="clockpicker" data-autoclose="true">
                                    <input
                                        type="text"
                                        name="{{ $field->getName().'['.$loop->index.'][open]' }}"
                                        class="form-control"
                                        autocomplete="off"
                                        value="{{ $hour['open'] }}"
                                        {!! $field->getAttributes() !!}
                                    />
                                    <div class="input-group-append">
                                        <span class="input-group-icon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="input-group" data-control="clockpicker" data-autoclose="true">
                                    <input
                                        type="text"
                                        name="{{ $field->getName().'['.$loop->index.'][close]' }}"
                                        class="form-control"
                                        autocomplete="off"
                                        value="{{ $hour['close'] }}"
                                        {!! $field->getAttributes() !!}
                                    />
                                    <div class="input-group-append">
                                        <span class="input-group-icon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input
                                    type="hidden"
                                    name="{{ $field->getName().'['.$loop->index.'][status]' }}"
                                    value="0"
                                    {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
                                >
                                <div class="custom-control custom-switch">
                                    <input
                                        type="checkbox"
                                        name="{{ $field->getName().'['.$loop->index.'][status]' }}"
                                        id="{{ $field->getId($loop->index.'status') }}"
                                        class="custom-control-input"
                                        value="1"
                                        {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
                                        {!! $hour['status'] == 1 ? 'checked="checked"' : '' !!}
                                        {!! $field->getAttributes() !!}
                                    />
                                    <label
                                        class="custom-control-label"
                                        for="{{ $field->getId($loop->index.'status') }}"
                                    >@lang('admin::lang.locations.text_closed')
                                        /@lang('admin::lang.locations.text_open')</label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

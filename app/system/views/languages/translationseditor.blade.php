<div
    id="{{ $this->getId('items-container') }}"
    class="field-translationseditor"
    data-control="translationseditor"
    data-alias="{{ $this->alias }}"
>
    <label
        for="{{ $this->getId('items') }}"
    >{{ sprintf(lang('system::lang.languages.text_locale_strings'), $translatedProgress, $totalStrings) }}</label>
    <div
        id="{{ $this->getId('items') }}"
        class="table-responsive"
    >
        <table class="table mb-0 border-bottom">
            <thead>
            <tr>
                <th width="45%">@lang('system::lang.languages.column_variable')</th>
                <th>{{ sprintf(lang('system::lang.languages.column_language'), $this->model->name) }}</th>
            </tr>
            </thead>
            <tbody>
            @if ($field->options && $field->options->count())
                @foreach ($field->options as $key => $value)
                    <tr>
                        <td>
                            <p>{{ $value['source'] }}</p>
                            <span class="text-muted">{{ $key }}</span>
                        </td>
                        <td>
                            <input
                                type="hidden"
                                name="{{ $field->getName() }}[{{ $key }}][source]"
                                value="{{ $value['source'] }}"
                            />
                            <textarea
                                class="form-control"
                                rows="3"
                                name="{{ $field->getName() }}[{{ $key }}][translation]"
                            >{!! $value['translation'] !!}</textarea>
                        </td>
                    </tr>
                @endforeach
                <tr class="border-top">
                    <td colspan="999">
                        <div class="d-flex justify-content-end">
                            {!! $field->options->render() !!}
                        </div>
                    </td>
                </tr>
            @else
                <tr>
                    <td colspan="99" class="text-center">@lang('system::lang.languages.text_empty_translations')
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>

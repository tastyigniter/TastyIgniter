@php($translation = $field->options)
<div
    id="{{ $this->getId() }}"
    class="field-translationseditor"
    data-control="translationseditor"
    data-alias="{{ $this->alias }}"
>
    <h5
        class="fw-600"
    >{{ sprintf(lang('igniter::system.languages.text_locale_strings'), $translation->total, $translation->translated, $translation->progress, $translation->untranslated) }}</h5>
    <span class="help-block">@lang('igniter::system.languages.help_locale_strings')</span>
    <div
        id="{{ $this->getId('items') }}"
        class="table-responsive mt-3"
    >
        <table class="table mb-0">
            <thead>
            <tr>
                <th width="1"></th>
                <th>{{ sprintf(lang('igniter::system.languages.column_language'), $this->model->name) }}</th>
                <th width="45%">@lang('igniter::system.languages.column_variable')</th>
            </tr>
            </thead>
            <tbody>
            @if ($translation->strings->count())
                @foreach($translation->strings as $key => $value)
                    <tr>
                        <td>
                            <a
                                role="button"
                                class="btn btn-link"
                                data-control="edit-translation"
                                data-input-name="{{ $field->getName() }}[{{ $key }}]"
                                data-source="{{ $value['source'] }}"
                                data-translation='{!! $value['translation'] !!}'
                            ><i class="fa fa-pencil"></i></a>
                        </td>
                        <td
                            data-control="edit-translation"
                            data-input-name="{{ $field->getName() }}[{{ $key }}]"
                            data-source="{{ $value['source'] }}"
                            data-translation="{{$value['translation']}}"
                        >
                            <div data-toggle="translation-preview">
                                <p class="mb-1">{{ $value['translation'] ?: '--' }}</p>
                            </div>
                            <div data-toggle="translation-input"></div>
                        </td>
                        <td>
                            <p class="mb-1">{{ $value['source'] }}</p>
                            <span class="text-muted small">{{ $key }}</span>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td class="border-bottom-0" colspan="999">
                        <div class="d-flex justify-content-end pt-3">
                            {!! $translation->strings->render() !!}
                        </div>
                    </td>
                </tr>
            @else
                <tr>
                    <td colspan="99" class="text-center">@lang('igniter::system.languages.text_empty_translations')
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    @unless($this->model->code === 'en')
    <div class="card p-3 mt-4 text-center">
        <h4>@lang('igniter::system.languages.text_publish_translations')</h4>
        <p>{{html(sprintf(lang('igniter::system.languages.help_publish_translations'), 'https://translate.tastyigniter.com'))}}</p>
        <div>
            <button
                type="button"
                class="btn btn-light"
                data-request="onPublishTranslations"
            >
                <i class="fa fa-cloud-upload-alt"></i>&nbsp;&nbsp;
                @lang('igniter::system.languages.button_publish_translations')
            </button>
        </div>
    </div>
    @endunless
</div>

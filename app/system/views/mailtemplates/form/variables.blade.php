@php
    $variables = $variables ?? $field->options();
@endphp
<div class="w-100 flex-column{{ $cssClass ?? '' }}">
    <label class="sr-only">
        @lang('system::lang.mail_templates.text_variables')
    </label>
    <select
        class="form-select"
        autocomplete="off"
        onchange="$('#email-variables > div').hide();$('#'+this.value).show()"
    >
        @foreach ($variables as $groupName => $vars)
            <option
                value="{{ str_slug($groupName) }}"
                {!! $loop->first ? 'selected="selected"' : '' !!}
            >@lang($groupName)</option>
        @endforeach
    </select>
    <div
        id="email-variables"
        class="card card-body bg-white mt-2"
    >
        <p class="small">@lang('system::lang.mail_templates.help_variables')</p>
        @foreach ($variables as $groupName => $vars)
            <div
                id="{{ str_slug($groupName) }}"
                style="display: {{ $loop->first ? 'block' : 'none' }};"
            >
                @foreach ($vars as $variable => $label)
                    <span
                        class="badge border mb-2 text-muted text-draggable"
                        title="@lang($label)"
                        style="font-size: 100%;"
                        draggable="true"
                        ondragstart="event.dataTransfer.setData('text/plain', event.target.innerText)">
                    {{ $variable }}</span>
                @endforeach
            </div>
        @endforeach
    </div>
</div>

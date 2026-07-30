@if($tabs->suppressTabs)

    <div
        id="{{ $this->getId($tabs->section.'-tabs') }}"
        class="p-3 {{ $tabs->cssClass }}">
        <div class="form-fields">
            {!! $this->makePartial('form/form_fields', ['fields' => $tabs]) !!}
        </div>
    </div>

@else

    <div
        id="{{ $this->getId($tabs->section.'-tabs') }}"
        class="{{ $tabs->section }}-tabs {{ $tabs->cssClass }}"
        data-control="form-tabs">
        {!! $this->makePartial('form/form_tabs', ['tabs' => $tabs]) !!}
    </div>

@endif

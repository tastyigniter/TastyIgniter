@if ($tabs->suppressTabs)

    <div
        id="{{ $this->getId($tabs->section.'-tabs') }}"
        class="{{ $tabs->cssClass }}">
        <div class="form-fields">
            {!! $this->makePartial('form/form_fields', ['fields' => $tabs]) !!}
        </div>
    </div>

@else

    <div
        id="{{ $this->getId($tabs->section.'-tabs') }}"
        class="{{ $tabs->section }}-tabs {{ $tabs->cssClass }}"
        data-control="form-tabs"
        data-store-name="{{ $cookieKey }}">
        {!! $this->makePartial('form/form_tabs', ['tabs' => $tabs]) !!}
    </div>

@endif

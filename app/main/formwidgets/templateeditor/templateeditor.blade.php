@unless ($this->previewMode)
    <div
        id="{{ $this->getId() }}"
        class="control-template-editor progress-indicator-container"
        data-control="template-editor"
        data-alias="{{ $this->alias }}"
    >
        {!! $this->makePartial('templateeditor/toolbar') !!}

        {!! $this->makePartial('templateeditor/modal') !!}

        @if ($templateWidget)
            <div
                id="{{ $this->getId($templatePrimaryTabs->section.'-tabs') }}"
                class="{{ $templatePrimaryTabs->cssClass }}">
                <div class="py-3">
                    {!! $templateWidget->makePartial('form/form_fields', ['fields' => $templatePrimaryTabs]) !!}
                </div>
            </div>

            <div
                id="{{ $this->getId($templateSecondaryTabs->section.'-tabs') }}"
                class="{{ $templateSecondaryTabs->section }}-tabs {{ $templateSecondaryTabs->cssClass }} mx-n3"
                data-control="form-tabs"
                data-store-name="{{ $templateWidget->getCookieKey() }}">
                {!! $templateWidget->makePartial('form/form_tabs', [
                    'activeTab' => $templateWidget->getActiveTab(),
                    'tabs' => $templateSecondaryTabs
                ]) !!}
            </div>
        @endif

    </div>
@endunless

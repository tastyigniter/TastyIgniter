<div
    id="{{ $this->getId() }}"
    class="field-menu-option-editor"
    data-control="menu-option-editor"
    data-alias="{{ $this->alias }}"
>
    <div
        id="{{ $this->getId('toolbar') }}"
        class="mb-3"
    >
        {!! $this->makePartial('menuoptioneditor/toolbar') !!}
    </div>

    <div
        id="{{ $this->getId('items') }}"
        role="tablist"
        aria-multiselectable="true">
        {!! $this->makePartial('menuoptioneditor/items') !!}
    </div>
</div>

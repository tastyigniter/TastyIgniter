<div
    id="{{ $this->getId() }}"
    class="field-scheduleeditor"
    data-control="scheduleeditor"
    data-alias="{{ $this->alias }}"
>
    <div
        id="{{ $this->getId('schedules') }}"
        role="tablist"
        aria-multiselectable="true"
    >
        {!! $this->makePartial('scheduleeditor/schedules') !!}
    </div>
</div>

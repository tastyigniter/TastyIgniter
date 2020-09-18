<div
    id="{{ $this->getId() }}"
    class="control-statuseditor"
    data-control="status-editor"
    data-alias="{{ $this->alias }}"
>
    {!! $this->makePartial('statuseditor/info') !!}
</div>

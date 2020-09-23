<div
    class="input-group control-colorpicker"
    data-control="colorpicker"
    data-swatches-colors='@json($availableColors)'
>
    <div class="component input-group-prepend input-group-icon"><i class="fa fa-square"></i></div>
    <input
        type="text"
        id="{{ $this->getId('input') }}"
        name="{{ $name }}"
        class="form-control"
        value="{{ $value }}"
        {!! ($this->previewMode) ? 'disabled="disabled"' : '' !!}>
</div>

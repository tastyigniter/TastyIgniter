@if (strlen($buttonAttributes = $this->getButtonAttributes($record, $column)))
    <a {!! $buttonAttributes !!}>
        @if ($column->iconCssClass)
            <i class="{{ $column->iconCssClass }}"></i>
        @endif
    </a>
@endif

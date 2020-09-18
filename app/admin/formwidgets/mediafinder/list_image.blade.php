<div class="image-list">
    @php if (!is_array($value)) $value = [$value]; @endphp
    @if (count($value))
        @foreach ($value as $item)
            @if (!$item) @continue
            {!! $this->makePartial('mediafinder/image_'.$mode, ['value' => !is_string($item) ? null : $item]) !!}
        @endforeach
    @endif

    {!! $this->makePartial('mediafinder/image_'.$mode, ['value' => null]) !!}
</div>

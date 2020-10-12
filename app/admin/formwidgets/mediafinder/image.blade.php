<div class="media-image{{ $isMulti ? ' image-list' : '' }}">
    @if (count($value))
        @foreach ($value as $mediaItem)
            {!! $this->makePartial('mediafinder/image_'.$mode, ['mediaItem' => $mediaItem]) !!}
        @endforeach
    @else
        {!! $this->makePartial('mediafinder/image_'.$mode, ['mediaItem' => null]) !!}
    @endif
</div>

<script type="text/template" data-blank-template>
    {!! $this->makePartial('mediafinder/image_'.$mode, ['mediaItem' => null]) !!}
</script>

<script type="text/template" data-image-template>
    {!! $this->makePartial('mediafinder/image_'.$mode, ['mediaItem' => '']) !!}
</script>

<div
    id="{{ $this->getId('container') }}"
    class="media-image{{ $isMulti ? ' image-list' : '' }}"
>
    @if(count($value))
        @foreach($value as $mediaItem)
            {!! $this->makePartial('mediafinder/image_'.$mode, ['mediaItem' => $mediaItem]) !!}
        @endforeach
    @else
        {!! $this->makePartial('mediafinder/image_'.$mode, ['mediaItem' => null]) !!}
    @endif
</div>

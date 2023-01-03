<div class="media-finder">
    <div class="input-group">
        <div class="input-group-text" style="width: 50px;">
            @if (!is_null($mediaItem))
                @if(($mediaFileType = $this->getMediaFileType($mediaItem)) === 'image')
                    <img
                        data-find-image
                        src="{{ $this->getMediaThumb($mediaItem) }}"
                        class="img-responsive"
                        width="24px"
                    >
                @else
                    <div class="media-icon w-100">
                        <i
                            data-find-file
                            class="fa fa-{{ $mediaFileType }} text-muted"
                        ></i>
                    </div>
                @endif
            @endif
        </div>
        <span
            class="form-control{{ (!is_null($mediaItem) && $useAttachment) ? ' find-config-button' : '' }}"
            data-find-name>{{ $this->getMediaName($mediaItem) }}</span>
        <input
            id="{{ $field->getId() }}"
            type="hidden"
            {!! !$useAttachment ? 'name="'.$fieldName.'"' : '' !!}
            data-find-value
            value="{{ $this->getMediaPath($mediaItem) }}"
            {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
        >
        <input
            type="hidden"
            value="{{ $this->getMediaIdentifier($mediaItem) }}"
            data-find-identifier
        />
        @unless ($this->previewMode)
            <button class="btn btn-outline-primary find-button{{ !is_null($mediaItem) ? ' hide' : '' }}" type="button">
                <i class="fa fa-picture-o"></i>
            </button>
            <button
                class="btn btn-outline-danger find-remove-button{{ !is_null($mediaItem) ? '' : ' hide' }}"
                type="button">
                <i class="fa fa-times-circle"></i>
            </button>
        @endunless
    </div>
</div>

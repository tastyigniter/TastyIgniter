<div class="media-list row no-gutters">
    @foreach ($items as $item)
        <div class="media-item col-2">
            <div
                class="media-thumb"
                data-media-item
                data-media-item-name="{{ $item->name }}"
                data-media-item-type="{{ $item->type}}"
                data-media-item-file-type="{{ $item->fileType }}"
                data-media-item-path="{{ $item->path }}"
                data-media-item-size="{{ $item->sizeToString() }}"
                data-media-item-modified="{{ $item->lastModifiedAsString() }}"
                data-media-item-url="{{ $item->publicUrl }}"
                data-media-item-dimension="{{ isset($item->thumb['dimension']) ? $item['thumb']['dimension'] : '--' }}"
                data-media-item-folder="{{ $currentFolder }}"
                data-media-item-data='@json($item)'
                @if ($item->name == $selectItem || $loop->iteration == 0) data-media-item-marked=""@endif
            >
                <a>
                    @if($item->fileType === 'image')
                        <img
                            alt="{{ $item->name }}" class="img-responsive"
                            src="{{ $item->publicUrl }}"
                        />
                    @else
                        <div class="media-icon">
                            <i class="fa fa-{{ $item->fileType }} fa-3x text-muted mb-2"></i>
                            <span class="d-inline-block text-truncate mw-100">{{ $item->name }}</span>
                        </div>
                    @endif
                </a>
            </div>
        </div>
    @endforeach
</div>

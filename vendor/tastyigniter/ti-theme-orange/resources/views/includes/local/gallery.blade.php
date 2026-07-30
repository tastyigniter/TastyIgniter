<h5>@lang('igniter.local::default.text_gallery')</h5>
<div class="card">
    <div class="card-body">
        @if ($locationInfo->hasGallery())
            <div id="localGallery" class="row gallery">
                @foreach($locationInfo->gallery() as $media)
                    <div class="col-sm-4">
                        <a
                            href="{{ $media->getPath() }}"
                            data-pswp-width="{{$media->width}}"
                            data-pswp-height="{{$media->height}}"
                            target="_blank"
                        >
                            <img class="img-fluid img-rounded" src="{{ $media->getThumb() }}"/>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p>@lang('igniter.local::default.text_empty_gallery')</p>
        @endif
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const lightbox = new PhotoSwipeLightbox({
            gallery: '#localGallery',
            children: 'a',
            pswpModule: () => PhotoSwipe
        });
        lightbox.init();
    });
</script>

<div class="module-box">
    @if($bannerData->isCustom())
        {!! $bannerData->markup !!}
    @elseif($bannerData->isCarousel())
        <a href="{{ $bannerData->clickUrl }}">
            <div id="{{ $bannerData->id }}" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @for ($i = 0; $i < count($bannerData->imageUrls()); $i++)
                        <button
                            data-bs-target="#{{ $bannerData->id }}"
                            data-bs-slide-to="{{ $i }}"
                            class="{{ $i === 0 ? 'active' : '' }}"
                        ></button>
                    @endfor
                </div>

                <div class="carousel-inner">
                    @foreach ($bannerData->imageUrls() as $imageUrl)
                        <div
                            class="carousel-item {{ $loop->index === 0 ? 'active' : '' }}"
                            data-width="{{ $bannerData->imageWidth }}"
                            data-height="{{ $bannerData->imageHeight }}"
                        >
                            <img
                                class="d-block w-100"
                                alt="{{ $bannerData->altText }}"
                                src="{{ $imageUrl }}"
                            />
                        </div>
                    @endforeach
                </div>

                <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#{{ $bannerData->id }}"
                    data-bs-slide="prev"
                >
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#{{ $bannerData->id }}"
                    data-bs-slide="next"
                >
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </a>
    @elseif($bannerData->isImage())
        @foreach ($bannerData->imageUrls() as $imageUrl)
            <div
                class="thumbnail"
                data-width="{{ $bannerData->imageWidth }}"
                data-height="{{ $bannerData->imageHeight }}"
            >
                <a href="{{ $bannerData->clickUrl }}">
                    <img
                        alt="{{ $bannerData->altText }}"
                        src="{{ $imageUrl }}"
                        class="thumb img-fluid"
                    />
                </a>
            </div>
        @endforeach
    @endif
</div>

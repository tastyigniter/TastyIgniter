<div>
    @if (count($featuredItems))
        <div id="featured-menu-box" class="module-box py-5">
            <div class="container text-center">
                <h2 class="mb-3">@lang($title)</h2>

                <div class="row g-3">
                    @foreach ($featuredItems as $featuredItem)
                        <div class="col-sm-{{ round(12 / $itemsPerRow) }} mb-3 mb-sm-0">
                            <a
                                class="text-decoration-none text-reset"
                                href="{{ $featuredItem->getUrl() }}"
                            >
                                <div class="card text-left rounded-5 h-100">
                                    @if ($showThumb)
                                        <img
                                            class="card-img-top rounded-5"
                                            src="{{ $featuredItem->getThumb([
                                        'width' => $itemWidth,
                                        'height' => $itemHeight,
                                    ]) }}" alt="{{ $featuredItem->name }}"
                                        />
                                    @endif
                                    <div class="card-body p-4">
                                        <h5 class="card-title">
                                            {{ $featuredItem->name }}
                                            <span class="float-end">{{ currency_format($featuredItem->price()) }}</span>
                                        </h5>
                                        <p class="card-text">{{ $featuredItem->description }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

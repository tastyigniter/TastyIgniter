<div class="d-flex align-items-center ingredients mt-3">
    @foreach ($ingredients as $ingredient)
        <span
            @class([
                'bg-light rounded small fw-bold px-2',
                'py-1' => !$ingredient->hasMedia('thumb'),
                'me-2' => !$loop->last
            ])
            data-bs-toggle="tooltip"
            title="{{ $ingredient->name }}: {{ $ingredient->description }}"
        >
        @if ($showThumb && $ingredient->hasMedia('thumb'))
            <img
                class="img-fluid rounded"
                alt="{{ $ingredient->name }}"
                src="{{ $ingredient->getThumb(['width' => $ingredientThumbWidth, 'height' => $ingredientThumbHeight]) }}"
            />
        @endif
        {{ $ingredient->name }}
    </span>
    @endforeach
</div>

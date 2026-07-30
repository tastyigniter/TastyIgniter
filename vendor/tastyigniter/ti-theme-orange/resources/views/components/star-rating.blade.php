<div
    {{ $attributes }}
>
    @if($readOnly && isset($max))
        @for ($value = 1; $value<($max+1); $value++)
            <span @class([
                'fa-star',
                'fa' => $value <= $score,
                'far' => $value >= $score
             ])></span>
        @endfor
    @elseif(isset($hints))
        <div
            wire:ignore
            data-control="star-rating"
            data-hints='@json($hints)'
            data-score-name="{{ $name }}"
        >
            <div class="rating rating-star text-warning"></div>
        </div>
    @endif

    {{ $slot }}
</div>

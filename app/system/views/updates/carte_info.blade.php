@isset($carteInfo['owner'])
    <div class="card-body border-bottom">
        <div class="d-flex">
            <div class="media-right media-middle">
                <i class="fa fa-globe fa-3x"></i>
            </div>
            <div class="flex-grow-1 wrap-left">
                <a
                    class="btn border pull-right"
                    onclick="$('.carte-body').slideToggle()"
                ><i class="fa fa-pencil"></i></a>
                <h3>{{ $carteInfo['name'] }}</h3>
                <p class="mb-1">{{ $carteInfo['url'] }}</p>
                <p class="mb-1">{{ $carteInfo['description'] ?? '' }}</p>
                <p class="mb-1"><strong>Owner:</strong> {{ $carteInfo['owner'] }}</p>
                @isset($carteInfo['items_count'])
                    <p class="mb-1"><strong>Total Items:</strong> {{ $carteInfo['items_count'] }}</p>
                @endisset
            </div>
        </div>
    </div>
@endisset

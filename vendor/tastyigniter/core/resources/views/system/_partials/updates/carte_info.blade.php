<div class="d-flex p-3">
    <div class="media-right media-middle">
        <i class="fa fa-globe fa-3x"></i>
    </div>
    <div class="flex-grow-1 wrap-left">
        <a
            class="btn border border-danger text-danger pull-right ms-2"
            data-request="onClearCarte"
        ><i class="fa fa-trash-alt"></i></a>
        <a
            class="btn border pull-right"
            onclick="$('.carte-body').slideToggle()"
        ><i class="fa fa-pencil"></i></a>
        <h6 class="mb-1">{{ $carteInfo['name'] }}</h6>
        <p class="lead mb-1">{{ $carteInfo['url'] }}</p>
        <p class="mb-1">{{ $carteInfo['description'] ?? '' }}</p>
        <p class="mb-1">Owner: <strong>{{ $carteInfo['owner'] }}</strong></p>
        @isset($carteInfo['items_count'])
            <p class="mb-1">Total Items: <strong>{{ $carteInfo['items_count'] }}</strong></p>
        @endisset
    </div>
</div>

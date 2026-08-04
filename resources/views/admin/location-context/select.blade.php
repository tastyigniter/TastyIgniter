<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Select branch</title>
    <style>
        body{margin:0;background:#f5f6f8;color:#25313c;font:15px system-ui,sans-serif}.wrap{max-width:760px;margin:7vh auto;padding:24px}
        h1{margin-bottom:6px}.lead{color:#687480;margin-top:0}.card{display:flex;align-items:center;justify-content:space-between;background:#fff;border:1px solid #dfe3e8;border-radius:8px;padding:18px;margin:12px 0;box-shadow:0 2px 7px #0000000a}
        .address{color:#687480;margin-top:5px}.notice{background:#fff4dd;border:1px solid #e7bd68;border-radius:6px;padding:12px 14px}.status{font-size:12px;font-weight:700}.on{color:#28834b}.off{color:#a23a3a}button{border:0;border-radius:5px;background:#e4572e;color:#fff;padding:10px 16px;font-weight:700;cursor:pointer}button[disabled]{background:#aab1b7;cursor:not-allowed}.current{border-color:#e4572e}.global{margin-top:24px}
    </style>
</head>
<body><main class="wrap">
    <h1>Select a restaurant branch</h1>
    <p class="lead">Only branches assigned to your staff account are shown.</p>
    @if(session('restaurant_ops_location_message'))
        <p class="notice" role="alert">{{ session('restaurant_ops_location_message') }}</p>
    @endif
    @forelse($locations as $location)
        <section class="card {{ optional($activeLocation)->getKey() === $location->getKey() ? 'current' : '' }}">
            <div><strong>{{ $location->location_name }}</strong>
                <div class="address">{{ collect([$location->location_address_1, $location->location_city])->filter()->join(', ') ?: 'Address not available' }}</div>
                <span class="status {{ $location->location_status ? 'on' : 'off' }}">{{ $location->location_status ? 'ACTIVE' : 'INACTIVE' }}</span>
            </div>
            <form method="post" action="{{ route('naxas.restaurantops.location-context.switch') }}">@csrf
                <input type="hidden" name="location_id" value="{{ $location->getKey() }}">
                <button type="submit" @disabled(!$location->location_status && !$canSelectInactive)>{{ optional($activeLocation)->getKey() === $location->getKey() ? 'Current branch' : 'Select' }}</button>
            </form>
        </section>
    @empty
        <section class="card"><strong>No active branch is assigned to your account.</strong></section>
    @endforelse
    @if($canViewAll)
        <form class="global" method="post" action="{{ route('naxas.restaurantops.location-context.global') }}">@csrf
            <button type="submit">Use all locations (reporting)</button>
        </form>
    @endif
</main></body></html>

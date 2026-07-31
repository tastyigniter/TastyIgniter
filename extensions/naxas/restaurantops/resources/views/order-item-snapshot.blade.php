@extends('igniter::admin.layouts.default')

@section('content')
<div class="container-fluid">
    <h1 class="h3">Purchased menu configuration</h1>
    <p class="text-muted">Order item #{{ $orderMenu->getKey() }} · Snapshot schema {{ $snapshot['schema_version'] ?? 0 }}</p>
    <dl class="row">
        <dt class="col-sm-3">Menu item</dt><dd class="col-sm-9">{{ data_get($snapshot, 'menu_item.name', data_get($snapshot, 'legacy.menu_item.name')) }}</dd>
        <dt class="col-sm-3">Variant</dt><dd class="col-sm-9">{{ data_get($snapshot, 'variant.name', 'Legacy / no enhanced variant') }}</dd>
        <dt class="col-sm-3">Service</dt><dd class="col-sm-9">{{ data_get($snapshot, 'service_type', 'Legacy') }}</dd>
        <dt class="col-sm-3">Location</dt><dd class="col-sm-9">{{ data_get($snapshot, 'location.name', 'Legacy') }}</dd>
        <dt class="col-sm-3">Purchased total</dt><dd class="col-sm-9">{{ data_get($snapshot, 'line_total', data_get($snapshot, 'legacy.line_total')) }}</dd>
    </dl>
    @foreach(data_get($snapshot, 'modifier_groups', []) as $group)
        <h2 class="h5">{{ $group['name'] }}</h2>
        <ul>@foreach($group['modifiers'] as $modifier)<li>{{ $modifier['quantity'] }} × {{ $modifier['name'] }} ({{ $modifier['unit_price'] }})</li>@endforeach</ul>
    @endforeach
</div>
@endsection

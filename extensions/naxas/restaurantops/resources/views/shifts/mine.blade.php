<div class="container-fluid">
    <h1 class="h3">@lang('Naxas.RestaurantOps::default.navigation.active_shift')</h1>
    @if($shift)
        <p>Active shift #{{ $shift->getKey() }}</p>
        <a class="btn btn-primary" href="{{ route('naxas.restaurantops.shifts.show', $shift) }}">View shift</a>
    @else
        <p class="text-muted">No active shift. Open a shift to begin cashier operations.</p>
        @if(admin_user()->hasPermission('Restaurant.Shifts.Open'))
            <a class="btn btn-primary" href="{{ route('naxas.restaurantops.shifts.open') }}">@lang('Naxas.RestaurantOps::default.shifts.open')</a>
        @endif
    @endif
</div>

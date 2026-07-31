<div class="container-fluid">
    <h1 class="h3">@lang('Naxas.RestaurantOps::default.navigation.shift_review')</h1>
    <p class="text-muted">Branch-scoped shift submissions awaiting review.</p>
    <div class="list-group">
        @forelse($records as $shift)
            <a class="list-group-item list-group-item-action" href="{{ route('naxas.restaurantops.shifts.show', $shift) }}">#{{ $shift->getKey() }} — {{ str($shift->status->value)->replace('_', ' ') }}</a>
        @empty
            <div class="list-group-item text-muted">No shifts match the current review status.</div>
        @endforelse
    </div>
    {{ $records->links() }}
</div>

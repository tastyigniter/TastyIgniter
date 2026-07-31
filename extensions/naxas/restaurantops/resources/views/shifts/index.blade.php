<div class="container-fluid py-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div><h1 class="h3 mb-1">@lang('Naxas.RestaurantOps::default.shifts.title')</h1><p class="text-muted mb-0">@lang('Naxas.RestaurantOps::default.shifts.branch_help')</p></div>
        @if(admin_user()->hasPermission('Restaurant.Shifts.Open'))<a class="btn btn-primary" href="{{ admin_url('restaurant-ops/shifts/open') }}">@lang('Naxas.RestaurantOps::default.shifts.open')</a>@endif
    </div>
    <form class="card card-body mb-3" method="get"><div class="row g-2">
        <div class="col-md-3"><select name="status" class="form-select"><option value="">@lang('Naxas.RestaurantOps::default.shifts.all_statuses')</option>@foreach(['open','closing_requested','submitted','approved','rejected','force_closed','cancelled'] as $status)<option @selected(request('status') === $status) value="{{ $status }}">{{ str($status)->replace('_', ' ')->title() }}</option>@endforeach</select></div>
        <div class="col-md-3"><input class="form-control" type="date" name="date_from" value="{{ request('date_from') }}"></div><div class="col-md-3"><input class="form-control" type="date" name="date_to" value="{{ request('date_to') }}"></div><div class="col-md-3"><button class="btn btn-outline-secondary w-100">@lang('Naxas.RestaurantOps::default.shifts.filter')</button></div>
    </div></form>
    <div class="card"><div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th>#</th><th>@lang('Naxas.RestaurantOps::default.shifts.cashier')</th><th>@lang('Naxas.RestaurantOps::default.shifts.opened')</th><th>@lang('Naxas.RestaurantOps::default.shifts.status')</th><th>@lang('Naxas.RestaurantOps::default.shifts.expected')</th><th>@lang('Naxas.RestaurantOps::default.shifts.variance')</th></tr></thead><tbody>
    @forelse($records as $shift)<tr><td><a href="{{ admin_url('restaurant-ops/shifts/'.$shift->id) }}">{{ $shift->id }}</a></td><td>{{ $shift->staff_id }}</td><td>{{ $shift->opened_at }}</td><td><span class="badge bg-secondary">{{ str($shift->status->value)->replace('_', ' ') }}</span></td><td>{{ $shift->expected_cash === null ? '—' : currency_format($shift->expected_cash) }}</td><td>{{ $shift->variance === null ? '—' : currency_format($shift->variance) }}</td></tr>@empty<tr><td colspan="6" class="text-center text-muted py-5">@lang('Naxas.RestaurantOps::default.shifts.empty')</td></tr>@endforelse
    </tbody></table></div></div><div class="mt-3">{{ $records->links() }}</div>
</div>

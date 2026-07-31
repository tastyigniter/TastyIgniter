<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h1 class="h3">{{ $title }}</h1>
            <p class="text-muted">This is an operational access landing page. Functional workflows are scheduled for a later phase.</p>
            <dl class="row mb-0">
                <dt class="col-sm-3">Staff</dt><dd class="col-sm-9">{{ $user->name }}</dd>
                <dt class="col-sm-3">Operational profile</dt><dd class="col-sm-9">{{ $profileLabel }}</dd>
                <dt class="col-sm-3">Active branch</dt><dd class="col-sm-9">{{ $global ? 'All locations (reporting only)' : ($activeLocation?->location_name ?? 'Not selected') }}</dd>
                <dt class="col-sm-3">Assigned active branches</dt><dd class="col-sm-9">{{ $assigned->pluck('location_name')->join(', ') ?: 'None' }}</dd>
                <dt class="col-sm-3">High-level access</dt><dd class="col-sm-9">{{ $summary->join(', ') ?: 'Operations overview only' }}</dd>
            </dl>
        </div>
    </div>
</div>

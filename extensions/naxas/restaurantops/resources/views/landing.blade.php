<div class="container-fluid py-3">
    <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $title }}</h1>
            <p class="text-muted mb-0">
                {{ $workspace === 'overview' ? 'Monitor branch context, operational access, and current staff readiness.' : 'Your permission-aware Restaurant Operations workspace.' }}
            </p>
        </div>
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <span class="badge bg-{{ $readiness['staffActive'] ? 'success' : 'danger' }}">{{ $profileLabel }}</span>
            <span class="badge bg-{{ $activeLocation ? 'primary' : 'warning' }}">
                <i class="fa fa-map-marker-alt me-1"></i>{{ $global ? 'All locations' : ($activeLocation?->location_name ?? 'Branch not selected') }}
            </span>
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.location-context.select') }}">
                <i class="fa fa-exchange-alt me-1"></i>Switch location
            </a>
        </div>
    </div>

    @if($workspace === 'overview')
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3"><div class="card h-100"><div class="card-body">
                <div class="text-muted small text-uppercase mb-2">Active Branch</div>
                <h2 class="h5 mb-2">{{ $global ? 'All locations' : ($activeLocation?->location_name ?? 'Not selected') }}</h2>
                <span class="badge bg-{{ $activeLocation ? 'success' : ($global ? 'info' : 'warning') }}">{{ $activeLocation ? 'Active' : ($global ? 'Reporting mode' : 'Action required') }}</span>
                <a class="d-block mt-3" href="{{ route('admin.location-context.select') }}">Switch location <i class="fa fa-arrow-right ms-1"></i></a>
            </div></div></div>
            <div class="col-sm-6 col-xl-3"><div class="card h-100"><div class="card-body">
                <div class="text-muted small text-uppercase mb-2">Staff Profile</div>
                <h2 class="h5 mb-2">{{ $user->name }}</h2>
                <p class="mb-2">{{ $profileLabel }}</p>
                <span class="badge bg-{{ $readiness['staffActive'] ? 'success' : 'danger' }}">{{ $readiness['staffActive'] ? 'Active' : 'Inactive' }}</span>
            </div></div></div>
            <div class="col-sm-6 col-xl-3"><div class="card h-100"><div class="card-body">
                <div class="text-muted small text-uppercase mb-2">Assigned Branches</div>
                <h2 class="display-6 mb-2">{{ $assigned->count() }}</h2>
                <p class="text-muted mb-0">{{ $assigned->pluck('location_name')->join(', ') ?: 'No active branches assigned' }}</p>
            </div></div></div>
            <div class="col-sm-6 col-xl-3"><div class="card h-100"><div class="card-body">
                <div class="text-muted small text-uppercase mb-2">Operational Access</div>
                <h2 class="display-6 mb-2">{{ $modules->count() }}</h2>
                <p class="text-muted mb-0">{{ $summary->join(', ') ?: 'Operations overview only' }}</p>
            </div></div></div>
        </div>

        <div class="row g-3 mb-4">
            <section class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header"><h2 class="h5 mb-0">Quick access</h2></div>
                    <div class="card-body">
                        <div class="row g-2">
                            @forelse($modules as $module)
                                <div class="col-sm-6 col-xl-4">
                                    <a class="btn btn-outline-secondary text-start w-100 h-100 py-3" href="{{ $module['url'] }}">
                                        <i class="fa {{ $module['icon'] }} fa-fw me-2"></i>{{ $module['label'] }}
                                    </a>
                                </div>
                            @empty
                                <div class="col"><p class="text-muted mb-0">No additional operational modules are assigned.</p></div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
            <section class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header"><h2 class="h5 mb-0">Operational readiness</h2></div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between"><span>Profile</span><strong>{{ $profileLabel }}</strong></li>
                        <li class="list-group-item d-flex justify-content-between"><span>Active branch selected</span><span class="badge bg-{{ $readiness['locationSelected'] ? 'success' : 'warning' }}">{{ $readiness['locationSelected'] ? 'Yes' : 'No' }}</span></li>
                        <li class="list-group-item d-flex justify-content-between"><span>Assigned branch</span><span class="badge bg-{{ $readiness['assignedToActive'] ? 'success' : 'secondary' }}">{{ $readiness['assignedToActive'] ? 'Yes' : 'No' }}</span></li>
                        <li class="list-group-item d-flex justify-content-between"><span>Transactional context</span><span class="badge bg-{{ $readiness['transactionalReady'] ? 'success' : 'warning' }}">{{ $readiness['transactionalReady'] ? 'Ready' : 'Not ready' }}</span></li>
                        <li class="list-group-item d-flex justify-content-between"><span>Global/reporting mode</span><span class="badge bg-{{ $readiness['global'] ? 'info' : 'secondary' }}">{{ $readiness['global'] ? 'On' : 'Off' }}</span></li>
                    </ul>
                </div>
            </section>
        </div>
    @else
        <div class="card mb-4"><div class="card-body">
            <h2 class="h5">Current branch context</h2>
            <p class="mb-3">{{ $global ? 'All locations (reporting only)' : ($activeLocation?->location_name ?? 'Select a branch to begin transactional work.') }}</p>
            <a class="btn btn-primary" href="{{ route('admin.location-context.select') }}">Choose branch</a>
            @if($workspaceAction)
                <a class="btn btn-outline-secondary" href="{{ $workspaceAction['url'] }}">Open POS</a>
            @endif
        </div></div>
    @endif

    @if(!$readiness['transactionalReady'] && !$global)
        <div class="alert alert-warning" role="alert"><i class="fa fa-exclamation-triangle me-2"></i>Select an active assigned branch to use transactional modules.</div>
    @endif
    <div class="alert alert-info mb-0" role="status"><i class="fa fa-info-circle me-2"></i>Restaurant Operations foundation is active. Operational modules are being enabled phase by phase.</div>
</div>

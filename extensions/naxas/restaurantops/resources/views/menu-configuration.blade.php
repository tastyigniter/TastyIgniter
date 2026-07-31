@extends('admin::layouts.default')

@section('content')
<div class="container-fluid py-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div><h1 class="h3 mb-1">{{ lang('Naxas.RestaurantOps::default.menu_configuration.title') }}</h1><p class="text-muted mb-0">{{ $menu->menu_name }} (#{{ $menu->getKey() }}) — official menu and option data remains authoritative.</p></div>
        <a class="btn btn-light" href="{{ admin_url('menus/edit/'.$menu->getKey()) }}">{{ lang('Naxas.RestaurantOps::default.menu_configuration.official_menu') }}</a>
    </div>
    <div class="alert alert-info">Inherited values follow: variant attachment → item attachment → shared option metadata. Branch overrides require a selected concrete location.</div>
    <div class="row g-3">
        @foreach (['variants' => $variants->count(), 'modifier_groups' => $groups->count(), 'shared_options' => $sharedGroups->count(), 'combo' => $combo ? 1 : 0] as $section => $count)
        <div class="col-md-6 col-xl-3"><div class="card h-100"><div class="card-body"><h2 class="h5">{{ lang('Naxas.RestaurantOps::default.menu_configuration.'.$section) }}</h2><p class="display-6 mb-1">{{ $count }}</p><small class="text-muted">Configuration foundation</small></div></div></div>
        @endforeach
    </div>
    <div class="card mt-3"><div class="card-body"><h2 class="h5">Scope</h2><p class="mb-0">Configure variants, official-option metadata, modifier attachments, availability/pricing, combos, kitchen names and station references through RestaurantOps APIs. Full POS, waiter and kitchen workflows are intentionally not included.</p></div></div>
</div>
@endsection

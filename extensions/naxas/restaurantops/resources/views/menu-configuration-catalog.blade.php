@extends('admin::layouts.default')

@section('content')
<div class="container-fluid py-3">
    <h1 class="h3">{{ lang('naxas.restaurantops::default.menu_configuration.title') }}</h1>
    <p class="text-muted">Select an official TastyIgniter menu item to configure optional RestaurantOps metadata.</p>
    <div class="list-group">
        @foreach ($menus as $menu)
            <a class="list-group-item list-group-item-action d-flex justify-content-between" href="{{ route('naxas.restaurantops.menu-configuration', $menu) }}">
                <span>{{ $menu->menu_name }}</span><span class="text-muted">#{{ $menu->getKey() }}</span>
            </a>
        @endforeach
    </div>
    <div class="mt-3">{{ $menus->links() }}</div>
</div>
@endsection

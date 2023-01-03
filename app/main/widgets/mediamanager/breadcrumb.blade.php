<ol class="breadcrumb py-2">
    @foreach ($breadcrumbs as $key => $breadcrumb)
        @if ($key == count($breadcrumbs) - 1)
            <li class="breadcrumb-item active">{!! $breadcrumb['name'] !!}</li>
        @else
            <li class="breadcrumb-item">{!! $breadcrumb['name'] !!}</li>
        @endif
    @endforeach
</ol>

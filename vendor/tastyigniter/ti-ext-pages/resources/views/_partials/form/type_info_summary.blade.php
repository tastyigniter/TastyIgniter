<p class="card-title font-weight-bold mb-0">@lang($item->title)</p>
@if ($item->parent)
    <span class="text-muted">Parent: </span>@lang($item->parent->title)&nbsp;&nbsp;
@endif
<span class="text-muted">Type: </span>{{ $item->type }}
<div
    data-properties='@json($item->toArray())'
></div>
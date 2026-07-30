<div class="small d-flex align-items-center">
    <div class="me-3">
        <i class="fas fa-circle {{ $item->is_enabled ? 'text-success' : 'text-danger' }}"></i>
    </div>
    <span class="font-weight-bold fs-5 me-3">@lang($item->name)</span>
    <div class="border rounded-pill px-2 py-1 d-inline-block me-3">
        {{ $item->min_capacity }} - {{ $item->max_capacity }} ({{ $item->extra_capacity }})
    </div>
    <span class="text-muted">@lang('igniter.reservation::default.dining_tables.column_section'):&nbsp;</span>
    {{ $item->dining_section->name ?? '--' }}&nbsp;&nbsp;
    <span class="text-muted">@lang('igniter.reservation::default.dining_tables.label_priority'):&nbsp;</span>{{ $item->priority }}
</div>

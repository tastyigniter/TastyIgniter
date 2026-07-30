@php
    $badgeClass = match ($result->status) {
        'failed' => 'bg-danger',
        'warning' => 'bg-warning text-dark',
        default => 'bg-success',
    };
    $statusLabel = match ($result->status) {
        'failed' => lang('igniter::system.system.status_failed'),
        'warning' => lang('igniter::system.system.status_warning'),
        default => lang('igniter::system.system.status_ok'),
    };
@endphp
<div @class([
    'col-sm-6 col-lg-4 col-xl-3' => $check->name() !== 'CacheUsageCheck',
    'col-sm-12 col-lg-8 col-xl-6' => $check->name() === 'CacheUsageCheck',
]) id="check-{{ $check->name() }}">
    <div class="card h-100">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                <div class="d-flex align-items-center gap-2 min-w-0">
                    <i @class([$check->icon(), 'text-muted'])></i>
                    <h6 class="mb-0 fw-bold text-truncate">{{ $check->label() }}</h6>
                </div>
                <span @class(['badge flex-shrink-0', $badgeClass])>{{ $statusLabel }}</span>
            </div>

            @if($result->shortSummary)
                <p class="small text-muted mb-2">{{ $result->shortSummary }}</p>
            @endif

            @if($check->name() === 'CacheUsageCheck' && isset($result->meta['cacheSizes']))
                {!! $this->makePartial('system/cache_usage', [
                    'cacheSizes' => $result->meta['cacheSizes'],
                    'totalCacheSize' => $result->meta['totalCacheSize'],
                    'formattedTotalCacheSize' => $result->meta['formattedTotalCacheSize'],
                ]) !!}
            @elseif($check->name() === 'ExtensionThemeVersionCheck')
                <button
                    type="button"
                    class="btn btn-sm btn-default"
                    data-bs-toggle="modal"
                    data-bs-target="#extensions-themes-modal"
                >
                    @lang('igniter::system.system.button_view_extensions_themes')
                </button>
                @once
                    {!! $this->makePartial('system/extensions_themes_modal', ['result' => $result]) !!}
                @endonce
            @elseif(!empty($result->meta))
                <ul class="list-unstyled small mb-0">
                    @foreach($result->meta as $key => $value)
                        @continue(
                            $key === 'cacheSizes'
                            || $key === 'totalCacheSize'
                            || $key === 'formattedTotalCacheSize'
                            || $key === 'extensions'
                            || $key === 'theme'
                            || (is_array($value) && !array_key_exists('value', $value))
                        )
                        @php
                            $itemValue = is_array($value) ? ($value['value'] ?? '') : $value;
                            $itemStatus = is_array($value) ? ($value['status'] ?? null) : null;
                            $itemIcon = match ($itemStatus) {
                                'failed' => 'fa fa-circle-exclamation text-danger',
                                'warning' => 'fa fa-exclamation-triangle text-warning',
                                default => null,
                            };
                        @endphp
                        <li class="d-flex justify-content-between gap-2 py-1 border-bottom border-light">
                            <span class="text-muted">{{ is_string($key) ? $key : $itemValue }}</span>
                            <span class="text-end fw-medium d-flex align-items-center justify-content-end gap-1">
                                @if($itemIcon)
                                    <i @class([$itemIcon]) aria-hidden="true"></i>
                                @endif
                                {{ is_string($key) ? $itemValue : '' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>

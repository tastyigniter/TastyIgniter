<div class="container-fluid">
    <h1 class="h3">{{ $title }}</h1>
    <p class="text-muted">Module foundation. The {{ str($status)->replace('_', ' ') }} order workflow is coming in the assigned phase.</p>
    <div class="list-group">
        @forelse($orders as $order)
            <div class="list-group-item">#{{ $order->getKey() }} — {{ str($order->status)->replace('_', ' ') }}</div>
        @empty
            <div class="list-group-item text-muted">No {{ str($status)->replace('_', ' ') }} orders.</div>
        @endforelse
    </div>
    {{ $orders->links() }}
</div>

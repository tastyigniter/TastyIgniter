<div class="container-fluid">
    <h1 class="h3">{{ $title }}</h1>
    <p class="text-muted">Versioned {{ str($status)->replace('_', ' ') }} POS orders for the selected branch.</p>
    <div class="list-group">
        @forelse($orders as $order)
            <div class="list-group-item d-flex justify-content-between"><span>#{{ $order->getKey() }} — {{ str($order->status)->replace('_', ' ') }} — {{ $order->order_total }}</span>@if($order->status === 'payment_pending')<a class="btn btn-primary" href="{{ route('naxas.restaurantops.pos.payments.page', $order) }}">Take payment</a>@endif</div>
        @empty
            <div class="list-group-item text-muted">No {{ str($status)->replace('_', ' ') }} orders.</div>
        @endforelse
    </div>
    {{ $orders->links() }}
</div>

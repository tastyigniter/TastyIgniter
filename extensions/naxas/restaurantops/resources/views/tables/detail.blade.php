<div class="container-fluid">
    <h2>Running Bill — {{ $session->table->name ?? 'Table' }}</h2>
    <p>Floor: {{ $session->table->floor->name ?? '' }} | Guests: {{ $session->guest_count }} | Opened: {{ $session->opened_at }}</p>
    @foreach($orders as $order)
        <section class="card mb-3"><div class="card-header">Order #{{ $order->order_id ?: $order->getKey() }} — {{ $order->status }}</div><div class="card-body">
            <table class="table"><thead><tr><th>Item</th><th>Qty</th><th>Unit</th><th>Line</th></tr></thead><tbody>@foreach($order->items as $item)<tr><td>{{ $item->configuration_payload['name'] ?? ('Menu '.$item->menu_id) }}</td><td>{{ $item->quantity }}</td><td>{{ number_format((float)$item->unit_total, 2) }}</td><td>{{ number_format((float)$item->line_total, 2) }}</td></tr>@endforeach</tbody></table>
            <dl><dt>Discount</dt><dd>{{ number_format((float)$order->discount_total, 2) }}</dd><dt>Tax</dt><dd>{{ number_format((float)$order->tax_total, 2) }}</dd><dt>Delivery/Service</dt><dd>{{ number_format((float)$order->delivery_total, 2) }}</dd><dt>Grand total</dt><dd>{{ number_format((float)$order->order_total, 2) }}</dd></dl>
        </div></section>
    @endforeach
    <h3>Summary</h3><p>Grand total: {{ number_format($grand_total, 2) }} | Paid: {{ number_format($payment_received, 2) }} | Outstanding: {{ number_format($outstanding, 2) }} | Payment: {{ $payment_state }}</p>
</div>

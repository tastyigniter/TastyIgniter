<div class="container-fluid restaurant-ops-table-map">
    <h2>Table Map</h2>
    @foreach($floors as $floor)
        <section class="card mb-3">
            <div class="card-header"><strong>FLOOR: {{ $floor->name }}</strong> <span class="text-muted">{{ $floor->code }}</span></div>
            <div class="card-body position-relative" style="min-height: 420px;">
                @forelse($floor->tables as $table)
                    @php($session = $table->activeSession)
                    @php($order = $session ? $session->posOrder : null)
                    <article class="border rounded p-2 bg-light" style="position:absolute; left:{{ $table->position_x }}px; top:{{ $table->position_y }}px; width:{{ $table->width }}px; min-height:{{ $table->height }}px; transform:rotate({{ $table->rotation }}deg);">
                        <h3 class="h6 mb-1">{{ $table->name }} <small>#{{ $table->table_number }}</small></h3>
                        <div>Status: <strong>{{ strtoupper($table->status) }}</strong></div>
                        <div>Capacity: {{ $session ? $session->guest_count.' / ' : '' }}{{ $table->capacity }}</div>
                        @if($order)
                            <div>Order: #{{ $order->order_id ?: $order->getKey() }}</div>
                            <div>Total: {{ number_format((float)$order->order_total, 2) }}</div>
                            <a href="{{ route('naxas.restaurantops.table-sessions.bill', $session->getKey()) }}" class="btn btn-sm btn-primary mt-2">View bill</a>
                        @else
                            <div>Available for dine-in</div>
                        @endif
                    </article>
                @empty
                    <p>No tables configured on this floor.</p>
                @endforelse
            </div>
        </section>
    @endforeach
</div>

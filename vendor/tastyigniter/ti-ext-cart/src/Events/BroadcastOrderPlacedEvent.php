<?php

declare(strict_types=1);

namespace Igniter\Cart\Events;

use Igniter\Cart\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class BroadcastOrderPlacedEvent implements ShouldBroadcast
{
    use Queueable;
    use SerializesModels;

    public function __construct(public Order $order) {}

    public function broadcastOn(): array
    {
        return [new Channel('igniter.order-placed.'.$this->order->location_id)];
    }

    public function broadcastAs(): string
    {
        return 'cart.order-placed';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->order->order_id,
            'type' => $this->order->order_type_name,
            'dateTime' => day_elapsed($this->order->order_date_time),
            'locationName' => $this->order->location ? $this->order->location->location_name : '',
            'items' => $this->order->menus->map(fn($item): string => $item->quantity.' x '.$item->name)->join('<br>'),
            'total' => $this->order->getOrderTotals()
                ->filter(fn($total): bool => $total->code == 'total')
                ->map(fn($total): string => currency_format($total->value))
                ->first(),
        ];
    }
}

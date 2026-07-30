---
title: "Broadcast"
section: "extensions"
sortOrder: 30
---

## Installation

You can install the extension via composer using the following command:

```bash
composer require tastyigniter/ti-ext-broadcast -W
```

By default, the extension registers the `/broadcasting/auth` route to handle authorization requests

## Getting started

1. From your TastyIgniter Admin, navigate to _Manage > Settings > Broadcast Settings_ to configure the extension. You will need to enter your Pusher App ID, Pusher Key, and Pusher Secret. Alternatively, you can use providers like [Ably](https://ably.com/) or [Laravel Reverb](https://laravel.com/docs/reverb) for broadcasting.
2. You must configure and run a queue worker to process broadcast jobs. You can read more about this in the [Queue worker section of the TastyIgniter installation documentation](https://tastyigniter.com/docs/installation#setting-up-the-queue-daemon).

## Usage

This section covers how to integrate the Broadcast extension into your own extension if you need to send or receive real-time events. The Broadcast extension provides a simple API for broadcasting custom events, listening to system events, and handling authorization for private channels. You can use it to notify users or staff of updates, synchronize data across clients, or trigger actions in real time.

The Broadcast extension handles authorisation for the following broadcast channels:

- `main.users.{userId}`: A private channel for broadcasting events to a specific customer.
- `admin.users.{userId}`: A private channel for broadcasting events to a specific staff member.

You can broadcast your custom events directly from your code, or you can broadcast other system events by [registering event broadcasts class](#registering-event-broadcasts).

### Defining broadcast events

To broadcast an event, you need to define an event broadcast class that implements the `Illuminate\Contracts\Broadcasting\ShouldBroadcast` interface. The event broadcast class should define a `broadcastOn` method that returns the channels the event should be broadcast on.

An event broadcast class is typically stored in the `src/Events` directory of your extension.

```php
namespace Author\Extension\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Queueable, SerializesModels;

    public function __construct(
        public Activity $activity
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin.users.'.$this->activity->user_id)
        ];
    }
}
```

In this example, the event is broadcast on a private channel named `admin.users.{userId}`.

For more details, refer to [Laravel's Defining Broadcast Events documentation](https://laravel.com/docs/broadcasting#defining-broadcast-events).

### Registering event broadcasts

Once you have defined an event broadcast class, you need to register the event broadcast class to be broadcast when a system event is fired. You can do this by defining a `registerEventBroadcasts` method on your extension class. The method should return an array of system event aliases and their corresponding event broadcast classes:

```php
public function registerEventBroadcasts()
{
    return [
        'igniter.cart.orderStatusAdded' => \Author\Extension\Events\OrderStatusUpdated::class,
    ];
}
```

In this example, the `OrderStatusUpdated` event will be broadcast when the `igniter.cart.orderStatusAdded` system event is fired.

### Broadcasting events

By default, TastyIgniter will automatically broadcast registered event classes when the associated system event is fired. However, you can also manually broadcast events using the event's `dispatch` method.

```php
use Author\Extensions\Events\OrderStatusUpdated;

OrderStatusUpdated::dispatch($activity);
```

### Receiving broadcasts

To receive broadcasts in your JavaScript code, you can use the `Broadcast` javascript object provided by TastyIgniter. You can listen for events on user authenticated channels or public channels.

You can listen for events on user authenticated channels or public channels as follows:

```javascript
// User Authenticated Channel
Broadcast.user()
    .listen(eventName, (e) => {
        console.log(e);
    })

// Public Channel
Broadcast.channel('channelName')
    .listen('eventName', (e) => {
        console.log(e);
    })
```


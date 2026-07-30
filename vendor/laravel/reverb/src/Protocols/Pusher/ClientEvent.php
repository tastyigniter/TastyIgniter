<?php

namespace Laravel\Reverb\Protocols\Pusher;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Reverb\Contracts\Connection;
use Laravel\Reverb\Protocols\Pusher\Contracts\ChannelManager;

class ClientEvent
{
    /**
     * Handle a Pusher client event.
     */
    public static function handle(Connection $connection, array $event): void
    {
        Validator::make($event, [
            'event' => ['required', 'string'],
            'channel' => ['required', 'string'],
            'data' => ['nullable', 'array'],
        ])->validate();

        if (! Str::startsWith($event['event'], 'client-')) {
            return;
        }

        if (! isset($event['channel'])) {
            return;
        }

        $acceptClientEventsFrom = $connection->app()->acceptClientEventsFrom();

        if (! in_array($acceptClientEventsFrom, ['all', 'members'])) {
            // Client events are disabled, so we should reject the event...
            $connection->send(json_encode([
                'event' => 'pusher:error',
                'data' => json_encode([
                    'code' => 4301,
                    'message' => 'The app does not have client messaging enabled.',
                ]),
            ]));

            return;
        }

        $rebroadcastEvent = $event;

        if ($acceptClientEventsFrom == 'members') {
            $channel = app(ChannelManager::class)->find($event['channel']);

            $channelConnection = $channel?->find($connection);

            if (! $channelConnection) {
                $connection->send(json_encode([
                    'event' => 'pusher:error',
                    'data' => json_encode([
                        'code' => 4009,
                        'message' => 'The client is not a member of the specified channel.',
                    ]),
                ]));

                return;
            }

            // Regenerate event payload, ensuring we only include the expected fields and the authenticated user_id...
            $rebroadcastEvent = [
                'event' => $event['event'],
                'channel' => $event['channel'],
                'data' => $event['data'] ?? null,
            ];

            if ($userId = $channelConnection->data('user_id')) {
                // Because public channels allow unauthenticated users, we may not have a user ID...
                $rebroadcastEvent['user_id'] = $userId;
            }
        }

        self::whisper(
            $connection,
            $rebroadcastEvent
        );
    }

    /**
     * Whisper a message to all connections on the channel associated with the event.
     */
    public static function whisper(Connection $connection, array $payload): void
    {
        EventDispatcher::dispatch(
            $connection->app(),
            $payload,
            $connection
        );
    }
}

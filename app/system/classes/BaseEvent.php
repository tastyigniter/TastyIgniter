<?php

namespace System\Classes;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use System\Traits\DispatchesLegacyEvent;

/**
 * Base Event Class
 */
class BaseEvent
{
    use Dispatchable, DispatchesLegacyEvent, InteractsWithSockets, SerializesModels;

    public function __construct()
    {

    }
}

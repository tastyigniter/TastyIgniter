<?php

namespace Main\Events\Template;

use Event;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FillViewBagArray
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
        // deprecate on next major release
        Event::fire('templateModel.fillViewBagArray');
    }
}

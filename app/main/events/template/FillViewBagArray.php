<?php

namespace Main\Events\Template;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use System\Traits\DispatchesLegacyEvent;

class FillViewBagArray
{
    use Dispatchable, DispatchesLegacyEvent, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
        $this->fireBackwardsCompatibleEvent('templateModel.fillViewBagArray');
    }
}

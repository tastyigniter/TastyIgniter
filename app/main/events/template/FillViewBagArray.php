<?php

namespace Main\Events\Template;

use Igniter\Flame\Events\BaseEvent;

class FillViewBagArray extends BaseEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
        $this->fireBackwardsCompatibleEvent('templateModel.fillViewBagArray');
    }
}

<?php

namespace System\Traits;

use Event;

trait DispatchesLegacyEvent
{
    public function fireBackwardsCompatibleEvent($name, $params = null)
    {
        Event::fire($name, $params);
    }
}

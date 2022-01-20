<?php

namespace Main\Events\Template;

use System\Classes\BaseEvent;

class FillViewBagArray extends BaseEvent;
{
    public function __construct()
    {
        $this->fireBackwardsCompatibleEvent('templateModel.fillViewBagArray');
    }
}

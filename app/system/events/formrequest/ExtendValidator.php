<?php

namespace System\Events\FormRequest;

use System\Classes\BaseEvent;

class ExtendValidator extends BaseEvent
{
    public $dataHolder;

    public function __construct($dataHolder)
    {
        $this->dataHolder = $dataHolder;

        $this->fireBackwardsCompatibleEvent('system.formRequest.extendValidator', [$this->dataHolder]);
    }
}

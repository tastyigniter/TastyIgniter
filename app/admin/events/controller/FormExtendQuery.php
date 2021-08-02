<?php

namespace Admin\Events\Controller;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use System\Traits\DispatchesLegacyEvent;

class FormExtendQuery
{
    use Dispatchable, DispatchesLegacyEvent, InteractsWithSockets, SerializesModels;

    public $query;

    public function __construct($query)
    {
        $this->query = $query;

        $this->fireBackwardsCompatibleEvent('controller.form.extendQuery', [$this->query]);
    }
}

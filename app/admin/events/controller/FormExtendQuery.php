<?php

namespace Admin\Events\Controller;

use Igniter\Flame\Events\BaseEvent;

class FormExtendQuery extends BaseEvent
{
    public $query;

    public function __construct($query)
    {
        $this->query = $query;

        $this->fireBackwardsCompatibleEvent('controller.form.extendQuery', [$this->query]);
    }
}

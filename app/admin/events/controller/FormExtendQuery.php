<?php

namespace Admin\Events\Controller;

class FormExtendQuery extends Event
{
    public $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
}

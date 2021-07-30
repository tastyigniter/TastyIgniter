<?php

namespace Admin\Events\Controller;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FormExtendQuery
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
}

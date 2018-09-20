<?php namespace Igniter\Demo\Components;

use System\Classes\BaseComponent;

class Block extends BaseComponent
{
    public function onRun()
    {
        $this->page['code'] = $code = $this->property('code');
        $this->page['title'] = $this->property('title', $code);
    }
}
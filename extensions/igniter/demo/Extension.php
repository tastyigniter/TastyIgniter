<?php

namespace Igniter\Demo;

use Igniter\System\Classes\BaseExtension;

class Extension extends BaseExtension
{
    public function registerComponents()
    {
        return [
            \Igniter\Demo\Components\Block::class => [
                'code' => 'block',
                'name' => 'lang:igniter.demo::default.text_component_title',
                'description' => 'lang:igniter.demo::default.text_component_desc',
            ],
        ];
    }
}

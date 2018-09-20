<?php namespace Igniter\Demo;

use System\Classes\BaseExtension;

class Extension extends BaseExtension
{
    public function registerComponents()
    {
        return [
            'Igniter\Demo\Components\Block' => [
                'code' => 'block',
                'name' => 'lang:igniter.demo::default.text_component_title',
                'description' => 'lang:igniter.demo::default.text_component_desc',
            ],
        ];
    }
}
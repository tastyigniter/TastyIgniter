<?php namespace Demo;

use System\Classes\BaseExtension;

class Extension extends BaseExtension
{
    public function registerComponents()
    {
        return [
            'Demo\Components\Block' => [
                'code'        => 'block',
                'name'        => 'lang:demo::default.text_component_title',
                'description' => 'lang:demo::default.text_component_desc',
            ],
        ];
    }
}
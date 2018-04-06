<?php namespace IgniterLab\Demo;

use System\Classes\BaseExtension;

class Extension extends BaseExtension
{
    public function registerComponents()
    {
        return [
            'IgniterLab\Demo\Components\Block' => [
                'code'        => 'block',
                'name'        => 'lang:demo::default.text_component_title',
                'description' => 'lang:demo::default.text_component_desc',
            ],
        ];
    }
}
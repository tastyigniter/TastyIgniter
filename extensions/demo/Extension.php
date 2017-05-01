<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
namespace Demo;

if (!defined('BASEPATH')) exit('No direct access allowed');

class Extension extends \Igniter\Core\BaseExtension
{

    public function registerComponents()
    {
        return [
            'demo/components/Demo' => [
                'code'        => 'demo',
                'name'        => 'lang:demo.text_component_title',
                'description' => 'lang:demo.text_component_desc',
            ],
        ];
    }
}

/* End of file Extension.php */
/* Location: ./extensions/demo/Extension.php */
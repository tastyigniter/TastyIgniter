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
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * System Hooks class for TastyIgniter.
 *
 * Provides methods to hook into TastyIgniter Core.
 */
class System
{

    public function preSystem()
    {
        // No longer supported due to the changes to uri routing
        if (config_item('enable_query_strings'))
            show_error("'enable_query_strings' config option is no longer supported.");
    }

    /**
     * Method to call before loading Router Class
     *
     */
    public function preRouter()
    {
        // Initialize all valid extension within the extension folder
        Modules::initialize();
    }

    public function preController()
    {
    }

    /**
     *
     */
    public function postControllerConstructor()
    {
        $this->replaceNavMenuItem();
    }

    /**
     *
     */
    public function postController()
    {
    }

    public function displayOverride()
    {
    }

    public function postSystem()
    {
    }

    protected function replaceNavMenuItem()
    {
        $CI =& get_instance();

        if (!isset($CI->load->controller) OR !$CI->load->controller instanceof Admin_Controller)
            return;

        // Change nav menu if single location mode is activated
        if ((is_object($CI->user) AND $CI->user->isStrictLocation()) OR $CI->config->item('site_location_mode') === 'single') {
            $CI->template->removeNavMenuItem('locations', 'restaurant');

            $CI->template->addNavMenuItem('locations', [
                'priority' => '1',
                'class' => 'locations',
                'href' => site_url('locations/edit'),
                'title' => lang('menu_setting'),
                'permission' => 'Admin.Locations'
            ], 'restaurant');
        }
    }
}

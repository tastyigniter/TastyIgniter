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
 * Main Controller Class
 *
 * @category       Libraries
 * @package        Igniter\Core\Main_Controller.php
 * @link           http://docs.tastyigniter.com
 */
class Main_Controller extends BaseController
{
    protected static $showMaintenance = TRUE;

	/**
	 * Class constructor
	 *
	 */
	public function __construct() {
        // autoload libraries
        $this->libraries = array_merge([
            'form_validation',
            'permalink',
            'template',
            'customer',
            'customer_online',
            'location'
        ], $this->libraries);

        // autoload models
        $this->models = array_merge([
            'Extensions_model', 'Pages_model'
        ], $this->models);

        parent::__construct();

        Events::trigger('before_main_controller');

		$this->form_validation->CI =& $this;

		if (!isset($this->index_url)) $this->index_url = $this->controller;

		if (!empty($this->filter)) $this->setFilter();
		if (!empty($this->sort)) $this->setSort();


        log_message('info', 'Main Controller Class Initialized');
	}
}

/* End of file Main_Controller.php */
/* Location: ./system/tastyigniter/core/Main_Controller.php */
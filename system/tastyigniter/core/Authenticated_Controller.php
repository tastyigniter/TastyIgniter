<?php
/**
 * Copyright (c) 2016. Igniter Labs
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Authenticated Controller Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\Authenticated_Controller.php
 * @link           http://docs.tastyigniter.com
 */
class Authenticated_Controller extends Base_Controller
{
	protected $authentication = TRUE;

	/**
	 * Class constructor
	 *
	 */
	public function __construct() {
		$this->libraries[] = 'user';

		parent::__construct();

		log_message('info', 'Authenticated Controller Class Initialized');

	}
}

/* End of file Authenticated_Controller.php */
/* Location: ./system/tastyigniter/core/Authenticated_Controller.php */
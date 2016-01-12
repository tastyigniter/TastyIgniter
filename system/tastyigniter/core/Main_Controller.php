<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main Controller Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\Main_Controller.php
 * @link           http://docs.tastyigniter.com
 */
class Main_Controller extends Base_Controller {

    /**
     * Class constructor
     *
     */
	public function __construct()
	{
        parent::__construct();

		log_message('info', 'Main Controller Class Initialized');

        $this->load->library('template');

        // Load permalink
        $this->load->library('permalink');

        $this->load->library('customer');

        $this->load->library('customer_online');

        $this->load->model('Pages_model');

		$this->load->library('location');

        // Set default theme
        if ($default_theme = $this->config->item(MAINDIR, 'default_themes')) {
            $this->template->setTheme($default_theme);
        }
    }
}

/* End of file Main_Controller.php */
/* Location: ./system/tastyigniter/core/Main_Controller.php */
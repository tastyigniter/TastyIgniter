<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Extensions Controller Class
 *
 */
class Ext_Controller extends Base_Controller {

	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{
        parent::__construct();

		log_message('info', 'Extensions Controller Class Initialized');

        $this->load->library('template');

        if (class_exists('admin_'.$this->router->fetch_module(), FALSE)) {
            $this->load->library('user');
        }

		$this->load->model('Extensions_model');
	}
}

/* End of file Ext_Controller.php */
/* Location: ./system/tastyigniter/core/Ext_Controller.php */
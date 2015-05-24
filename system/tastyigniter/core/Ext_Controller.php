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

        if ($this->router AND $_module = $this->router->fetch_module()) {
            $this->config->load($_module.'/'.$_module, TRUE);
            $config = $this->config->item($_module);

            if (!isset($config['ext_type']) OR !in_array($config['ext_type'], array('module', 'payment', 'widget'))) {
                show_error('Check that the extension ['.$_module.'] configuration type key is correctly set');
            }

            if (class_exists('admin_' . $_module, FALSE)) {
                $this->load->library('user');

                if (!isset($config['admin_options']) OR !is_bool($config['admin_options'])) {
                    show_error('Check that the extension ['.$_module.'] configuration admin_options key is correctly set');
                }
            }
        }

        $this->load->library('template');

        $this->load->library('extension');
    }
}

/* End of file Ext_Controller.php */
/* Location: ./system/tastyigniter/core/Ext_Controller.php */
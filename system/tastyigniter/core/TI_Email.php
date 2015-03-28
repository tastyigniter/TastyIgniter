<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Email Libary Class Extension
 *
 */
class TI_Email extends CI_Email {

	/**
	 * Constructor - Sets Email Preferences
	 *
	 * The constructor can be passed an array of config values
	 *
	 * @param	array	$config = array()
	 * @return	void
	 */
	public function __construct($config = array())
	{
		$this->charset = config_item('charset');
		if (count($config) > 0)
		{
			$this->initialize($config);
		}
		else
		{
			$this->_smtp_auth = ! ($this->smtp_user === '' && $this->smtp_pass === '');
		}

		$this->_safe_mode = ( ! is_php('5.4') && ini_get('safe_mode'));
		$this->charset = strtoupper($this->charset);

		log_message('debug', 'Email Class Initialized');
	}

}

/* End of file Ext_Controller.php */
/* Location: ./system/tastyigniter/core/Ext_Controller.php */
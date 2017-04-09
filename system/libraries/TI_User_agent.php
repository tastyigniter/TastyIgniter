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
 * TastyIgniter User agent Class
 *
 * @category       Libraries
 * @package        Igniter\Libraries\TI_User_agent.php
 * @link           http://docs.tastyigniter.com
 */
class TI_User_agent extends CI_User_agent
{

	/**
	 * Compile the User Agent Data
	 *
	 * @return    bool
	 */
	protected function _load_agent_file()
	{
		if (($found = file_exists(ROOTPATH.'config/user_agents.php'))) {
			include(ROOTPATH.'config/user_agents.php');
		}

		if (file_exists(ROOTPATH.'config/' . ENVIRONMENT . '/user_agents.php')) {
			include(ROOTPATH.'config/' . ENVIRONMENT . '/user_agents.php');
			$found = TRUE;
		}

		if ($found !== TRUE) {
			return FALSE;
		}

		$return = FALSE;

		if (isset($platforms)) {
			$this->platforms = $platforms;
			unset($platforms);
			$return = TRUE;
		}

		if (isset($browsers)) {
			$this->browsers = $browsers;
			unset($browsers);
			$return = TRUE;
		}

		if (isset($mobiles)) {
			$this->mobiles = $mobiles;
			unset($mobiles);
			$return = TRUE;
		}

		if (isset($robots)) {
			$this->robots = $robots;
			unset($robots);
			$return = TRUE;
		}

		return $return;
	}

	// --------------------------------------------------------------------
}

/* End of file User_agent.php */
/* Location: ./system/tastyigniter/libraries/User_agent.php */
<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class System {
	
	public function setupHook() {
		if (is_dir(EXTPATH .'setup/') AND file_exists(EXTPATH .'setup/')) {
			$db_data = array();
			if (is_file(APPPATH.'config/database.php')) {
				include(APPPATH.'config/database.php');
			}

			$db_data = ( ! isset($db) OR ! is_array($db)) ? array() : $db;
			unset($db);
		
			$db_user 	= $db_data['default']['username'];
			$db_pass 	= $db_data['default']['password'];
			$db_host 	= $db_data['default']['hostname'];
			$db_name	= $db_data['default']['database'];
			$db_prefix	= $db_data['default']['dbprefix'];
		
			$db_check = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);
			if (mysqli_connect_error() OR $db_check === FALSE) {
				show_error('Database connection was unsuccessful, please make sure the database server, username and password is correct.');
			}

			define('TI_SETUP', 'directory_found');
			if (!in_array('setup', explode('/', $_SERVER["REQUEST_URI"]))) {
				header('Location: setup');
				exit;
			}
		} else {
			define('TI_SETUP', 'installed');
		}
	}
}

// END System Class

/* End of file System.php */
/* Location: ./application/libraries/System.php */
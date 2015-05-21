<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Class Extension
 *
 * Global Variables
 * module_name
 * data
 */
class Extension {
	private static $name;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('Extensions_model');
    }

    public function setModule($extension = array()) {}

    function options($name) {

		self::$name = $name;

		$args = func_get_args();

		$ext_path = ROOTPATH.EXTPATH.$name.'/controllers/admin_options.php';

		if (file_exists($ext_path)) {
			require_once $ext_path;
			$class = 'Admin_options';

			//set GET extension_id value
			if (isset($args[1]['extension_id'])) {
				$_GET['extension_id'] = $args[1]['extension_id'];
			}

			$admin_options = new $class();
			return call_user_func_array(array($admin_options, 'options'), array_slice($args, 1));
		}
	}

	function render($data = array()) {

		extract($data);
		$ext_path = ROOTPATH.EXTPATH.self::$name.'/views/admin_options.php';

		if (file_exists($ext_path)) {
			include $ext_path;
		}
	}

	function load($object) {

		$this->$object =& load_class(ucfirst($object));
	}


    public function __get($name) {
        return isset($this->{$name}) ? $this->{$name} : NULL;
    }

//	function __get($var) {
//
//		static $ci;
//		isset($ci) OR $ci = get_instance();
//		return $ci->$var;
//	}
}

// END Extension Class

/* End of file Extension.php */
/* Location: ./system/tastyigniter/libraries/Extension.php */
<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class TI_Loader extends MX_Loader {
    public function __construct() {
        parent::__construct();
    }
    
    public function controller($site, $file_name) {
        $CI = & get_instance();
      
        $file_path = APPPATH.'controllers/'.$site.$file_name.'.php';
        $object_name = $file_name;
        $class_name = ucfirst($file_name);
      
        if (file_exists($file_path)) {
            require_once $file_path;
          
            $CI->$object_name = new $class_name();
        } else {
            show_error("Unable to load the requested controller class: ".$class_name);
        }
    }
}

/* End of file TI_loader.php */
/* Location: ./application/core/TI_loader.php */
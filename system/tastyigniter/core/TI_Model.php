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
 * TastyIgniter Model Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\TI_Model.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Model extends CI_Model {

    public function __construct($config = array())
    {
        $class = str_replace($this->config->item('subclass_prefix'), '', get_class($this));
        log_message('info', $class . '  Model Class Initialized');
    }
}

/* End of file TI_Model.php */
/* Location: ./system/tastyigniter/core/TI_Model.php */
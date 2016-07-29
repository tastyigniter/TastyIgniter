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
 * @since     File available since Release 2.2
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Mail template data Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Mail_templates_data_model.php
 * @link           http://docs.tastyigniter.com
 */
class Mail_templates_data_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'mail_templates_data';

	protected $primary_key = 'templates_data_id';

}

/* End of file Mail_templates_data_model.php */
/* Location: ./system/tastyigniter/models/Mail_templates_data_model.php */
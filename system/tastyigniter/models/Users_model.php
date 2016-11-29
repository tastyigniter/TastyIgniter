<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package       TastyIgniter
 * @author        SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link          http://tastyigniter.com
 * @license       http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since         File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

use TastyIgniter\Database\Model;

/**
 * Users Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Users_model.php
 * @link           http://docs.tastyigniter.com
 */
class Users_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'users';

	protected $primaryKey = 'user_id';
}

/* End of file Users_model.php */
/* Location: ./system/tastyigniter/models/Users_model.php */
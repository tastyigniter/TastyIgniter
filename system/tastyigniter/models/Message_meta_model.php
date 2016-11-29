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
 * Message Meta Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Message_meta_model.php
 * @link           http://docs.tastyigniter.com
 */
class Message_meta_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'message_meta';

	protected $primaryKey = 'message_meta_id';

	protected $fillable = ['message_meta_id', 'message_id', 'state', 'status', 'deleted', 'item', 'value'];

}

/* End of file Message_meta_model.php */
/* Location: ./system/tastyigniter/models/Message_meta_model.php */
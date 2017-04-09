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
defined('BASEPATH') or exit('No direct script access allowed');

use Igniter\Database\Model;

/**
 * Message Meta Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Message_meta_model.php
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
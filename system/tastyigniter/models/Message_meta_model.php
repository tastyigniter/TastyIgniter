<?php
/**
 * Copyright (c) 2016. Igniter Labs
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Message Meta Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Message_meta_model.php
 * @link           http://docs.tastyigniter.com
 */
class Message_meta_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'message_meta';

	protected $primary_key = 'message_meta_id';
}

/* End of file Message_meta_model.php */
/* Location: ./system/tastyigniter/models/Message_meta_model.php */
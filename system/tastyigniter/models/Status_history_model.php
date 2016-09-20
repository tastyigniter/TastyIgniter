<?php
/**
 * Copyright (c) 2016. Igniter Labs
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Status History Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Status_history_model.php
 * @link           http://docs.tastyigniter.com
 */
class Status_history_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'status_history';
	
	protected $primary_key = 'status_history_id';

	protected $belongs_to = array(
		'staffs' => 'Staffs_model',
		'statuses' => array('Statuses_model', 'status_id'),
	);

	protected $timestamps = array('created');

}

/* End of file Status_history_model.php */
/* Location: ./system/tastyigniter/models/Status_history_model.php */
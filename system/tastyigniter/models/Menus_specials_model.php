<?php
/**
 * Copyright (c) 2016. Igniter Labs
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Menu Specials Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Menus_specials_model.php
 * @link           http://docs.tastyigniter.com
 */
class Menus_specials_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'menus_specials';

	protected $primary_key = 'special_id';

	protected $casts = array(
		'start_date' => 'date',
		'end_date'   => 'date',
	);
}

/* End of file Menus_specials_model.php */
/* Location: ./system/tastyigniter/models/Menus_specials_model.php */
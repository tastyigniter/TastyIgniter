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
 * Mail template data Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Mail_templates_data_model.php
 * @link           http://docs.tastyigniter.com
 */
class Mail_templates_data_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'mail_templates_data';

	protected $primaryKey = 'template_data_id';

	protected $fillable = ['code', 'subject', 'body'];

	/**
	 * @var array The model table column to convert to dates on insert/update
	 */
	public $timestamps = TRUE;

	const CREATED_AT = 'date_added';

	const UPDATED_AT = 'date_updated';

	public function getBodyAttribute($value)
	{
		return html_entity_decode($value);
	}

	public function setBodyAttribute($value)
	{
		$this->attributes['body'] = preg_replace('~>\s+<~m', '><', $value);
	}

	public function formatDateTime($value)
	{
		return mdate('%d %M %y - %H:%i', strtotime($value));
	}

    /**
     * Find a single mail template by template id and code
     *
     * @param $template_id
     * @param $template_code
     *
     * @return mixed
     */
    public function getTemplateData($template_id, $template_code)
    {
        if (is_numeric($template_id) AND is_string($template_code)) {
            $query = $this->where('mail_templates.template_id', $template_id)
                          ->leftJoin('mail_templates', 'mail_templates.template_id', '=', 'mail_templates_data.template_id')
                          ->where('code', $template_code)
                          ->where('mail_templates.status', '1');

            return $query->first();
        }
    }

}

/* End of file Mail_templates_data_model.php */
/* Location: ./system/tastyigniter/models/Mail_templates_data_model.php */
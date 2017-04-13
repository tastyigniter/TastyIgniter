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
 * Mail_templates Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Mail_templates_model.php
 * @link           http://docs.tastyigniter.com
 */
class Mail_templates_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'mail_templates';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'template_id';

	protected $fillable = ['template_id', 'name', 'language_id', 'date_added', 'date_updated', 'status'];

	/**
	 * @var array The model table column to convert to dates on insert/update
	 */
	public $timestamps = TRUE;

	const CREATED_AT = 'date_added';

	const UPDATED_AT = 'date_updated';

    public $defaultTemplateId = 11;

	/**
	 * Scope a query to only include enabled mail template
	 *
	 * @return $this
	 */
	public function scopeIsEnabled($query)
	{
		return $query->where('status', '1');
	}

	/**
	 * Return all mail templates
	 *
	 * @return array
	 */
	public function getTemplates()
	{
		return $this->getAsArray();
	}

	/**
	 * Find a single mail template by template_id
	 *
	 * @param $template_id
	 *
	 * @return bool
	 */
	public function getTemplate($template_id)
	{
		return $this->findOrNew($template_id)->toArray();
	}

	/**
	 * Return all mail templates data by template_id
	 *
	 * @param $template_id
	 *
	 * @return array
	 */
	public function getAllTemplateData($template_id)
	{
		$result = [];

		if ($template_id) {
			$this->load->model('Mail_templates_data_model');
			$result = $this->Mail_templates_data_model->where('template_id', $template_id)
													  ->orderBy('template_data_id')->getAsArray();
		}

		return $result;
	}

    /**
     * Find the default mail template by template code
     *
     * @param $template_code
     *
     * @return mixed
     */
    public function getDefaultTemplateData($template_code)
    {
        $this->load->model('Mail_templates_data_model');
        $template_id = $this->config->item('mail_template_id');
        $found = $this->Mail_templates_data_model->getTemplateData($template_id, $template_code);

        if (!$found)
            $template_id = $this->defaultTemplateId;

        return $this->getTemplateData($template_id, $template_code);
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
			$this->load->model('Mail_templates_data_model');
			$query = $this->Mail_templates_data_model->leftJoin('mail_templates', 'mail_templates.template_id', '=', 'mail_templates_data.template_id');
			$query->where('mail_templates_data.template_id', $template_id);
			$query->where('mail_templates_data.code', $template_code);
			$query->where('mail_templates.status', '1');

			return $query->firstAsArray();
		}
	}

	/**
	 * Create a new or update existing mail template
	 *
	 * @param       $template_id
	 * @param array $save
	 *
	 * @return bool|int The $template_id of the affected row, or FALSE on failure
	 */
	public function saveTemplate($template_id, $save = [])
	{
		if (empty($save)) return FALSE;

		$templateModel = $this->findOrNew($template_id);

		$saved = $templateModel->fill($save)->save();

		if ($saved AND $template_id = $templateModel->getKey()) {

			$templates = (!empty($save['clone_template_id'])) ? $this->getAllTemplateData($save['clone_template_id']) : $save['templates'];

			$this->updateTemplateData($template_id, $templates);

			return $template_id;
		}
	}

	/**
	 * Create a new or update existing mail template data
	 *
	 * @param       $template_id
	 * @param array $templates
	 *
	 * @return bool TRUE on success, or FALSE on failure
	 */
	public function updateTemplateData($template_id, $templates = [])
	{
		$query = FALSE;

		if (empty($template_id) OR empty($templates)) return FALSE;

		$this->load->model('Mail_templates_data_model');

		foreach ($templates as $template) {
			$templateDataModel = $this->Mail_templates_data_model
				->firstOrNew(['template_id' => $template_id, 'code' => $template['code']]);

			$query = $templateDataModel->fill(array_merge($template, [
				'template_id' => $template_id, 'code' => $template['code'],
			]))->save();
		}

		return $query;
	}

	/**
	 * Delete a single or multiple mail template by template_id
	 *
	 * @param $template_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteTemplate($template_id)
	{
		if (is_numeric($template_id)) $template_id = [$template_id];

		foreach ($template_id as $key => $value) {
			if ($value == $this->config->item('mail_template_id')) {
				unset($template_id[$key]);
			}
		}

		if (!empty($template_id) AND ctype_digit(implode('', $template_id))) {
			$affected_rows = $this->where('template_id', '!=', '11')->whereIn('template_id', $template_id)->delete();

			if ($affected_rows > 0) {
				$this->load->model('Mail_templates_data_model');

				$this->Mail_templates_data_model->where('template_id', '!=', '11')
												->whereIn('template_id', $template_id)->delete();

				return $affected_rows;
			}
		}
	}
}

/* End of file Mail_templates_model.php */
/* Location: ./system/tastyigniter/models/Mail_templates_model.php */
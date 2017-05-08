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

    protected $fillable = ['template_id', 'code', 'label', 'subject', 'body'];

    protected $appends = ['title'];

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = TRUE;

    const CREATED_AT = 'date_added';

    const UPDATED_AT = 'date_updated';

    public function getTitleAttribute($value)
    {
        $langLabel = !empty($this->attributes['label']) ? $this->attributes['label'] : '--';

        return (sscanf($langLabel, 'lang:%s', $lang) === 1) ? lang($langLabel) : $langLabel;
    }

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

    /**
     * Fetch changes from the system default mail template
     * used to update cloned mail templates
     *
     * @param int $templateId
     *
     * @return array|bool array on success, FALSE on failure
     */
    public function fetchChanges($templateId)
    {
        $this->load->model('Mail_templates_model');
        $defaultTemplateId = $this->Mail_templates_model->defaultTemplateId;
        if (!is_numeric($templateId) OR $templateId == $defaultTemplateId)
            return FALSE;

        $mainTemplates = $this->newQuery()->where('template_id', $defaultTemplateId)->get();
        $defaultTemplates = $this->newQuery()->where('template_id', $templateId)->get();

        $mailChanges = [];
        foreach ($mainTemplates as $mainTemplate) {
            $defaultTemplate = $defaultTemplates->where('code', $mainTemplate->code)->first();
            if (!count($defaultTemplate))
                $mailChanges['new'][] = $mainTemplate;

            if (count($defaultTemplate) === 1 AND $this->diffTemplateData($mainTemplate, $defaultTemplate))
                $mailChanges['modified'][] = $mainTemplate;
        }

        foreach ($defaultTemplates as $defaultTemplate) {
            $mainTemplate = $mainTemplates->where('code', $defaultTemplate->code)->first();
            if (!count($mainTemplate))
                $mailChanges['deleted'][] = $defaultTemplate;
        }

        return $mailChanges ? array_replace(array_flip(['new', 'modified', 'deleted']), $mailChanges) : $mailChanges;
    }

    /**
     * Check difference in two template data
     *
     * @param $one
     * @param $two
     *
     * @return bool
     */
    public function diffTemplateData($one, $two)
    {
        if (strtotime($one->date_updated) > strtotime($two->date_added))
            return TRUE;

        return FALSE;
    }

    /**
     * Update changes from the system default mail templates
     *
     * @param $template_id
     * @param $update
     *
     * @return bool
     */
    public function updateChanges($template_id, $update)
    {
        if (empty($update) OR !isset($update['changes'])) return FALSE;

        $templatesToUpdate = $templatesToDelete = [];
        foreach ($update['changes'] as $key => $templates) {
            foreach ($templates as $template_data_id => $template) {
                if (!isset($template['update']) OR $template_data_id != $template['update'])
                    continue;

                if ($key == 'deleted') {
                    $templatesToDelete[] = $this->destroy($template_data_id);
                } else {
                    unset($template['update']);
                    $templatesToUpdate[] = $template;
                }
            }
        }

        $this->updateTemplateData($template_id, $templatesToUpdate);
        return count($templatesToUpdate) OR count($templatesToDelete);
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

        foreach ($templates as $template) {
            $templateDataModel = $this->firstOrNew(['template_id' => $template_id, 'code' => $template['code']]);

            $query = $templateDataModel->fill(array_merge($template, [
                'template_id' => $template_id,
                'code' => $template['code'],
                'body' => trim($template['body']),
            ]))->save();
        }

        return $query;
    }

    /**
     * Add extension registered mail templates
     *
     * @param array $mailTemplates
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function addMailTemplateData($mailTemplates)
    {
        if (!is_array($mailTemplates))
            return FALSE;

        $this->load->model('Mail_templates_model');
        $defaultTemplateId = $this->Mail_templates_model->defaultTemplateId;

        foreach ($mailTemplates as $mailPath => $mailTemplate) {
            if (!is_string($mailPath) OR count($path = pathinfo($mailPath)) < 3) continue;

            $templateDataModel = $this->firstOrNew(['template_id' => $defaultTemplateId, 'code' => $mailPath]);

            $templateDataModel->fill([
                'label'   => $mailTemplate['label'],
                'subject' => $mailTemplate['subject'],
                'body'    => $this->load->view($mailPath),
            ])->save();
        }

        return TRUE;
    }

    /**
     * Delete extension registered mail templates
     *
     * @param array $mailTemplates
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function removeMailTemplateData($mailTemplates)
    {
        if (!is_array($mailTemplates))
            return FALSE;

        $this->load->model('Mail_templates_model');
        $defaultTemplateId = $this->Mail_templates_model->defaultTemplateId;

        foreach ($mailTemplates as $mailPath => $mailTemplate) {
            if (!is_string($mailPath) OR count($path = pathinfo($mailPath)) === 3) continue;

            $this->where('template_id', $defaultTemplateId)
                ->where('code', $mailPath)->delete();
        }

        return TRUE;
    }

}

/* End of file Mail_templates_data_model.php */
/* Location: ./system/tastyigniter/models/Mail_templates_data_model.php */
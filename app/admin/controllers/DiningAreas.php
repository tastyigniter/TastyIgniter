<?php

namespace Admin\Controllers;

use Admin\Facades\AdminMenu;
use Admin\Models\DiningTable;
use Igniter\Flame\Exception\ApplicationException;

/**
 * Admin Controller Class Dining Areas
 */
class DiningAreas extends \Admin\Classes\AdminController
{
    public $implement = [
        \Admin\Actions\ListController::class,
        \Admin\Actions\FormController::class,
        \Admin\Actions\LocationAwareController::class,
    ];

    public $listConfig = [
        'list' => [
            'model' => \Admin\Models\DiningArea::class,
            'title' => 'lang:admin::lang.dining_areas.text_title',
            'emptyMessage' => 'lang:admin::lang.dining_areas.text_empty',
            'defaultSort' => ['updated_at', 'DESC'],
            'configFile' => 'dining_area',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.dining_areas.text_form_name',
        'model' => \Admin\Models\DiningArea::class,
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'dining_areas/edit/{id}',
            'redirectClose' => 'dining_areas',
            'redirectNew' => 'dining_areas/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'dining_areas/edit/{id}',
            'redirectClose' => 'dining_areas',
            'redirectNew' => 'dining_areas/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'dining_areas',
        ],
        'delete' => [
            'redirect' => 'dining_areas',
        ],
        'configFile' => 'dining_area',
    ];

    protected $requiredPermissions = 'Admin.Tables';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('dining_areas', 'restaurant');
    }

    public function edit_onCreateCombo($context = null, $recordId = null)
    {
        $checked = (array)post('DiningArea._select_dining_tables', []);
        if (!$checked || count($checked) < 2)
            throw new ApplicationException(lang('admin::lang.dining_areas.alert_tables_not_checked'));

        $model = $this->asExtension('FormController')->formFindModelObject($recordId);

        $checkedTables = $model->dining_tables()->whereIn('id', $checked)->get();

        $model->createCombo($checkedTables);

        flash()->success(sprintf(lang('admin::lang.alert_success'), 'Table combo created'))->now();

        return $this->redirectBack();
    }

    public function listExtendQuery($query)
    {
        $query->with(['reservable_tables', 'dining_sections']);
    }

    public function formBeforeSave($model)
    {
        if (DiningTable::isBroken())
            DiningTable::fixTree();
    }
}

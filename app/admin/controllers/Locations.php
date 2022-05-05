<?php

namespace Admin\Controllers;

use Admin\Facades\AdminLocation;
use Admin\Facades\AdminMenu;
use Admin\Models\LocationOption;
use Admin\Models\Locations_model;
use Exception;
use Igniter\Flame\Geolite\Facades\Geocoder;

class Locations extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Locations_model',
            'title' => 'lang:admin::lang.locations.text_title',
            'emptyMessage' => 'lang:admin::lang.locations.text_empty',
            'defaultSort' => ['location_id', 'DESC'],
            'configFile' => 'locations_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.locations.text_form_name',
        'model' => 'Admin\Models\Locations_model',
        'request' => 'Admin\Requests\Location',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'locations/edit/{location_id}',
            'redirectClose' => 'locations',
            'redirectNew' => 'locations/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'locations/edit/{location_id}',
            'redirectClose' => 'locations',
            'redirectNew' => 'locations/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'locations',
        ],
        'delete' => [
            'redirect' => 'locations',
        ],
        'configFile' => 'locations_model',
    ];

    protected $requiredPermissions = 'Admin.Locations';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('locations', 'restaurant');
    }

    public function remap($action, $params)
    {
        if ($action != 'settings' && AdminLocation::check())
            return $this->redirect('locations/settings');

        return parent::remap($action, $params);
    }

    public function settings($context = null)
    {
        if (!AdminLocation::check())
            return $this->redirect('locations');

        $this->asExtension('FormController')->edit('edit', $this->getLocationId());
    }

    public function index_onSetDefault($context = null)
    {
        $defaultId = post('default');

        if (Locations_model::updateDefault($defaultId)) {
            flash()->success(sprintf(lang('admin::lang.alert_success'), lang('admin::lang.locations.alert_set_default')));
        }

        return $this->refreshList('list');
    }

    public function settings_onSave($context = null)
    {
        try {
            $this->asExtension('FormController')->edit_onSave('edit', $this->getLocationId());

            return $this->refresh();
        }
        catch (Exception $ex) {
            $this->handleError($ex);
        }
    }

    public function listOverrideColumnValue($record, $column, $alias = null)
    {
        if ($column->type != 'button')
            return null;

        if ($column->columnName != 'default')
            return null;

        $attributes = $column->attributes;
        $column->iconCssClass = 'fa fa-star-o';
        if ($record->getKey() == params('default_location_id')) {
            $column->iconCssClass = 'fa fa-star';
        }

        return $attributes;
    }

    public function listExtendQuery($query)
    {
        if (!is_null($ids = AdminLocation::getAll()))
            $query->whereIn('location_id', $ids);
    }

    public function formExtendQuery($query)
    {
        if (!is_null($ids = AdminLocation::getAll()))
            $query->whereIn('location_id', $ids);
    }

    public function formExtendFields($form)
    {
        if ($form->model->exists && $form->context != 'create') {
            $form->addTabFields(LocationOption::getFieldsConfig());
        }
    }

    public function getAccordionFields($fields)
    {
        return collect($fields)->mapToGroups(function ($field) {
            $key = array_get($field->config, 'accordion');

            return [$key => $field];
        })->all();
    }

    public function formAfterSave($model)
    {
        if (post('Location.options.auto_lat_lng')) {
            if ($logs = Geocoder::getLogs())
                flash()->error(implode(PHP_EOL, $logs))->important();
        }
    }

    public function mapViewCenterCoords()
    {
        $model = $this->getFormModel();

        return [
            'lat' => $model->location_lat,
            'lng' => $model->location_lng,
        ];
    }
}

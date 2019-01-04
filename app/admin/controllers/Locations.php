<?php namespace Admin\Controllers;

use Admin\Models\Locations_model;
use AdminAuth;
use AdminMenu;
use Exception;
use Geocoder;

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
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'locations/edit/{location_id}',
            'redirectClose' => 'locations',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'locations/edit/{location_id}',
            'redirectClose' => 'locations',
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
        if ($action != 'settings' AND $this->getUser() AND AdminAuth::isStrictLocation())
            return $this->redirect('locations/settings');

        return parent::remap($action, $params);
    }

    public function settings($context = null)
    {
        $this->asExtension('FormController')->edit('edit', params('default_location_id'));
    }

    public function index_onSetDefault($context = null)
    {
        $defaultId = post('default');

        if (Locations_model::updateDefault(['location_id' => $defaultId])) {
            flash()->success(sprintf(lang('admin::lang.alert_success'), lang('admin::lang.locations.alert_set_default')));
        }

        return $this->refreshList('list');
    }

    public function settings_onSave($context = null)
    {
        try {
            $this->asExtension('FormController')->edit_onSave('edit', params('default_location_id'));

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

    public function formExtendQuery($query)
    {
        if (is_single_location())
            $query->where('location_id', params('default_location_id'));
    }

    public function formValidate($model, $form)
    {
        $rules = [
            ['location_name', 'lang:admin::lang.locations.label_name', 'required|min:2|max:32'],
            ['location_email', 'lang:admin::lang.locations.label_email', 'required|email'],
            ['location_telephone', 'lang:admin::lang.locations.label_telephone', 'required|min:2|max:15'],
            ['location_address_1', 'lang:admin::lang.locations.label_address_1', 'required|min:2|max:128'],
            ['location_address_2', 'lang:admin::lang.locations.label_address_2', 'max:128'],
            ['location_city', 'lang:admin::lang.locations.label_city', 'min:2|max:128'],
            ['location_state', 'lang:admin::lang.locations.label_state', 'max:128'],
            ['location_postcode', 'lang:admin::lang.locations.label_postcode', 'min:2|max:10'],
            ['location_country_id', 'lang:admin::lang.locations.label_country', 'required|integer'],
            ['options.auto_lat_lng', 'lang:admin::lang.locations.label_auto_lat_lng', 'required|integer'],
            ['location_lat', 'lang:admin::lang.locations.label_latitude', 'numeric'],
            ['location_lng', 'lang:admin::lang.locations.label_longitude', 'numeric'],

            ['description', 'lang:admin::lang.locations.label_description', 'min:2|max:3028'],
            ['offer_delivery', 'lang:admin::lang.locations.label_offer_delivery', 'required|integer'],
            ['offer_collection', 'lang:admin::lang.locations.label_offer_collection', 'required|integer'],
            ['options.offer_reservation', 'lang:admin::lang.locations.label_offer_collection', 'required|integer'],
            ['delivery_time', 'lang:admin::lang.locations.label_delivery_time', 'integer'],
            ['collection_time', 'lang:admin::lang.locations.label_collection_time', 'integer'],
            ['last_order_time', 'lang:admin::lang.locations.label_last_order_time', 'integer'],
            ['options.future_orders', 'lang:admin::lang.locations.label_future_order', 'required|integer'],
            ['options.future_order_days.*', 'lang:admin::lang.locations.label_future_order_days', 'integer'],
            ['options.payments.*', 'lang:admin::lang.locations.label_payments'],

            ['tables.*', 'lang:admin::lang.locations.label_tables', 'integer'],
            ['reservation_time_interval', 'lang:admin::lang.locations.label_reservation_time_interval', 'integer'],
            ['reservation_stay_time', 'lang:admin::lang.locations.label_reservation_stay_time', 'integer'],
            ['location_status', 'lang:admin::lang.label_status', 'required|integer'],
            ['permalink_slug', 'lang:admin::lang.locations.label_permalink_slug', 'alpha_dash|max:255'],
        ];

        $requiredIf = 'required_if:options.hours.*.type,daily';
        $rules[] = ['options.hours.*.type', 'lang:admin::lang.locations.label_opening_type', 'alpha_dash|max:10'];
        $rules[] = ['options.hours.*.days.*', 'lang:admin::lang.locations.label_opening_days', 'integer'];
        $rules[] = ['options.hours.*.open', 'lang:admin::lang.locations.label_open_hour', $requiredIf.'|valid_time'];
        $rules[] = ['options.hours.*.close', 'lang:admin::lang.locations.label_close_hour', $requiredIf.'|valid_time'];

        $requiredIf = 'required_if:options.hours.*.type,flexible';
        $rules[] = ['options.hours.*.flexible.*.day', 'lang:admin::lang.locations.label_opening_days', $requiredIf.'|numeric'];
        $rules[] = ['options.hours.*.flexible.*.open', 'lang:admin::lang.locations.label_open_hour', $requiredIf.'|valid_time'];
        $rules[] = ['options.hours.*.flexible.*.close', 'lang:admin::lang.locations.label_close_hour', $requiredIf.'|valid_time'];
        $rules[] = ['options.hours.*.flexible.*.status', 'lang:admin::lang.locations.label_opening_status', $requiredIf.'|integer'];

        $rules[] = ['delivery_areas', 'lang:admin::lang.locations.text_delivery_area', 'required'];
        $rules[] = ['delivery_areas.*.type', 'lang:admin::lang.locations.label_area_type', 'required'];
        $rules[] = ['delivery_areas.*.name', 'lang:admin::lang.locations.label_area_name', 'required'];
        $rules[] = ['delivery_areas.*.area_id', 'lang:admin::lang.locations.label_area_id', 'integer'];

        $rules[] = ['delivery_areas.*.boundaries.components.*.type', 'lang:admin::lang.locations.label_address_component_type', 'sometimes|required|string'];
        $rules[] = ['delivery_areas.*.boundaries.components.*.value', 'lang:admin::lang.locations.label_address_component_value', 'sometimes|required|string'];

        $rules[] = ['delivery_areas.*.boundaries.polygon', 'lang:admin::lang.locations.label_area_shape', 'sometimes'];
        $rules[] = ['delivery_areas.*.boundaries.circle', 'lang:admin::lang.locations.label_area_circle', 'sometimes|json'];
        $rules[] = ['delivery_areas.*.boundaries.vertices', 'lang:admin::lang.locations.label_area_vertices', 'sometimes|json'];

        $rules[] = ['delivery_areas.*.conditions', 'lang:admin::lang.locations.label_delivery_condition', 'required'];
        $rules[] = ['delivery_areas.*.conditions.*.amount', 'lang:admin::lang.locations.label_area_charge', 'required|numeric'];
        $rules[] = ['delivery_areas.*.conditions.*.type', 'lang:admin::lang.locations.label_charge_condition', 'required|alpha_dash'];
        $rules[] = ['delivery_areas.*.conditions.*.total', 'lang:admin::lang.locations.label_area_min_amount', 'required|numeric'];

        $rules[] = ['gallery.title', 'lang:admin::lang.locations.label_gallery_title', 'max:128'];
        $rules[] = ['gallery.description', 'lang:admin::lang.locations.label_gallery_description', 'max:255'];

        return $this->validatePasses($form->getSaveData(), $rules);
    }

    public function formAfterSave($model)
    {
        if (post('Location.options.auto_lat_lng')) {
            if ($logs = Geocoder::getLogs())
                flash()->error(implode(PHP_EOL, $logs))->important();
        }
    }
}
<?php

declare(strict_types=1);

namespace Igniter\System\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Classes\ListColumn;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\System\Http\Requests\CountryRequest;
use Igniter\System\Models\Country;

/**
 * Controller Class Countries
 */
class Countries extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Country::class,
            'title' => 'lang:igniter::system.countries.text_title',
            'emptyMessage' => 'lang:igniter::system.countries.text_empty',
            'defaultSort' => ['country_name', 'ASC'],
            'configFile' => 'country',
            'back' => 'settings',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter::system.countries.text_form_name',
        'model' => Country::class,
        'request' => CountryRequest::class,
        'create' => [
            'title' => 'lang:igniter::admin.form.create_title',
            'redirect' => 'countries/edit/{country_id}',
            'redirectClose' => 'countries',
            'redirectNew' => 'countries/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'countries/edit/{country_id}',
            'redirectClose' => 'countries',
            'redirectNew' => 'countries/create',
        ],
        'preview' => [
            'title' => 'lang:igniter::admin.form.preview_title',
            'back' => 'countries',
        ],
        'delete' => [
            'redirect' => 'countries',
        ],
        'configFile' => 'country',
    ];

    protected null|string|array $requiredPermissions = 'Site.Countries';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('settings', 'system');
    }

    public function index_onSetDefault(?string $context)
    {
        $data = $this->validate(post(), [
            'default' => 'required|integer|exists:'.Country::class.',country_id',
        ]);

        if (Country::updateDefault($data['default'])) {
            flash()->success(sprintf(lang('igniter::admin.alert_success'), lang('igniter::system.countries.alert_set_default')));
        }

        return $this->asExtension(ListController::class)->refreshList('list');
    }

    public function listOverrideColumnValue(Country $record, ListColumn $column, ?string $alias = null): void
    {
        if ($column->type === 'button' && $column->columnName === 'default') {
            $column->iconCssClass = $record->isDefault() ? 'fa fa-star' : 'fa fa-star-o';
        }
    }
}

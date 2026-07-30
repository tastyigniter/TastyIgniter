<?php

declare(strict_types=1);

namespace Igniter\User\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\User\Http\Requests\CustomerGroupRequest;
use Igniter\User\Models\CustomerGroup;

/**
 * @mixin ListController
 * @mixin FormController
 */
class CustomerGroups extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => CustomerGroup::class,
            'title' => 'lang:igniter.user::default.customer_groups.text_title',
            'emptyMessage' => 'lang:igniter.user::default.customer_groups.text_empty',
            'defaultSort' => ['customer_group_id', 'DESC'],
            'configFile' => 'customergroup',
            'back' => 'customers',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.user::default.customer_groups.text_form_name',
        'model' => CustomerGroup::class,
        'request' => CustomerGroupRequest::class,
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'customer_groups/edit/{customer_group_id}',
            'redirectClose' => 'customer_groups',
            'redirectNew' => 'customer_groups/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'customer_groups/edit/{customer_group_id}',
            'redirectClose' => 'customer_groups',
            'redirectNew' => 'customer_groups/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'back' => 'customer_groups',
        ],
        'delete' => [
            'redirect' => 'customer_groups',
        ],
        'configFile' => 'customergroup',
    ];

    protected null|string|array $requiredPermissions = 'Admin.CustomerGroups';

    public static function getSlug(): string
    {
        return 'customer_groups';
    }

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('customers', 'users');
    }

    public function index_onSetDefault(): array
    {
        $data = $this->validate(post(), [
            'default' => 'required|integer|exists:'.CustomerGroup::class.',customer_group_id',
        ]);

        if (CustomerGroup::updateDefault($data['default'])) {
            flash()->success(sprintf(lang('admin::lang.alert_success'), lang('igniter.user::default.customer_groups.alert_set_default')));
        }

        return $this->refreshList('list');
    }

    public function listExtendQuery($query): void
    {
        $query->withCount('customers');
    }

    public function listOverrideColumnValue($record, $column, $alias = null)
    {
        if ($column->type != 'button') {
            return null;
        }

        if ($column->columnName != 'default') {
            return null;
        }

        $attributes = $column->attributes;
        $column->iconCssClass = 'fa fa-star-o';
        if ($record->isDefault()) {
            $column->iconCssClass = 'fa fa-star';
        }

        return $attributes;
    }
}

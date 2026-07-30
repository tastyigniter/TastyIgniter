<?php

declare(strict_types=1);

namespace Igniter\User\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\User\Http\Requests\UserGroupRequest;
use Igniter\User\Models\UserGroup;

/**
 * @mixin ListController
 * @mixin FormController
 */
class UserGroups extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => UserGroup::class,
            'title' => 'lang:igniter.user::default.user_groups.text_title',
            'emptyMessage' => 'lang:igniter.user::default.user_groups.text_empty',
            'defaultSort' => ['user_group_id', 'DESC'],
            'configFile' => 'usergroup',
            'back' => 'users',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.user::default.user_groups.text_form_name',
        'model' => UserGroup::class,
        'request' => UserGroupRequest::class,
        'create' => [
            'title' => 'lang:igniter::admin.form.create_title',
            'redirect' => 'user_groups/edit/{user_group_id}',
            'redirectClose' => 'user_groups',
            'redirectNew' => 'user_groups/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'user_groups/edit/{user_group_id}',
            'redirectClose' => 'user_groups',
            'redirectNew' => 'user_groups/create',
        ],
        'preview' => [
            'title' => 'lang:igniter::admin.form.preview_title',
            'back' => 'user_groups',
        ],
        'delete' => [
            'redirect' => 'user_groups',
        ],
        'configFile' => 'usergroup',
    ];

    protected null|string|array $requiredPermissions = 'Admin.StaffGroups';

    public static function getSlug(): string
    {
        return 'user_groups';
    }

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('users', 'system');
    }

    public function formAfterSave(): void
    {
        UserGroup::syncAutoAssignStatus();
    }
}

<?php

declare(strict_types=1);

namespace Igniter\User\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Flame\Exception\FlashException;
use Igniter\Local\Http\Actions\LocationAwareController;
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Http\Requests\UserRequest;
use Igniter\User\Models\User;
use Illuminate\Http\RedirectResponse;

/**
 * @mixin ListController
 * @mixin FormController
 */
class Users extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
        LocationAwareController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => User::class,
            'title' => 'lang:igniter.user::default.staff.text_title',
            'emptyMessage' => 'lang:igniter.user::default.staff.text_empty',
            'defaultSort' => ['user_id', 'DESC'],
            'configFile' => 'user',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.user::default.staff.text_form_name',
        'model' => User::class,
        'request' => UserRequest::class,
        'create' => [
            'title' => 'lang:igniter::admin.form.create_title',
            'redirect' => 'users/edit/{user_id}',
            'redirectClose' => 'users',
            'redirectNew' => 'users/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'users/edit/{user_id}',
            'redirectClose' => 'users',
            'redirectNew' => 'users/create',
        ],
        'preview' => [
            'title' => 'lang:igniter::admin.form.preview_title',
            'back' => 'users',
        ],
        'delete' => [
            'redirect' => 'users',
        ],
        'configFile' => 'user',
    ];

    public array $locationConfig = [
        'addAbsenceConstraint' => true,
    ];

    protected null|string|array $requiredPermissions = 'Admin.Staffs';

    public static function getSlug(): string
    {
        return 'users';
    }

    public function __construct()
    {
        parent::__construct();

        if ($this->action === 'account') {
            $this->requiredPermissions = null;
        }

        AdminMenu::setContext('users', 'system');
    }

    public function account(): string
    {
        $this->asExtension('LocationAwareController')?->setConfig(['applyScopeOnFormQuery' => false]);

        $this->asExtension('FormController')->edit('account', $this->getUser()->getKey());

        return $this->makeView('edit');
    }

    public function account_onSave()
    {
        $this->asExtension('LocationAwareController')?->setConfig(['applyScopeOnFormQuery' => false]);

        $result = $this->asExtension('FormController')->edit_onSave('account', $this->currentUser->user_id);

        $usernameChanged = $this->currentUser->username != post('User[username]');
        $passwordChanged = strlen((string)post('User[password]'));
        $languageChanged = $this->currentUser->language != post('User[language_id]');
        $emailChanged = $this->currentUser->email != post('User[email]');
        if ($emailChanged || $passwordChanged) {
            AdminAuth::logout();

            return redirect('/logout');
        }

        if ($usernameChanged || $languageChanged) {
            $this->currentUser->reload()->reloadRelations();
            AdminAuth::login($this->currentUser, true);
        }

        return $result;
    }

    public function index_onDelete()
    {
        throw_unless($this->authorize('Admin.DeleteStaffs'),
            new FlashException(lang('igniter::admin.alert_user_restricted')),
        );

        return $this->asExtension(ListController::class)->index_onDelete();
    }

    public function edit_onDelete($context, $recordId)
    {
        throw_unless($this->authorize('Admin.DeleteStaffs'),
            new FlashException(lang('igniter::admin.alert_user_restricted')),
        );

        return $this->asExtension(FormController::class)->edit_onDelete($context, $recordId);
    }

    public function onImpersonate($context, $recordId = null): RedirectResponse
    {
        throw_unless($this->authorize('Admin.Impersonate'),
            new FlashException(lang('igniter.user::default.staff.alert_login_restricted')),
        );

        $id = post('recordId', $recordId);
        /** @var null|User $user */
        $user = $this->formFindModelObject($id);
        AdminAuth::stopImpersonate();
        AdminAuth::impersonate($user);
        flash()->success(sprintf(lang('igniter.user::default.staff.alert_impersonate_success'), $user->name));

        return $this->redirect('dashboard');
    }

    public function listExtendQuery($query): void
    {
        if (!AdminAuth::isSuperUser()) {
            $query->whereNotSuperUser();
        }
    }

    public function formExtendQuery($query): void
    {
        if (!AdminAuth::isSuperUser()) {
            $query->whereNotSuperUser();
        }
    }

    public function formExtendFields($form): void
    {
        if (!AdminAuth::isSuperUser()) {
            $form->removeField('user_role_id');
            $form->removeField('status');
            $form->removeField('super_user');
        }
    }
}

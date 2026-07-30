<?php

declare(strict_types=1);

namespace Igniter\System\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Admin\Widgets\Form;
use Igniter\System\Http\Requests\MailLayoutRequest;
use Igniter\System\Models\MailLayout;

class MailLayouts extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => MailLayout::class,
            'title' => 'lang:igniter::system.mail_templates.text_title',
            'emptyMessage' => 'lang:igniter::system.mail_templates.text_empty',
            'defaultSort' => ['layout_id', 'DESC'],
            'configFile' => 'maillayout',
            'back' => 'mail_templates',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter::system.mail_templates.text_form_name',
        'model' => MailLayout::class,
        'request' => MailLayoutRequest::class,
        'create' => [
            'title' => 'lang:igniter::admin.form.create_title',
            'redirect' => 'mail_layouts/edit/{layout_id}',
            'redirectClose' => 'mail_layouts',
            'redirectNew' => 'mail_layouts/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'mail_layouts/edit/{layout_id}',
            'redirectClose' => 'mail_layouts',
            'redirectNew' => 'mail_layouts/create',
        ],
        'preview' => [
            'title' => 'lang:igniter::admin.form.preview_title',
            'back' => 'mail_layouts',
        ],
        'delete' => [
            'redirect' => 'mail_layouts',
        ],
        'configFile' => 'maillayout',
    ];

    protected null|string|array $requiredPermissions = 'Admin.MailTemplates';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('mail_templates', 'design');
    }

    public function formExtendFields(Form $form): void
    {
        if ($form->context != 'create') {
            $field = $form->getField('code');
            $field->disabled = true;
        }
    }

    public function formBeforeSave(MailLayout $model): void
    {
        $model->is_locked = true;
    }
}

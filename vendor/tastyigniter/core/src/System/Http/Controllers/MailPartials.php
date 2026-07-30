<?php

declare(strict_types=1);

namespace Igniter\System\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Admin\Widgets\Form;
use Igniter\System\Http\Requests\MailPartialRequest;
use Igniter\System\Models\MailPartial;

class MailPartials extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => MailPartial::class,
            'title' => 'lang:igniter::system.mail_templates.text_partial_title',
            'emptyMessage' => 'lang:igniter::system.mail_templates.text_empty',
            'defaultSort' => ['partial_id', 'DESC'],
            'configFile' => 'mailpartial',
            'back' => 'mail_templates',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter::system.mail_templates.text_partial_form_name',
        'model' => MailPartial::class,
        'request' => MailPartialRequest::class,
        'create' => [
            'title' => 'lang:igniter::system.mail_templates.text_new_partial_title',
            'redirect' => 'mail_partials/edit/{partial_id}',
            'redirectClose' => 'mail_partials',
            'redirectNew' => 'mail_partials/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::system.mail_templates.text_edit_partial_title',
            'redirect' => 'mail_partials/edit/{partial_id}',
            'redirectClose' => 'mail_partials',
            'redirectNew' => 'mail_partials/create',
        ],
        'preview' => [
            'title' => 'lang:igniter::system.mail_templates.text_preview_partial_title',
            'back' => 'mail_partials',
        ],
        'delete' => [
            'redirect' => 'mail_partials',
        ],
        'configFile' => 'mailpartial',
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

    public function formBeforeSave(MailPartial $model): void
    {
        $model->is_custom = true;
    }
}

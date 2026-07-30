<?php

declare(strict_types=1);

namespace Igniter\System\Http\Controllers;

use Facades\Igniter\System\Helpers\MailHelper;
use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Admin\Widgets\Form;
use Igniter\Flame\Exception\FlashException;
use Igniter\System\Http\Requests\MailTemplateRequest;
use Igniter\System\Models\MailTemplate;

class MailTemplates extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => MailTemplate::class,
            'title' => 'lang:igniter::system.mail_templates.text_template_title',
            'emptyMessage' => 'lang:igniter::system.mail_templates.text_empty',
            'defaultSort' => ['template_id', 'DESC'],
            'configFile' => 'mailtemplate',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter::system.mail_templates.text_form_name',
        'model' => MailTemplate::class,
        'request' => MailTemplateRequest::class,
        'create' => [
            'title' => 'lang:igniter::system.mail_templates.text_new_template_title',
            'redirect' => 'mail_templates/edit/{template_id}',
            'redirectClose' => 'mail_templates',
            'redirectNew' => 'mail_templates/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::system.mail_templates.text_edit_template_title',
            'redirect' => 'mail_templates/edit/{template_id}',
            'redirectClose' => 'mail_templates',
            'redirectNew' => 'mail_templates/create',
        ],
        'preview' => [
            'title' => 'lang:igniter::system.mail_templates.text_preview_template_title',
            'back' => 'mail_templates',
        ],
        'delete' => [
            'redirect' => 'mail_templates',
        ],
        'configFile' => 'mailtemplate',
    ];

    protected null|string|array $requiredPermissions = 'Admin.MailTemplates';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('mail_templates', 'design');
    }

    public function index(): void
    {
        MailTemplate::syncAll();

        $this->asExtension('ListController')->index();
    }

    public function formExtendFields(Form $form): void
    {
        if ($form->context != 'create') {
            $field = $form->getField('code');
            $field->disabled = true;
        }
    }

    public function formBeforeSave(MailTemplate $model): void
    {
        $model->is_custom = true;
    }

    public function onTestTemplate(?string $context = null, ?string $recordId = null): array
    {
        if (!$recordId) {
            throw new FlashException(lang('igniter::system.mail_templates.alert_template_id_not_found'));
        }

        $model = $this->asExtension(FormController::class)->formFindModelObject($recordId);

        $adminUser = $this->getUser();

        $errorLevel = error_reporting(0);

        MailHelper::sendTemplate($model->code, [], [$adminUser->email, $adminUser->name]);

        error_reporting($errorLevel);

        flash()->success(sprintf(lang('igniter::system.mail_templates.alert_test_message_sent'), $adminUser->staff_email));

        return [
            '#notification' => $this->makePartial('flash'),
        ];
    }
}

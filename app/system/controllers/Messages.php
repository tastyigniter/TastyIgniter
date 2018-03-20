<?php namespace System\Controllers;

use AdminAuth;
use AdminMenu;
use System\Models\Messages_model;

class Messages extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'System\Models\Messages_model',
            'title'        => 'lang:system::messages.text_title',
            'emptyMessage' => 'lang:system::messages.text_empty',
            'showSorting'  => FALSE,
            'defaultSort'  => ['date_updated', 'DESC'],
            'configFile'   => 'messages_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:system::messages.text_form_name',
        'model'      => 'System\Models\Messages_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'messages/compose/{message_id}',
            'redirectClose' => 'messages',
            'context'       => 'compose',
        ],
//        'preview'       => [
//            'title'         => 'lang:admin::default.form.edit_title',
//            'redirect'      => 'messages/view/{code}',
//            'redirectClose' => 'messages',
//            'context' => 'view',
//        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'messages/draft/{message_id}',
            'redirectClose' => 'messages',
            'context'       => 'draft',
        ],
        'configFile' => 'messages_model',
    ];

    protected $requiredPermissions = 'Admin.Messages';

    public $messageContext;

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('messages', 'marketing');
    }

    public function index()
    {
        $this->prepareVars('inbox');

        $this->asExtension('ListController')->index();
    }

    public function sent($context)
    {
        $this->prepareVars($context);

        $this->asExtension('ListController')->index();

        return $this->makeView('messages/index');
    }

    public function all($context)
    {
        if (!AdminAuth::hasPermission('Admin.Messages.Manage', true))
            return $this->redirect('messages');

        $this->prepareVars($context);

        $this->asExtension('ListController')->index();

        return $this->makeView('messages/index');
    }

    public function archive($context)
    {
        $this->prepareVars($context);

        $this->asExtension('ListController')->index();

        return $this->makeView('messages/index');
    }

    public function compose()
    {
        $this->asExtension('FormController')->create();
    }

    public function view($context, $recordId = null)
    {
        $this->formConfig['edit']['context'] = $context;
        $this->asExtension('FormController')->edit($context, $recordId);
    }

    public function draft($context, $recordId = null)
    {
        if (!is_null($recordId)) {
            $this->asExtension('FormController')->edit(null, $recordId);
            $view = 'messages/compose';
        }
        else {
            $this->prepareVars($context);
            $this->asExtension('ListController')->index();
            $view = 'messages/index';
        }

        return $this->makeView($view);
    }

    public function view_onSend($context, $recordId = null)
    {
        $this->asExtension('FormController')->edit_onSave(null, $recordId);
    }

    public function view_onDraft($context, $recordId = null)
    {
        $this->asExtension('FormController')->edit_onSave(null, $recordId);
    }

    public function draft_onSend($context, $recordId = null)
    {
        $this->asExtension('FormController')->edit_onSave(null, $recordId);
    }

    public function compose_onSend()
    {
        $this->asExtension('FormController')->create_onSave();
    }

    public function compose_onSave()
    {
        $this->asExtension('FormController')->create_onSave();
    }

    protected function prepareVars($context = 'inbox')
    {
        $this->vars['listContext'] = $this->messageContext = $context;
        $this->vars['folders'] = Messages_model::listFolders();
        $this->vars['messageLoggedUser'] = $user = $this->getUser()->staff;
        $this->vars['unreadCount'] = Messages_model::countUnread($user);
    }

    public function listExtendQuery($query, $alias)
    {
        $query->with(['recipients', 'sender'])->listMessages([
            'context'   => $this->messageContext,
            'recipient' => $this->getUser()->staff,
        ]);
    }

    public function listExtendColumns($list)
    {
        if ($this->messageContext == 'draft') {
            $column = $list->getColumn('subject');
            $column->config['onClick'] = 'messages/draft/{message_id}';
        }
    }

    public function formExtendQuery($query)
    {
        $query->with(['recipients', 'sender'])->viewConversation([
            'recipient' => $this->getUser()->staff,
        ]);
    }

    public function formBeforeCreate($model)
    {
        $user = AdminAuth::getUser();
        $model->sender_id = $user->staff->getKey();
        $model->sender_type = get_class($user->staff);
    }

    public function formAfterSave($model)
    {
        if (post('send') === 1)
            $model->send();
    }

    public function formValidate($model, $form)
    {
        $rules[] = ['recipient', 'lang:system::messages.label_to', 'required|min:2|max:128'];
        $rules[] = ['subject', 'lang:system::messages.label_subject', 'required|min:2|max:128'];
        $rules[] = ['send_type', 'lang:system::messages.label_send_type', 'required|alpha'];
        $rules[] = ['customer_groups.*', 'lang:system::messages.label_customer_group', 'required_if:recipient,customer_group|integer'];
        $rules[] = ['staff_groups.*', 'lang:system::messages.label_staff_group', 'required_if:recipient,staff_group|integer'];
        $rules[] = ['customers.*', 'lang:system::messages.label_customers', 'required_if:recipient,customers|integer'];
        $rules[] = ['staffs.*', 'lang:system::messages.label_staff', 'required_if:recipient,staffs|integer'];
        $rules[] = ['body', 'lang:system::messages.label_body', 'required|min:3'];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}
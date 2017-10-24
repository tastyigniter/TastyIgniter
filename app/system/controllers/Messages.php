<?php namespace System\Controllers;

use System\Models\Messages_model;
use AdminMenu;

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
            'redirect'      => 'messages/compose',
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
            'redirect'      => 'messages/draft/{code}',
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
        $this->listMessages('inbox');
    }

    public function sent()
    {
        $this->listMessages('sent');

        $this->template->setView('messages/index');
    }

    public function all()
    {
        $this->listMessages('all');

        $this->template->setView('messages/index');
    }

    public function archive()
    {
        $this->listMessages('archive');

        $this->template->setView('messages/index');
    }

    public function compose()
    {
        $this->asExtension('FormController')->create();
    }

    public function view($context, $recordId = null)
    {
        $this->formConfig['edit']['context'] = 'view';
        $this->asExtension('FormController')->edit('view', $recordId);
    }

    public function draft($context, $recordId = null)
    {
        if (!is_null($recordId)) {
            $this->asExtension('FormController')->edit(null, $recordId);
            $this->template->setView('messages/compose');
        }
        else {
            $this->listMessages($context);
            $this->template->setView('messages/index');
        }
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

    public function compose_onSave()
    {
        $this->asExtension('FormController')->create_onSave();
    }

    protected function listMessages($context = 'inbox')
    {
        $this->asExtension('ListController')->index();
        $this->vars['listContext'] = $this->messageContext = $context;
        $this->vars['folders'] = Messages_model::listFolders();
        $this->vars['messageLoggedUser'] = $user = $this->getUser();
        $this->vars['unreadCount'] = Messages_model::countUnread($user);
    }

    public function listExtendQuery($query, $alias)
    {
        $query->with(['recipients', 'sender'])->listMessages([
            'context'   => $this->messageContext,
            'recipient' => $this->getUser(),
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
            'recipient' => $this->getUser(),
        ]);
    }

    public function formValidate($model, $form)
    {
        $rules[] = ['recipient', 'lang:system::messages.label_to', 'required|min:2|max:128'];
        $rules[] = ['subject', 'lang:system::messages.label_subject', 'required|min:2|max:128'];
        $rules[] = ['send_type', 'lang:system::messages.label_send_type', 'required|alpha'];
        $rules[] = ['customer_groups[]', 'lang:system::messages.label_customer_group', 'required_if:send_type,customer_group|integer'];
        $rules[] = ['staff_groups[]', 'lang:system::messages.label_staff_group', 'required_if:send_type,staff_group|integer'];
        $rules[] = ['customers[]', 'lang:system::messages.label_customers', 'required_if:send_type,customers|integer'];
        $rules[] = ['staffs[]', 'lang:system::messages.label_staff', 'required_if:send_type,staffs|integer'];
        $rules[] = ['body', 'lang:system::messages.label_body', 'required|min:3'];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}
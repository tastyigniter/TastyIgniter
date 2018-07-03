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
            'title'        => 'lang:system::lang.messages.text_title',
            'emptyMessage' => 'lang:system::lang.messages.text_empty',
            'showSorting'  => FALSE,
            'defaultSort'  => ['date_updated', 'DESC'],
            'configFile'   => 'messages_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:system::lang.messages.text_form_name',
        'model'      => 'System\Models\Messages_model',
        'create'     => [
            'title'         => 'lang:system::lang.messages.text_create_title',
            'redirect'      => 'messages/draft/{message_id}',
            'redirectClose' => 'messages',
            'context'       => 'compose',
        ],
        'edit'       => [
            'title'         => 'lang:system::lang.messages.text_draft_title',
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
        $this->asExtension('FormController')->edit($context, $recordId);
    }

    public function draft($context, $recordId = null)
    {
        if ($recordId == null) {
            $this->prepareVars($context);
            $this->asExtension('ListController')->index();
            $view = 'messages/index';
        }
        else {
            $formController = $this->asExtension('FormController');
            $formController->edit(null, $recordId);
            $view = 'messages/compose';
            if ($formController->getFormModel()->isSent()) {
                flash()->danger(lang('system::lang.messages.alert_warning_draft'));

                return $this->redirect('messages/draft');
            }
        }

        return $this->makeView($view);
    }

    public function index_onMark()
    {
        $checkedIds = post('checked');
        if (!$checkedIds OR !is_array($checkedIds) OR !count($checkedIds)) {
            flash()->success(lang('admin::lang.list.delete_empty'));

            return $this->refreshList();
        }

        $markAction = post('action');
        $records = Messages_model::whereIn('message_id', $checkedIds)->get();
        foreach ($records as $record) {
            if ($markAction == 'read') {
                $record->markAsRead($this->getUser()->staff);
            }
            else {
                $record->markAsUnread($this->getUser()->staff);
            }
        }

        $count = count($records);
        $prefix = ($count > 1) ? ' records' : 'record';
        flash()->success(sprintf(
            lang('admin::lang.alert_success'),
            '['.$count.']'.$prefix.' '.lang('system::lang.messages.alert_mark_as_'.$markAction)
        ));
    }

    public function view_onSend($context, $recordId = null)
    {
        return $this->asExtension('FormController')->edit_onSave($context, $recordId);
    }

    public function draft_onDraft($context, $recordId = null)
    {
        return $this->asExtension('FormController')->edit_onSave(null, $recordId);
    }

    public function draft_onSend($context, $recordId = null)
    {
        return $this->asExtension('FormController')->edit_onSave(null, $recordId);
    }

    public function compose_onSend()
    {
        return $this->asExtension('FormController')->create_onSave();
    }

    public function compose_onDraft()
    {
        return $this->asExtension('FormController')->create_onSave();
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
        $query->with(['sender', 'recipients'])->listMessages([
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
        $query->viewConversation([
            'recipient' => $this->getUser()->staff,
        ]);
    }

    public function formExtendModel($model)
    {
        if ($this->action == 'view') {
            $model->markAsRead($this->getUser()->staff);
        }
    }

    public function formBeforeSave($model)
    {
        if (!$model->exists) {
            $user = AdminAuth::getUser();
            $model->sender_id = $user->staff->getKey();
            $model->sender_type = get_class($user->staff);
        }

        // If status hasn't already been set, we will
        // set it to -1 to send or 0 to save as draft
        if (!$model->isSent())
            $model->status = ($send = post('close') AND $send == 1) ? -1 : 0;
    }

    public function formAfterSave($model)
    {
        // Update message as sent, sets status to 1
        if (post('close') == 1)
            $model->sent();

        if ($this->action == 'view') {
            $user = AdminAuth::getUser();
            $response = $model->replicate();
            $response->sender_id = $user->staff->getKey();
            $response->sender_type = get_class($user->staff);
            $response->parent_id = $model->message_id;
            $response->body = post('Message.respond');
            $response->save();
        }
    }

    public function formValidate($model, $form)
    {
        $rules[] = ['recipient', 'lang:system::lang.messages.label_to', 'sometimes|min:2|max:128'];
        $rules[] = ['subject', 'lang:system::lang.messages.label_subject', 'sometimes|min:2|max:128'];
        $rules[] = ['send_type', 'lang:system::lang.messages.label_send_type', 'sometimes|alpha'];
        $rules[] = ['customer_groups.*', 'lang:system::lang.messages.label_customer_group', 'required_if:recipient,customer_group|integer'];
        $rules[] = ['staff_groups.*', 'lang:system::lang.messages.label_staff_group', 'required_if:recipient,staff_group|integer'];
        $rules[] = ['customers.*', 'lang:system::lang.messages.label_customers', 'required_if:recipient,customers|integer'];
        $rules[] = ['staffs.*', 'lang:system::lang.messages.label_staff', 'required_if:recipient,staffs|integer'];
        $rules[] = ['body', 'lang:system::lang.messages.label_body', 'sometimes|min:3'];
        $rules[] = ['respond', 'lang:system::lang.messages.label_respond', 'sometimes|min:3'];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}
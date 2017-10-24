<?php namespace Admin\Controllers;

use AdminMenu;

class Statuses extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Statuses_model',
            'title'        => 'lang:admin::statuses.text_title',
            'emptyMessage' => 'lang:admin::statuses.text_empty',
            'defaultSort'  => ['status_for', 'ASC'],
            'configFile'   => 'statuses_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::statuses.text_form_name',
        'model'      => 'Admin\Models\Statuses_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'statuses/edit/{status_id}',
            'redirectClose' => 'statuses',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'statuses/edit/{status_id}',
            'redirectClose' => 'statuses',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'statuses',
        ],
        'delete'     => [
            'redirect' => 'statuses',
        ],
        'configFile' => 'statuses_model',
    ];

    protected $requiredPermissions = 'Admin.Statuses';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('statuses', 'sales');
    }

    public function comment_notify()
    {
        if (get('status_id')) {
            $status = $this->Statuses_model->getStatus(get('status_id'));

            $json = ['comment' => $status['status_comment'], 'notify' => $status['notify_customer']];

            $this->output->set_output(json_encode($json));
        }
    }

    public function formValidate($model, $form)
    {
        $rules = [
            ['status_name', 'lang:admin::statuses.label_name', 'required|min:2|max:32'],
            ['status_for', 'lang:admin::statuses.label_for', 'required|alpha'],
            ['status_color', 'lang:admin::statuses.label_color', 'required|max:7'],
            ['status_comment', 'lang:admin::statuses.label_comment', 'max:1028'],
            ['notify_customer', 'lang:admin::statuses.label_notify', 'integer'],
        ];

        return $this->validatePasses($form->getSaveData(), $rules);
    }
}

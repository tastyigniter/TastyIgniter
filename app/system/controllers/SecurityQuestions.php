<?php namespace System\Controllers;

use AdminMenu;
use Template;

class SecurityQuestions extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'System\Models\Security_questions_model',
            'title'        => 'lang:system::security_questions.text_title',
            'emptyMessage' => 'lang:system::security_questions.text_empty',
            'defaultSort'  => ['order_id', 'DESC'],
            'configFile'   => 'security_questions_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:system::security_questions.text_form_name',
        'model'      => 'System\Models\Security_questions_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'security_questions/edit/{question_id}',
            'redirectClose' => 'security_questions',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'security_questions/edit/{question_id}',
            'redirectClose' => 'security_questions',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'security_questions',
        ],
        'delete'     => [
            'redirect' => 'security_questions',
        ],
        'configFile' => 'security_questions_model',
    ];

    protected $requiredPermissions = 'Admin.SecurityQuestions';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('security_questions', 'localisation');
    }

    public function formValidate($model, $form)
    {
        $rules = [];
        $rules[] = ['priority]', 'lang:system::security_questions.label_question', 'required|integer'];
        $rules[] = ['text', 'lang:system::security_questions.label_answer', 'required|min:2|max:128'];

        return $this->validatePasses($form->getSaveData(), $rules);
    }
}
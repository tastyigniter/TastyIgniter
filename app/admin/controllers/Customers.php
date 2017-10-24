<?php namespace Admin\Controllers;

use AdminAuth;
use Assets;
use AdminMenu;

class Customers extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Customers_model',
            'title'        => 'lang:admin::customers.text_title',
            'emptyMessage' => 'lang:admin::customers.text_empty',
            'defaultSort'  => ['country_name', 'ASC'],
            'configFile'   => 'customers_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::customers.text_form_name',
        'model'      => 'Admin\Models\Customers_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'customers/edit/{customer_id}',
            'redirectClose' => 'customers',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'customers/edit/{customer_id}',
            'redirectClose' => 'customers',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'customers',
        ],
        'delete'     => [
            'redirect' => 'customers',
        ],
        'configFile' => 'customers_model',
    ];

    protected $requiredPermissions = 'Admin.Customers';

    public function __construct()
    {
        parent::__construct();

        Assets::addJs('assets/js/addresstabs.js', 'addresstabs-js');

        AdminMenu::setContext('customers', 'users');
    }

    public function login($context = null, $id = null)
    {
        if (!AdminAuth::canAccessCustomerAccount()) {
            flash()->set('warning', lang('admin::customers.alert_login_restricted'));
            return $this->redirectBack();
        }

        $customerModel = $this->formFindModelObject((int)$id);
        if (count($customerModel)) {
            $this->load->library('customer');
            $this->load->library('cart');

            $this->customer->logout();
            $this->cart->destroy();

            $this->customer->loginUsingId($customerModel->customer_id, FALSE);

            if ($this->customer->isLogged()) {
                activity()->performedOn($customerModel)
                          ->causedBy($this->getUser())
                          ->log(lang('activity_master_logged_in'));

                return $this->redirect(root_url('account/account'));
            }
        }

        return $this->redirectBack();
    }

    public function formExtendQuery($query)
    {
        return $query->with(['addresses']);
    }

    public function formValidate($model, $form)
    {
        $rules = [
            ['first_name', 'lang:admin::customers.label_first_name', 'required|min:2|max:32'],
            ['last_name', 'lang:admin::customers.label_last_name', 'required|min:2|max:32'],
            ['email', 'lang:admin::customers.label_email', 'required|email|max:96'
                .(!$model->exists ? '|unique:customers,email' : null)],
            ['telephone', 'lang:admin::customers.label_telephone', 'required|integer'],
            ['security_question_id', 'lang:admin::customers.label_security_question', 'integer'],
            ['security_answer', 'lang:admin::customers.label_security_answer', 'min:2'],
            ['newsletter', 'lang:admin::customers.label_newsletter', 'required|integer'],
            ['customer_group_id', 'lang:admin::customers.label_customer_group', 'required|integer'],
            ['status', 'lang:admin::default.label_status', 'required|integer'],
        ];

        if (!$model->exists OR post($form->arrayName.'[password]')) {
            $rules[] = ['password', 'lang:admin::customers.label_password', 'required|min:8|max:40|same:_confirm_password'];
            $rules[] = ['_confirm_password', 'lang:admin::customers.label_confirm_password'];
        }

        if (post($form->arrayName.'[addresses]')) {
            foreach (post($form->arrayName.'[addresses]') as $key => $value) {
                $rules[] = ['addresses.'.$key.'.address_1', '['.$key.'] '.lang('lang:admin::customers.label_address_1'), 'required|min:3|max:128'];
                $rules[] = ['addresses.'.$key.'.city', '['.$key.'] '.lang('lang:admin::customers.label_city'), 'required|min:2|max:128'];
                $rules[] = ['addresses.'.$key.'.state', '['.$key.'] '.lang('lang:admin::customers.label_state'), 'max:128'];
                $rules[] = ['addresses.'.$key.'.postcode', '['.$key.'] '.lang('lang:admin::customers.label_postcode')];
                $rules[] = ['addresses.'.$key.'.country_id', '['.$key.'] '.lang('lang:admin::customers.label_country'), 'required|integer'];
            }
        }

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}
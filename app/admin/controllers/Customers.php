<?php namespace Admin\Controllers;

use AdminAuth;
use AdminMenu;
use Auth;
use Redirect;

class Customers extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Customers_model',
            'title'        => 'lang:admin::lang.customers.text_title',
            'emptyMessage' => 'lang:admin::lang.customers.text_empty',
            'defaultSort'  => ['country_name', 'ASC'],
            'configFile'   => 'customers_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::lang.customers.text_form_name',
        'model'      => 'Admin\Models\Customers_model',
        'create'     => [
            'title'         => 'lang:admin::lang.form.create_title',
            'redirect'      => 'customers/edit/{customer_id}',
            'redirectClose' => 'customers',
        ],
        'edit'       => [
            'title'         => 'lang:admin::lang.form.edit_title',
            'redirect'      => 'customers/edit/{customer_id}',
            'redirectClose' => 'customers',
        ],
        'preview'    => [
            'title'    => 'lang:admin::lang.form.preview_title',
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

        $this->addJs('js/addresstabs.js', 'addresstabs-js');

        AdminMenu::setContext('customers', 'users');
    }

    public function impersonate($context = null, $id = null)
    {
        if (!AdminAuth::canAccessCustomerAccount()) {
            flash()->warning(lang('admin::lang.customers.alert_login_restricted'));

            return $this->redirectBack();
        }

        $customerModel = $this->formFindModelObject((int)$id);
        if ($customerModel) {

            Auth::stopImpersonate();

            Auth::impersonate($customerModel);

            activity()
                ->performedOn($customerModel)
                ->causedBy(AdminAuth::getUser())
                ->log(lang('system::lang.activities.activity_master_logged_in'));

            return Redirect::to(root_url());
        }

        return $this->redirectBack();
    }

    public function formValidate($model, $form)
    {
        $rules = [
            ['first_name', 'lang:admin::lang.customers.label_first_name', 'required|min:2|max:32'],
            ['last_name', 'lang:admin::lang.customers.label_last_name', 'required|min:2|max:32'],
            ['email', 'lang:admin::lang.customers.label_email', 'required|email|max:96'
                .(!$model->exists ? '|unique:customers,email' : null)],
            ['telephone', 'lang:admin::lang.customers.label_telephone', 'sometimes'],
            ['newsletter', 'lang:admin::lang.customers.label_newsletter', 'required|integer'],
            ['customer_group_id', 'lang:admin::lang.customers.label_customer_group', 'required|integer'],
            ['status', 'lang:admin::lang.label_status', 'required|integer'],
        ];

        if (!$model->exists OR post($form->arrayName.'.password')) {
            $rules[] = ['password', 'lang:admin::lang.customers.label_password', 'required|min:8|max:40|same:_confirm_password'];
            $rules[] = ['_confirm_password', 'lang:admin::lang.customers.label_confirm_password'];
        }

        $rules[] = ['addresses.*.address_1', 'lang:admin::lang.customers.label_address_1', 'required|min:3|max:128'];
        $rules[] = ['addresses.*.city', 'lang:admin::lang.customers.label_city', 'required|min:2|max:128'];
        $rules[] = ['addresses.*.state', 'lang:admin::lang.customers.label_state', 'max:128'];
        $rules[] = ['addresses.*.postcode', 'lang:admin::lang.customers.label_postcode'];
        $rules[] = ['addresses.*.country_id', 'lang:admin::lang.customers.label_country', 'required|integer'];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}
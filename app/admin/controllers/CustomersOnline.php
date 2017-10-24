<?php namespace Admin\Controllers;

use AdminMenu;

class CustomersOnline extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Customer_online_model',
            'title'        => 'lang:admin::customer_online.text_title',
            'emptyMessage' => 'lang:admin::customer_online.text_empty',
            'defaultSort'  => ['date_added', 'DESC'],
            'configFile'   => 'customer_online_model',
        ],
    ];

    protected $requiredPermissions = 'Admin.CustomersOnline';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('customers_online', 'users');
    }
}
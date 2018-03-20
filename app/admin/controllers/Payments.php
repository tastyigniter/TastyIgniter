<?php namespace Admin\Controllers;

use Admin\Classes\PaymentGateways;
use Admin\Models\Payments_model;
use AdminAuth;
use AdminMenu;
use Exception;
use Igniter\Flame\Database\Model;

class Payments extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Payments_model',
            'title'        => 'lang:admin::payments.text_title',
            'emptyMessage' => 'lang:admin::payments.text_empty',
            'defaultSort'  => ['date_updated', 'DESC'],
            'configFile'   => 'payments_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::payments.text_form_name',
        'model'      => 'Admin\Models\Payments_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'payments/edit/{code}',
            'redirectClose' => 'payments',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'payments/edit/{code}',
            'redirectClose' => 'payments',
        ],
        'delete'     => [
            'redirect' => 'payments',
        ],
        'configFile' => 'payments_model',
    ];

    protected $requiredPermissions = 'Admin.Payments';

    protected $gateway;

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('payments', 'sales');
    }

    public function index()
    {
        if (AdminAuth::hasPermission('Admin.Payments.Manage'))
            Payments_model::syncAll();

        $this->asExtension('ListController')->index();
    }

    /**
     * Finds a Model record by its primary identifier, used by edit actions. This logic
     * can be changed by overriding it in the controller.
     *
     * @param string $paymentCode
     *
     * @return Model
     * @throws \Exception
     */
    public function formFindModelObject($paymentCode = null)
    {
        if (!strlen($paymentCode)) {
            throw new Exception(lang('admin::payments.alert_setting_missing_id'));
        }

        $model = $this->formCreateModelObject();

        // Prepare query and find model record
        $query = $model->newQuery();
        $this->formExtendQuery($query);
        $result = $query->whereCode($paymentCode)->first();

        if (!$result)
            throw new Exception(lang('admin::default.form.not_found'));

        $result = $this->formExtendModel($result) ?: $result;

        return $result;
    }

    public function formExtendModel($model)
    {
        if (!$model->exists)
            $model->applyGatewayClass();

        return $model;
    }

    public function formExtendFields($formWidget)
    {
        $model = $formWidget->model;
        $configFields = $model->getConfigFields();
        $formWidget->addTabFields($configFields);

        // Add the set up help partial
//        $setupPartial = $model->getPartialPath().'/setup_help.php';
//        if (file_exists($setupPartial)) {
//            $formWidget->addFields([
//                'setup_help' => [
//                    'type' => 'partial',
//                    'tab'  => 'Help',
//                    'path' => $setupPartial,
//                ]
//            ], 'primary');
//        }
    }

    protected function getGateway($code)
    {
        if ($this->gateway !== null) {
            return $this->gateway;
        }

        if (!$gateway = PaymentGateways::instance()->findGateway($code)) {
            throw new Exception('Unable to find payment gateway with code '.$code);
        }

        return $this->gateway = $gateway;
    }
}
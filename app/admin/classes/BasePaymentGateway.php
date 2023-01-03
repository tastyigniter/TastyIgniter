<?php

namespace Admin\Classes;

use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use System\Actions\ModelAction;

/**
 * Base Payment Gateway Class
 */
class BasePaymentGateway extends ModelAction
{
    /**
     * @var \Admin\Models\Payments_model|Model Reference to the controller associated to this action
     */
    protected $model;

    protected $orderModel = 'Admin\Models\Orders_model';

    protected $orderStatusModel = 'Admin\Models\Statuses_model';

    protected $configFields = [];

    protected $configValidationAttributes = [];

    protected $configValidationMessages = [];

    protected $configRules = [];

    /**
     * Class constructor
     *
     * @param AdminController $controller
     * @param array $params
     */
    public function __construct($model = null)
    {
        parent::__construct($model);

        $reflector = new \ReflectionClass($calledClass = get_called_class());
        $this->configPath = dirname($reflector->getFileName()).'/'.basename(File::normalizePath(strtolower($calledClass)));

        $formConfig = $this->loadConfig($this->defineFieldsConfig(), ['fields']);
        $this->configFields = array_get($formConfig, 'fields');
        $this->configRules = array_get($formConfig, 'rules', []);
        $this->configValidationAttributes = array_get($formConfig, 'validationAttributes', []);
        $this->configValidationMessages = array_get($formConfig, 'validationMessages', []);

        if (!$model)
            return;

        $this->initialize($model);
    }

    /**
     * Initialize method called when the payment gateway is first loaded
     * with an existing model.
     * @return array
     */
    public function initialize($host)
    {
        // Set default data
        if (!$host->exists)
            $this->initConfigData($host);
    }

    /**
     * Initializes configuration data when the payment method is first created.
     *
     * @param Model $host
     */
    public function initConfigData($host)
    {
    }

    /**
     * Extra field configuration for the payment type.
     */
    public function defineFieldsConfig()
    {
        return 'fields';
    }

    /**
     * Returns the form configuration used by this payment type.
     */
    public function getConfigFields()
    {
        return $this->configFields;
    }

    /**
     * Returns the form validation rules used by this payment type.
     */
    public function getConfigRules()
    {
        return $this->configRules;
    }

    /**
     * Returns the form validation attributes used by this model.
     */
    public function getConfigValidationAttributes()
    {
        return $this->configValidationAttributes;
    }

    /**
     * Returns the form validation messages used by this model.
     */
    public function getConfigValidationMessages()
    {
        return $this->configValidationMessages;
    }

    /**
     * Registers a entry page with specific URL. For example,
     * PayPal needs a landing page for the auto-return feature.
     * Important! Payment module access point names should have a prefix.
     * @return array Returns an array containing page URLs and methods to call for each URL:
     * return ['paypal_return'=>'processPaypalReturn']. The processing methods must be declared
     * in the payment type class. Processing methods must accept one parameter - an array of URL segments
     * following the access point. For example, if URL is /paypal_return/12/34 an array
     * ['12', '34'] will be passed to processPaypalReturn method.
     */
    public function registerEntryPoints()
    {
        return [];
    }

    /**
     * Utility function, creates a link to a registered entry point.
     *
     * @param string $code Key used to define the entry point
     *
     * @return string
     */
    public function makeEntryPointUrl($code)
    {
        return URL::to('ti_payregister/'.$code);
    }

    /**
     * Returns true if the payment type is applicable for a specified order amount
     *
     * @param float $total Specifies an order amount
     * @param $host Model object to add fields to
     *
     * @return bool
     */
    public function isApplicable($total, $host)
    {
        return true;
    }

    /**
     * Returns true if the payment type has additional fee
     *
     * @param $host Model object to add fields to
     * @return bool
     */
    public function hasApplicableFee($host = null)
    {
        $host = is_null($host) ? $this->model : $host;

        return ($host->order_fee ?? 0) > 0;
    }

    /**
     * Returns the payment type additional fee
     *
     * @param $host Model object to add fields to
     * @return string
     */
    public function getFormattedApplicableFee($host = null)
    {
        $host = is_null($host) ? $this->model : $host;

        return ((int)$host->order_fee_type === 2)
            ? $host->order_fee.'%'
            : currency_format($host->order_fee);
    }

    /**
     * This method should return TRUE if the gateway completes the payment on the client's browsers.
     * Allows the system to take extra steps during checkout before  completing the payment
     */
    public function completesPaymentOnClient()
    {
        return false;
    }

    /**
     * Processes payment using passed data.
     *
     * @param array $data Posted payment form data.
     * @param Model $host Type model object containing configuration fields values.
     * @param Model $order Order model object.
     */
    public function processPaymentForm($data, $host, $order)
    {
    }

    /**
     * Executed when this gateway is rendered on the checkout page.
     */
    public function beforeRenderPaymentForm($host, $controller)
    {
    }

    /**
     * @return \Admin\Models\Payments_model
     */
    public function getHostObject()
    {
        return $this->model;
    }

    //
    // Payment Profiles
    //

    /**
     * This method should return TRUE if the gateway supports user payment profiles.
     * The payment gateway must implement the updatePaymentProfile(), deletePaymentProfile() and payFromPaymentProfile() methods if this method returns true.
     */
    public function supportsPaymentProfiles()
    {
        return false;
    }

    /**
     * Creates a customer profile on the payment gateway or update if the profile already exists.
     * @param \Admin\Models\Customers_model $customer Customer model to create a profile for
     * @param array $data Posted payment form data
     * @return \Admin\Models\Payment_profiles_model|object Returns the customer payment profile model
     */
    public function updatePaymentProfile($customer, $data)
    {
        throw new SystemException(lang('admin::lang.payments.alert_update_payment_profile'));
    }

    /**
     * Deletes a customer payment profile from the payment gateway.
     * @param \Admin\Models\Customers_model $customer Customer model
     * @param \Admin\Models\Payment_profiles_model $profile Payment profile model
     */
    public function deletePaymentProfile($customer, $profile)
    {
        throw new SystemException(lang('admin::lang.payments.alert_delete_payment_profile'));
    }

    /**
     * Creates a payment transaction from an existing payment profile.
     * @param \Admin\Models\Orders_model $order An order object to pay
     * @param array $data
     */
    public function payFromPaymentProfile($order, $data = [])
    {
        throw new SystemException(lang('admin::lang.payments.alert_pay_from_payment_profile'));
    }

    //
    // Payment Refunds
    //

    public function processRefundForm($data, $order, $paymentLog)
    {
    }

    /**
     * Creates an instance of the order model
     */
    protected function createOrderModel()
    {
        $class = '\\'.ltrim($this->orderModel, '\\');

        return new $class();
    }

    /**
     * Creates an instance of the order status model
     */
    protected function createOrderStatusModel()
    {
        $class = '\\'.ltrim($this->orderStatusModel, '\\');

        return new $class();
    }
}

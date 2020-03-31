<?php

namespace Admin\Classes;

use File;
use Model;
use System\Actions\ModelAction;
use URL;

/**
 * Base Payment Gateway Class
 *
 * @package Admin
 */
class BasePaymentGateway extends ModelAction
{
    protected $orderModel = 'Admin\Models\Orders_model';

    protected $orderStatusModel = 'Admin\Models\Statuses_model';

    protected $configFields = [];

    /**
     * Class constructor
     *
     * @param AdminController $controller
     * @param array $params
     */
    public function __construct($model = null)
    {
        parent::__construct($model);

        $calledClass = strtolower(get_called_class());
        $this->configPath = extension_path(File::normalizePath($calledClass));
        $this->configFields = $this->loadConfig($this->defineFieldsConfig(), ['fields'], 'fields');

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
     * Returns the form configuration used by this model.
     */
    public function getConfigFields()
    {
        return $this->configFields;
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
        return $host->order_total <= $total;
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
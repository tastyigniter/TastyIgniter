<?php

namespace Admin\Classes;

use File;
use System\Actions\ModelAction;

/**
 * Base Payment Gateway Class
 *
 * @package Admin
 */
class BasePaymentGateway extends ModelAction
{
    protected $orderModel = 'Admin\Models\Orders_model';

    protected $orderStatusModel = 'Admin\Models\Statuses_model';

    /**
     * @var array Action configuration
     */
    protected $configArray;

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
     * @param  Model $host
     */
    public function initConfigData($host)
    {
    }

    /**
     * Reads the contents of the supplied file and applies it to this object.
     *
     * @param array $configFile
     * @param array $requiredConfig
     * @param null $index
     *
     * @return array
     */
    public function loadConfig($configFile = [], $requiredConfig = [], $index = null)
    {
        $configArray = $this->makeConfig($configFile, $requiredConfig);

        if (is_null($index))
            return $configArray;

        return isset($configArray[$index]) ? $configArray[$index] : null;
    }

    /**
     * Sets the controller configuration values
     *
     * @param array $config
     * @param array $required Required config items
     */
    public function setConfig($config, $required = [])
    {
        $this->configArray = $this->config->validate($config, $required);
    }

    /**
     * Get the controller configuration values.
     *
     * @param string $name Config name, supports array names like "field[key]"
     * @param mixed $default Default value if nothing is found
     *
     * @return string
     */
    public function getConfig($name = null, $default = null)
    {
        if (is_null($name))
            return $this->configArray;

        $nameArray = name_to_array($name);

        $fieldName = array_shift($nameArray);
        $result = isset($this->configArray[$fieldName]) ? $this->configArray[$fieldName] : null;

        foreach ($nameArray as $key) {
            if (!is_array($result) OR !array_key_exists($key, $result))
                return $default;

            $result = $result[$key];
        }

        return $result;
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
     * Returns true if the payment type is applicable for a specified order amount
     *
     * @param float $amount Specifies an order amount
     * @param $host Model object to add fields to
     *
     * @return true
     */
    public function isApplicable($amount, $host)
    {
        return TRUE;
    }

    /**
     * Executed when this gateway is rendered on the checkout page.
     */
    public function onRender()
    {
    }

    /**
     * Renders a requested partial in context of this component,
     * see Main\Classes\MainController@renderPartial for usage.
     */
    public function renderPartial()
    {
        $this->controller->setComponentContext($this);
        $result = call_user_func_array([$this->controller, 'renderPartial'], func_get_args());
        $this->controller->setComponentContext(null);

        return $result;
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
     * Creates an instance of the order model
     */
    protected function createOrderModel()
    {
        $class = '\\'.ltrim($this->orderModel, '\\');
        $model = new $class();

        return $model;
    }

    /**
     * Creates an instance of the order status model
     */
    protected function createOrderStatusModel()
    {
        $class = '\\'.ltrim($this->orderStatusModel, '\\');
        $model = new $class();

        return $model;
    }
}
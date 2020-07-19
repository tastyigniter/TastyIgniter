<?php namespace Admin\Models;

use Admin\Classes\PaymentGateways;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Exception\ValidationException;
use Lang;
use Model;

/**
 * Payments Model Class
 *
 * @package Admin
 */
class Payments_model extends Model
{
    use Sortable;
    use Purgeable;

    const SORT_ORDER = 'priority';

    const CREATED_AT = 'date_added';

    const UPDATED_AT = 'date_updated';

    /**
     * @var string The database table name
     */
    protected $table = 'payments';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'payment_id';

    protected $fillable = ['name', 'code', 'class_name', 'description', 'data', 'status', 'is_default', 'priority'];

    public $timestamps = TRUE;

    public $casts = [
        'data' => 'serialize',
        'status' => 'boolean',
        'is_default' => 'boolean',
        'priority' => 'integer',
    ];

    protected $purgeable = ['payment'];

    protected static $defaultPayment;

    public function getDropdownOptions()
    {
        return $this->isEnabled()->dropdown('name', 'code');
    }

    public static function listDropdownOptions()
    {
        $all = self::select('code', 'name', 'description')->isEnabled()->get();
        $collection = $all->keyBy('code')->map(function ($model) {
            return [$model->name, $model->description];
        });

        return $collection;
    }

    public static function onboardingIsComplete()
    {
        return self::isEnabled()->count() > 0;
    }

    public function listGateways()
    {
        $result = [];
        $this->gatewayManager = PaymentGateways::instance();
        foreach ($this->gatewayManager->listGateways() as $code => $gateway) {
            $result[$gateway['code']] = $gateway['name'];
        }

        return $result;
    }

    //
    // Accessors & Mutators
    //

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = str_slug($value, '_');
    }

    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
    }

    //
    // Events
    //

    protected function afterFetch()
    {
        $this->applyGatewayClass();

        if (is_array($this->data))
            $this->attributes = array_merge($this->data, $this->attributes);
    }

    protected function beforeSave()
    {
        if (!$this->exists)
            return;

        if ($this->is_default)
            $this->makeDefault();

        $data = [];
        $fields = ($configFields = $this->getConfigFields()) ? $configFields : [];
        foreach ($fields as $name => $config) {
            if (!array_key_exists($name, $this->attributes)) continue;
            $data[$name] = $this->attributes[$name];
        }

        foreach ($this->attributes as $name => $value) {
            if (in_array($name, $this->fillable)) continue;
            unset($this->attributes[$name]);
        }

        $this->data = $data;
    }

    //
    // Manager
    //

    /**
     * Extends this class with the gateway class
     *
     * @param string $class Class name
     *
     * @return boolean
     */
    public function applyGatewayClass($class = null)
    {
        if (is_null($class))
            $class = $this->class_name;

        if (!class_exists($class)) {
            $class = null;
        }

        if ($class AND !$this->isClassExtendedWith($class)) {
            $this->extendClassWith($class);
        }

        $this->class_name = $class;

        return !is_null($class);
    }

    public function renderPaymentForm($controller)
    {
        $this->beforeRenderPaymentForm($this, $controller);

        $paymentMethodFile = strtolower(class_basename($this->class_name));
        $partialName = 'payregister/'.$paymentMethodFile;

        return $controller->renderPartial($partialName, ['paymentMethod' => $this]);
    }

    public function getGatewayClass()
    {
        return $this->class_name;
    }

    public function getGatewayObject($class = null)
    {
        if (!$class) {
            $class = $this->class_name;
        }

        return $this->asExtension($class);
    }

    //
    // Helpers
    //

    public function makeDefault()
    {
        if (!$this->status) {
            throw new ValidationException(['status' => sprintf(
                lang('admin::lang.alert_error_set_default'), $this->name
            )]);
        }

        $this->timestamps = FALSE;
        $this->newQuery()->where('is_default', '!=', 0)->update(['is_default' => 0]);
        $this->newQuery()->where('payment_id', $this->payment_id)->update(['is_default' => 1]);
        $this->timestamps = TRUE;
    }

    public static function getDefault()
    {
        if (self::$defaultPayment !== null) {
            return self::$defaultPayment;
        }

        $defaultPayment = self::isEnabled()->where('is_default', TRUE)->first();

        if (!$defaultPayment) {
            if ($defaultPayment = self::isEnabled()->first()) {
                $defaultPayment->makeDefault();
            }
        }

        return self::$defaultPayment = $defaultPayment;
    }

    /**
     * Return all payments
     *
     * @return array
     */
    public static function listPayments()
    {
        return self::isEnabled()->get()->filter(function ($model) {
            return strlen($model->class_name) > 0;
        });
    }

    public static function syncAll()
    {
        $payments = self::pluck('code')->all();

        $gatewayManager = PaymentGateways::instance();
        foreach ($gatewayManager->listGateways() as $code => $gateway) {
            if (in_array($code, $payments)) continue;

            $model = self::make([
                'code' => $code,
                'name' => Lang::get($gateway['name']),
                'description' => Lang::get($gateway['description']),
                'class_name' => $gateway['class'],
            ]);

            $model->applyGatewayClass();
            $model->save();
        }

        PaymentGateways::createPartials();
    }

    //
    // Payment Profiles
    //

    /**
     * Finds and returns a customer payment profile for this payment method.
     * @param \Admin\Models\Customers_model $customer Specifies customer to find a profile for.
     * @return \Admin\Models\Payment_profiles_model|object Returns the payment profile object or NULL if the payment profile doesn't exist.
     */
    public function findPaymentProfile($customer)
    {
        if (!$customer)
            return null;

        $query = Payment_profiles_model::query();

        return $query->where('customer_id', $customer->customer_id)
            ->where('payment_id', $this->payment_id)
            ->first();
    }

    /**
     * Initializes a new empty customer payment profile.
     * This method should be used by payment methods internally.
     * @param \Admin\Models\Customers_model $customer Specifies customer to initialize a profile for.
     * @return \Admin\Models\Payment_profiles_model Returns the payment profile object or NULL if the payment profile doesn't exist.
     */
    public function initPaymentProfile($customer)
    {
        $profile = new Payment_profiles_model();
        $profile->customer_id = $customer->customer_id;
        $profile->payment_id = $this->payment_id;

        return $profile;
    }

    public function paymentProfileExists($customer)
    {
        return (bool)$this->findPaymentProfile($customer);
    }

    public function deletePaymentProfile($customer)
    {
        $gatewayObj = $this->getGatewayObject();

        $profile = $this->findPaymentProfile($customer);

        if (!$profile) {
            throw new ApplicationException('Customer payment profile not found!');
        }

        $gatewayObj->deletePaymentProfile($customer, $profile);

        $profile->delete();
    }
}
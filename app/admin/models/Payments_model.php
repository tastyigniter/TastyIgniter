<?php namespace Admin\Models;

use Admin\Classes\PaymentGateways;
use Igniter\Flame\Database\Traits\Sortable;
use Model;

/**
 * Payments Model Class
 *
 * @package Admin
 */
class Payments_model extends Model
{
    use Sortable;

    const SORT_ORDER = 'priority';

    /**
     * @var string The database table name
     */
    protected $table = 'payments';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'payment_id';

    public $casts = [
        'data' => 'serialize',
    ];

    protected $fillable = ['name', 'code', 'class_name', 'description', 'data', 'status', 'is_default', 'priority'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function getDropdownOptions()
    {
        return $this->newQuery()->isEnabled()->dropdown('name', 'code');
    }

    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
    }

    //
    // Events
    //

    public function beforeSave()
    {
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

    public function makeDefault()
    {
        if (!$this->status) {
            return FALSE;
        }

        $this->newQuery()->where('payment_id', $this->payment_id)->update(['is_default' => 1]);
        $this->newQuery()->where('payment_id', '<>', $this->payment_id)->update(['is_default' => 0]);
    }

    //
    // Manager
    //

    public function listGateways()
    {
        $this->gatewayManager = PaymentGateways::instance();

        $result = [];
        foreach ($this->gatewayManager->listGateways() as $code => $gateway) {
            $result[$gateway['code']] = $gateway['name'];
        }

        return $result;
    }

    /**
     * Extends this class with the gateway class
     *
     * @param  string $class Class name
     *
     * @return boolean
     */
    public function applyGatewayClass($class = null)
    {
        if (is_null($class))
            $class = $this->class_name;

        if (!$class)
            return FALSE;

        if (!$this->isClassExtendedWith($class)) {
            $this->extendClassWith($class);
        }

        $this->class_name = $class;
        if (is_array($this->data))
            $this->attributes = array_merge($this->data, $this->attributes);

        return TRUE;
    }

    public function renderPaymentForm($controller)
    {
//        $this->beforeRenderPaymentForm($this);

        $paymentMethodFile = strtolower(class_basename($this->class_name));
        $partialName = 'pay/'.$paymentMethodFile;

        var_dump($partialName);

        return $controller->renderPartial($partialName);
    }

    //
    // Helpers
    //

    public static function syncAll()
    {
    }

    /**
     * Return all payments
     *
     * @return array
     */
    public static function listPayments()
    {
        return self::isEnabled()->get();
    }
}
<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\PayRegister\Classes\BasePaymentGateway;
use Igniter\PayRegister\Classes\PaymentGateways;
use Igniter\System\Models\Concerns\Defaultable;
use Igniter\System\Models\Concerns\Switchable;
use Igniter\User\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * Payment Model Class
 *
 * @property int $payment_id
 * @property string $name
 * @property string|null $code
 * @property string $class_name
 * @property string|null $description
 * @property array|null $data
 * @property bool $status
 * @property bool $is_default
 * @property int $priority
 * @property float|int $order_total
 * @property null|int $order_fee_type
 * @property float|int $order_fee
 * @property null|int $capture_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Payment query()
 * @method static Builder|Payment whereIsEnabled()
 * @mixin Model
 * @mixin BasePaymentGateway
 */
class Payment extends Model
{
    use Defaultable;
    use HasFactory;
    use Purgeable;
    use Sortable;
    use Switchable;

    public const string SORT_ORDER = 'priority';

    /**
     * @var string The database table name
     */
    protected $table = 'payments';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'payment_id';

    protected $fillable = ['name', 'code', 'class_name', 'description', 'data', 'priority', 'status', 'is_default'];

    public $timestamps = true;

    protected $casts = [
        'data' => 'array',
        'priority' => 'integer',
    ];

    protected $purgeable = ['payment'];

    public $attributes = [
        'data' => '[]',
    ];

    public function getDropdownOptions()
    {
        return static::whereIsEnabled()->dropdown('name', 'code');
    }

    public static function listDropdownOptions()
    {
        $all = self::query()->select('code', 'name', 'description')->whereIsEnabled()->get();

        // @phpstan-ignore-next-line argument.type
        return $all->keyBy('code')->map(fn(self $model): array => [$model->name, $model->description]);
    }

    public static function onboardingIsComplete(): bool
    {
        return self::whereIsEnabled()->count() > 0;
    }

    public function listGateways()
    {
        $result = [];
        $gatewayManager = resolve(PaymentGateways::class);
        foreach ($gatewayManager->listGateways() as $gateway) {
            $result[$gateway['code']] = $gateway['name'];
        }

        return $result;
    }

    //
    // Accessors & Mutators
    //

    public function setCodeAttribute($value): void
    {
        $this->attributes['code'] = str_slug($value, '_');
    }

    public function purgeConfigFields(): array
    {
        $data = [];
        $attributes = $this->getAttributes();
        foreach ($this->getConfigFields() ?: [] as $name => $config) {
            if (array_key_exists($name, $attributes)) {
                $data[$name] = $attributes[$name];
                unset($this->attributes[$name]);
            }
        }

        return $data;
    }

    //
    // Manager
    //
    /**
     * Extends this class with the gateway class
     */
    public function applyGatewayClass(?string $class = null): bool
    {
        if (is_null($class)) {
            $class = $this->class_name;
        }

        if ($class && !class_exists($class)) {
            $class = null;
        }

        if ($class && !$this->isClassExtendedWith($class)) {
            $this->extendClassWith($class);
        }

        $this->class_name = $class;

        return !is_null($class);
    }

    public function getGatewayClass()
    {
        return $this->class_name;
    }

    public function getGatewayObject($class = null): mixed
    {
        if (!$class) {
            $class = $this->class_name;
        }

        return $class ? $this->asExtension($class) : null;
    }

    //
    // Helpers
    //

    public function defaultableKeyName(): string
    {
        return 'code';
    }

    /**
     * Return all payments
     *
     * @return Collection<int, static>
     */
    public static function listPayments()
    {
        // @phpstan-ignore-next-line return.type
        return self::query()->whereIsEnabled()->get()->filter(fn(self $model): bool => (string)$model->class_name !== '');
    }

    public static function syncAll(): void
    {
        $payments = self::pluck('code')->all();

        $gatewayManager = resolve(PaymentGateways::class);
        foreach ($gatewayManager->listGateways() as $code => $gateway) {
            if (in_array($code, $payments)) {
                continue;
            }

            $model = new self([
                'code' => $code,
                'name' => lang($gateway['name']),
                'description' => lang($gateway['description']),
                'class_name' => $gateway['class'],
                'status' => $code === 'cod',
                'is_default' => $code === 'cod',
                'data' => [],
            ]);

            $model->applyGatewayClass();
            $model->save();
        }
    }

    //
    // Payment Profiles
    //
    /**
     * Finds and returns a customer payment profile for this payment method.
     * @param null|Customer $customer Specifies customer to find a profile for.
     * @return null|PaymentProfile Returns the payment profile object or NULL if the payment profile doesn't exist.
     */
    public function findPaymentProfile(?Customer $customer)
    {
        if (!$customer instanceof Customer) {
            return null;
        }

        /** @var PaymentProfile $paymentProfile */
        $paymentProfile = PaymentProfile::query()
            ->where('customer_id', $customer->customer_id)
            ->where('payment_id', $this->payment_id)
            ->first();

        return $paymentProfile;
    }

    /**
     * Initializes a new empty customer payment profile.
     * This method should be used by payment methods internally.
     * @param Customer $customer Specifies customer to initialize a profile for.
     * @return PaymentProfile Returns the payment profile object or NULL if the payment profile doesn't exist.
     */
    public function initPaymentProfile($customer): PaymentProfile
    {
        $profile = new PaymentProfile;
        $profile->customer_id = $customer->customer_id;
        $profile->payment_id = $this->payment_id;

        return $profile;
    }

    public function paymentProfileExists($customer)
    {
        $gatewayObj = $this->getGatewayObject();
        if (!is_null($result = $gatewayObj->paymentProfileExists($customer))) {
            return $result;
        }

        return (bool)$this->findPaymentProfile($customer);
    }

    public function deletePaymentProfile(?Customer $customer): void
    {
        $gatewayObj = $this->getGatewayObject();

        $profile = $this->findPaymentProfile($customer);

        if (!$profile) {
            throw new ApplicationException(lang('igniter.user::default.customers.alert_customer_payment_profile_not_found'));
        }

        $gatewayObj->deletePaymentProfile($customer, $profile);

        $profile->delete();
    }
}

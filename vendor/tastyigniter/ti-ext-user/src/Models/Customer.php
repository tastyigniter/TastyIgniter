<?php

declare(strict_types=1);

namespace Igniter\User\Models;

use Igniter\Api\Models\Token;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Relations\HasMany;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Exception\SystemException;
use Igniter\Reservation\Models\Reservation;
use Igniter\System\Models\Concerns\SendsMailTemplate;
use Igniter\System\Models\Concerns\Switchable;
use Igniter\System\Models\Country;
use Igniter\User\Auth\Models\User as AuthUserModel;
use Igniter\User\Models\Concerns\SendsInvite;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;
use Override;

/**
 * Customer Model Class
 *
 * @property int $customer_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property null|string $password
 * @property string|null $telephone
 * @property int|null $address_id
 * @property bool|null $newsletter
 * @property int $customer_group_id
 * @property string|null $ip_address
 * @property Carbon $created_at
 * @property bool $status
 * @property string|null $reset_code
 * @property Carbon|null $reset_time
 * @property string|null $activation_code
 * @property string|null $remember_token
 * @property bool|null $is_activated
 * @property Carbon|null $activated_at
 * @property Carbon|null $last_login
 * @property string|null $last_seen
 * @property Carbon $updated_at
 * @property Carbon|null $invited_at
 * @property string $last_location_area
 * @property null|bool $send_invite
 * @property-read mixed $full_name
 * @property-read DatabaseNotificationCollection<int, Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Token> $tokens
 * @property null|CustomerGroup $group
 * @property null|Address $address
 * @property-read Collection<int, Address> $addresses
 * @property-read int|null $tokens_count
 * @method static Builder<static>|Customer query()
 * @method static Builder<static>|Customer selectRaw(string $select)
 * @method static Builder<static>|Customer dropdown(string $column, string $key = null)
 * @method static HasMany<static>|Address addresses()
 * @method static Builder<static>|Customer listFrontEnd(array $options = [])
 * @method static Builder<static>|Customer whereIsEnabled()
 * @method static Builder<static>|Customer whereActivationCode(string $code)
 * @method static array pluckDates(string $column, string $keyFormat = 'Y-m', string $valueFormat = 'F Y')
 * @mixin Model
 */
class Customer extends AuthUserModel
{
    use HasFactory;
    use Purgeable;
    use SendsInvite;
    use SendsMailTemplate;
    use Switchable;

    /**
     * @var string The database table name
     */
    protected $table = 'customers';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'customer_id';

    protected $guarded = ['reset_code', 'activation_code', 'remember_token'];

    protected $hidden = ['password', 'remember_token'];

    public $timestamps = true;

    public $relation = [
        'hasMany' => [
            'addresses' => [Address::class, 'delete' => true],
            'orders' => [Order::class],
            'reservations' => [Reservation::class],
        ],
        'belongsTo' => [
            'group' => [CustomerGroup::class, 'foreignKey' => 'customer_group_id'],
            'address' => Address::class,
        ],
    ];

    protected $purgeable = ['addresses'];

    public $appends = ['full_name'];

    protected $casts = [
        'customer_id' => 'integer',
        'password' => 'hashed',
        'address_id' => 'integer',
        'customer_group_id' => 'integer',
        'newsletter' => 'boolean',
        'status' => 'boolean',
        'is_activated' => 'boolean',
        'last_login' => 'datetime',
        'invited_at' => 'datetime',
        'activated_at' => 'datetime',
        'reset_time' => 'datetime',
    ];

    protected $attributes = [
        'last_location_area' => '',
    ];

    public static function getDropdownOptions()
    {
        return static::query()
            ->whereIsEnabled()
            ->selectRaw("customer_id, concat(first_name, ' ', last_name) as name")
            ->dropdown('name');
    }

    //
    // Accessors & Mutators
    //

    public function getFullNameAttribute($value): string
    {
        return $this->getCustomerName();
    }

    public function getEmailAttribute($value): string
    {
        return strtolower((string)$value);
    }

    //
    // Events
    //

    #[Override]
    public function beforeLogin(): void
    {
        if (!$this->group || !$this->group->requiresApproval()) {
            return;
        }

        if ($this->is_activated && $this->isEnabled()) {
            return;
        }

        throw new SystemException(sprintf(
            lang('igniter.user::default.customers.alert_customer_not_active'), $this->email,
        ));
    }

    #[Override]
    public function afterLogin(): void
    {
        $this->last_login = now();
        $this->saveQuietly();
    }

    #[Override]
    public function extendUserQuery($query): void
    {
        $query->isEnabled();
    }

    //
    // Helpers
    //

    public function enabled(): bool
    {
        return $this->isEnabled();
    }

    public function getCustomerName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function listAddresses()
    {
        return $this->addresses()->get()->groupBy(fn($address) => $address->getKey());
    }

    /**
     * Return all customer registration dates
     *
     * @return array
     */
    public function getCustomerDates()
    {
        return static::pluckDates('created_at');
    }

    public function saveAddresses($addresses): ?bool
    {
        $customerId = $this->getKey();
        if (!is_numeric($customerId)) {
            return false;
        }

        $idsToKeep = [];
        foreach ($addresses as $address) {
            if (!array_key_exists('country_id', $address)) {
                $address['country_id'] = Country::getDefaultKey();
            }

            $customerAddress = $this->addresses()->updateOrCreate(
                array_only($address, ['address_id']),
                array_except($address, ['address_id', 'customer_id']),
            );

            $idsToKeep[] = $customerAddress->getKey();
        }

        $this->addresses()->whereNotIn('address_id', $idsToKeep)->delete();

        return null;
    }

    public function saveDefaultAddress(string|int $addressId): static
    {
        throw_unless($this->addresses()->find($addressId),
            new ApplicationException('Address not found or does not belong to the customer'),
        );

        $this->address_id = $addressId;
        $this->save();

        return $this;
    }

    public function deleteCustomerAddress(string|int $addressId)
    {
        throw_unless($address = $this->addresses()->find($addressId),
            new ApplicationException('Address not found or does not belong to the customer'),
        );

        $address->delete();

        return $address;
    }

    /**
     * Update guest orders, address and reservations
     * matching customer email
     *
     * @return bool TRUE on success, or FALSE on failure
     */
    public function saveCustomerGuestOrder(): bool
    {
        $update = ['customer_id' => $this->customer_id];

        Reservation::query()
            ->where('email', $this->email)
            ->whereNull('customer_id')
            ->orWhere('customer_id', 0)
            ->update($update);

        Order::query()
            ->where('email', $this->email)
            ->whereNull('customer_id')
            ->orWhere('customer_id', 0)
            ->update($update);

        Address::query()
            ->whereIn('address_id', Order::query()
                ->where('email', $this->email)
                ->whereNotNull('address_id')
                ->pluck('address_id')->all(),
            )->update($update);

        return true;
    }

    public function mailSendInvite(array $vars = []): void
    {
        $this->mailSend('igniter.user::mail.invite_customer', 'customer', $vars);
    }

    public function mailSendResetPasswordRequest(array $vars = []): void
    {
        $vars = array_merge([
            'reset_link' => null,
            'account_login_link' => null,
        ], $vars);

        $this->mailSend('igniter.user::mail.password_reset_request', 'customer', $vars);
    }

    public function mailSendResetPassword(array $vars = []): void
    {
        $vars = array_merge([
            'account_login_link' => null,
        ], $vars);

        $this->mailSend('igniter.user::mail.password_reset', 'customer', $vars);
    }

    public function mailSendRegistration(array $vars = []): void
    {
        $vars = array_merge(['account_login_link' => null], $vars);

        $settingRegistrationEmail = setting('registration_email');
        if (!is_array($settingRegistrationEmail)) {
            $settingRegistrationEmail = [];
        }

        if (in_array('customer', $settingRegistrationEmail)) {
            $this->mailSend('igniter.user::mail.registration', 'customer', $vars);
        }

        if (in_array('admin', $settingRegistrationEmail)) {
            $this->mailSend('igniter.user::mail.registration_alert', 'admin', $vars);
        }
    }

    public function mailSendEmailVerification(array $data): void
    {
        $data = array_merge([
            'account_activation_link' => null,
        ], $data);

        $this->mailSend('igniter.user::mail.activation', 'customer', $data);
    }

    public function mailGetRecipients($type): array
    {
        return match ($type) {
            'customer' => [
                [$this->email, $this->full_name],
            ],
            'admin' => [
                [setting('site_email'), setting('site_name')],
            ],
            default => [],
        };
    }

    public function mailGetData(): array
    {
        $model = $this->fresh();

        return array_merge($model->toArray(), [
            'customer' => $model,
            'full_name' => $model->full_name,
            'email' => $model->email,
        ]);
    }

    #[Override]
    public function register(array $attributes, $activate = false): self
    {
        $model = new self;
        $model->fill($attributes);
        $model->save();

        return $model;
    }

    public function receivesBroadcastNotificationsOn(): string
    {
        return 'main.users.'.$this->getKey();
    }
}

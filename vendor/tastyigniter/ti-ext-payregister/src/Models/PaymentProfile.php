<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Illuminate\Support\Carbon;

/**
 * PaymentProfile Model Class
 *
 * @property int $payment_profile_id
 * @property int|null $customer_id
 * @property int|null $payment_id
 * @property string|null $card_brand
 * @property string|null $card_last4
 * @property array|null $profile_data
 * @property bool $is_primary
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|PaymentProfile query()
 * @method static Builder<static>|PaymentProfile applyCustomer($customer)
 * @mixin Model
 */
class PaymentProfile extends Model
{
    use HasFactory;

    public $timestamps = true;

    public $table = 'payment_profiles';

    protected $primaryKey = 'payment_profile_id';

    protected $casts = [
        'customer_id' => 'integer',
        'payment_id' => 'integer',
        'profile_data' => 'array',
        'is_primary' => 'boolean',
    ];

    public function setProfileData($profileData): void
    {
        $this->profile_data = $profileData;
        $this->save();
    }

    public function hasProfileData()
    {
        return array_has((array)$this->profile_data, ['card_id', 'customer_id']);
    }

    /**
     * Makes this model the default
     */
    public function makePrimary(): void
    {
        $this->timestamps = false;

        $this->newQuery()
            ->where('is_primary', '!=', false)
            ->where('customer_id', $this->customer_id)
            ->update(['is_primary' => false]);

        $this->newQuery()
            ->where('payment_profile_id', $this->payment_profile_id)
            ->where('customer_id', $this->customer_id)
            ->update(['is_primary' => true]);

        $this->timestamps = true;
    }

    public static function getPrimary($customer)
    {
        $profiles = self::query()->applyCustomer($customer)->get();
        foreach ($profiles as $profile) {
            /** @var PaymentProfile $profile */
            if ($profile->is_primary) {
                return $profile;
            }
        }

        return $profiles->first();
    }

    public static function customerHasProfile($customer): bool
    {
        return self::query()->applyCustomer($customer)->count() > 0;
    }

    //
    // Scopes
    //

    public function scopeApplyCustomer($query, $customer)
    {
        if ($customer instanceof \Illuminate\Database\Eloquent\Model) {
            $customer = $customer->getKey();
        }

        return $query->where('customer_id', $customer);
    }
}

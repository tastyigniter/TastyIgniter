<?php

declare(strict_types=1);

namespace Igniter\User\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\System\Models\Concerns\HasCountry;
use Igniter\System\Models\Country;
use Igniter\User\Models\Concerns\HasCustomer;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Address Model Class
 *
 * @property int $address_id
 * @property int|null $customer_id
 * @property string $address_1
 * @property string|null $address_2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $postcode
 * @property int $country_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read mixed $formatted_address
 * @method static Builder<static>|Address query()
 * @method static Builder<static>|LengthAwarePaginator listFrontEnd(array $options = [])
 * @mixin Model
 */
class Address extends Model
{
    use HasCountry;
    use HasCustomer;
    use HasFactory;

    /**
     * @var string The database table name
     */
    protected $table = 'addresses';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'address_id';

    protected $fillable = ['customer_id', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country_id'];

    public $relation = [
        'belongsTo' => [
            'customer' => Customer::class,
            'country' => Country::class,
        ],
    ];

    protected $casts = [
        'customer_id' => 'integer',
        'country_id' => 'integer',
    ];

    protected array $queryModifierFilters = [
        'customer' => 'applyCustomer',
    ];

    protected array $queryModifierSorts = [
        'address_id asc', 'address_id desc',
        'created_at asc', 'created_at desc',
    ];

    public $timestamps = true;

    protected $forceDeleting = false;

    public static function createOrUpdateFromRequest(array $address)
    {
        if (empty($address['address_id'])) {
            return (new self)->query()->create(array_except($address, ['address_id']));
        }

        return (new self)->query()->updateOrCreate(
            array_only($address, ['customer_id', 'address_id']),
            $address,
        );
    }

    //
    // Accessors & Mutators
    //

    public function getFormattedAddressAttribute($value)
    {
        return format_address($this->toArray(), false);
    }
}

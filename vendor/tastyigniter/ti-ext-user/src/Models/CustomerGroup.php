<?php

declare(strict_types=1);

namespace Igniter\User\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Relations\HasMany;
use Igniter\System\Models\Concerns\Defaultable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * CustomerGroup Model Class
 *
 * @property int $customer_group_id
 * @property string $group_name
 * @property string|null $description
 * @property bool $approval
 * @property bool $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection<int, Customer> $customers
 * @property-read int|null $customers_count
 * @method static Builder<static>|CustomerGroup query()
 * @method static Builder<static>|CustomerGroup dropdown(string $column, string $key = null)
 * @method static HasMany<static>|CustomerGroup customers()
 * @property-read mixed $customer_count
 * @mixin Model
 */
class CustomerGroup extends Model
{
    use Defaultable;
    use HasFactory;

    /**
     * @var string The database table name
     */
    protected $table = 'customer_groups';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'customer_group_id';

    protected $casts = [
        'approval' => 'boolean',
    ];

    public $relation = [
        'hasMany' => [
            'customers' => Customer::class,
        ],
    ];

    public $timestamps = true;

    public static function getDropdownOptions()
    {
        return static::dropdown('group_name');
    }

    //
    // Accessors & Mutators
    //

    public function getCustomerCountAttribute($value)
    {
        return $this->customers_count;
    }

    //
    //
    //

    public function requiresApproval(): bool
    {
        return $this->approval == 1;
    }

    public function defaultableName(): string
    {
        return $this->group_name;
    }
}

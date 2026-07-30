<?php

declare(strict_types=1);

namespace Igniter\Cart\Models;

use Igniter\Flame\Database\Model;
use Illuminate\Support\Carbon;

/**
 * Cart Model Class
 *
 * @property string $identifier
 * @property string $instance
 * @property string $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin Model
 */
class Cart extends Model
{
    protected $table = 'igniter_cart_cart';

    protected static $unguarded = true;

    protected $primaryKey = 'identifier';

    public $incrementing = false;

    public $timestamps = true;
}

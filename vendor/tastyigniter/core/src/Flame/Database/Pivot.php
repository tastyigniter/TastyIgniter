<?php

declare(strict_types=1);

namespace Igniter\Flame\Database;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as ModelBase;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

/**
 * @method static Builder<static>|Pivot applyFilters(array $options = [])
 * @method static Builder<static>|Pivot applySorts(array $sorts = [])
 * @method static Builder<static>|Pivot listFrontEnd(array $options = [])
 * @method static Builder<static>|Pivot newModelQuery()
 * @method static Builder<static>|Pivot newQuery()
 * @method static Builder<static>|Pivot query()
 * @mixin ModelBase
 */
class Pivot extends Model
{
    use AsPivot;

    /**
     * The parent model of the relationship.
     */
    protected ?ModelBase $parent = null;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];
}

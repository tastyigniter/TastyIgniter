<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency\Models;

use Igniter\Flame\Currency\Contracts\CurrencyInterface;
use Igniter\Flame\Database\Model;
use Override;

/**
 * @deprecated remove before v5
 * @codeCoverageIgnore
 */
abstract class Currency extends Model implements CurrencyInterface
{
    /**
     * @var string The database table name
     */
    protected $table = 'currencies';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'id';

    public function scopeWhereIsEnabled($query)
    {
        return $query->where('is_enabled', 1);
    }

    #[Override]
    public function getFormat(): string
    {
        return '1,0.00';
    }

    #[Override]
    public function updateRate($rate): void {}
}

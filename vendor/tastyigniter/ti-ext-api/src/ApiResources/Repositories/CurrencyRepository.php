<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Repositories;

use Igniter\Api\Classes\AbstractRepository;
use Igniter\System\Models\Currency;

class CurrencyRepository extends AbstractRepository
{
    protected ?string $modelClass = Currency::class;
}

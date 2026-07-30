<?php

declare(strict_types=1);

namespace Igniter\System\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Override;

/**
 * @method static string addressFormat(Model | array $address, bool $useLineBreaks = true)
 * @method static string|null getCountryNameById(string|int|null $id = null)
 * @method static string|null getCountryCodeById(string|int|null $id = null, string|null $codeType = null)
 * @method static string|null getCountryNameByCode(string $isoCodeTwo)
 * @method static string getDefaultFormat()
 * @method static Collection listAll(string | null $column = null, string $key = 'country_id')
 *
 * @see \Igniter\System\Libraries\Country
 */
class Country extends Facade
{
    /**
     * Get the registered name of the component.
     * @see \Igniter\System\Libraries\Country
     */
    #[Override]
    protected static function getFacadeAccessor(): string
    {
        return 'country';
    }
}

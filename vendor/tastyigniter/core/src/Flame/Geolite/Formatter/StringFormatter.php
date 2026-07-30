<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Formatter;

use Igniter\Flame\Geolite\Model\AdminLevelCollection;
use Igniter\Flame\Geolite\Model\Location;

class StringFormatter
{
    public const STREET_NUMBER = '%n';

    public const STREET_NAME = '%S';

    public const LOCALITY = '%L';

    public const POSTAL_CODE = '%z';

    public const SUB_LOCALITY = '%D';

    public const ADMIN_LEVEL = '%A';

    public const ADMIN_LEVEL_CODE = '%a';

    public const COUNTRY_NAME = '%C';

    public const COUNTRY_CODE = '%c';

    public const TIMEZONE = '%T';

    /**
     * Transform a `Location` instance into a string representation.
     */
    public function format(Location $location, string $format): string
    {
        $replace = [
            self::STREET_NUMBER => $location->getStreetNumber(),
            self::STREET_NAME => $location->getStreetName(),
            self::LOCALITY => $location->getLocality(),
            self::POSTAL_CODE => $location->getPostalCode(),
            self::SUB_LOCALITY => $location->getSubLocality(),
            self::COUNTRY_NAME => $location->getCountryName(),
            self::COUNTRY_CODE => $location->getCountryCode(),
            self::TIMEZONE => $location->getTimezone(),
        ];

        for ($level = 1; $level <= AdminLevelCollection::MAX_LEVEL_DEPTH; $level++) {
            $adminLevel = $location->getAdminLevels()[$level] ?? null;
            $replace[self::ADMIN_LEVEL.$level] = $adminLevel ? $adminLevel->getName() : null;
            $replace[self::ADMIN_LEVEL_CODE.$level] = $adminLevel ? $adminLevel->getCode() : null;
        }

        return strtr($format, $replace);
    }
}

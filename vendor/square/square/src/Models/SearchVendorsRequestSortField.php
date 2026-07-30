<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The field to sort the returned [Vendor]($m/Vendor) objects by.
 */
class SearchVendorsRequestSortField
{
    /**
     * To sort the result by the name of the [Vendor]($m/Vendor) objects.
     */
    public const NAME = 'NAME';

    /**
     * To sort the result by the creation time of the [Vendor]($m/Vendor) objects.
     */
    public const CREATED_AT = 'CREATED_AT';
}

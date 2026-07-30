<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Determines a seller's option on Quick Amounts feature.
 */
class CatalogQuickAmountsSettingsOption
{
    /**
     * Option for seller to disable Quick Amounts.
     */
    public const DISABLED = 'DISABLED';

    /**
     * Option for seller to choose manually created Quick Amounts.
     */
    public const MANUAL = 'MANUAL';

    /**
     * Option for seller to choose automatically created Quick Amounts.
     */
    public const AUTO = 'AUTO';
}

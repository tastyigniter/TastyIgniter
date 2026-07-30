<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the gift card type.
 */
class GiftCardType
{
    /**
     * A plastic gift card.
     */
    public const PHYSICAL = 'PHYSICAL';

    /**
     * A digital gift card.
     */
    public const DIGITAL = 'DIGITAL';
}

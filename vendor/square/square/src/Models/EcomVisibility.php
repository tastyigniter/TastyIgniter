<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Determines item visibility in Ecom (Online Store) and Online Checkout.
 */
class EcomVisibility
{
    /**
     * Item is not synced with Ecom (Weebly). This is the default state
     */
    public const UNINDEXED = 'UNINDEXED';

    /**
     * Item is synced but is unavailable within Ecom (Weebly) and Online Checkout
     */
    public const UNAVAILABLE = 'UNAVAILABLE';

    /**
     * Option for seller to choose manually created Quick Amounts.
     */
    public const HIDDEN = 'HIDDEN';

    /**
     * Item is synced but available within Ecom (Weebly) and Online Checkout but is hidden from Ecom Store.
     */
    public const VISIBLE = 'VISIBLE';
}

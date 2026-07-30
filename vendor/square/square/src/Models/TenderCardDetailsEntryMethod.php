<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the method used to enter the card's details.
 */
class TenderCardDetailsEntryMethod
{
    /**
     * The card was swiped through a Square reader or Square stand.
     */
    public const SWIPED = 'SWIPED';

    /**
     * The card information was keyed manually into Square Point of Sale or a
     * Square-hosted web form.
     */
    public const KEYED = 'KEYED';

    /**
     * The card was processed via EMV with a Square reader.
     */
    public const EMV = 'EMV';

    /**
     * The buyer's card details were already on file with Square.
     */
    public const ON_FILE = 'ON_FILE';

    /**
     * The card was processed via a contactless (i.e., NFC) transaction
     * with a Square reader.
     */
    public const CONTACTLESS = 'CONTACTLESS';
}

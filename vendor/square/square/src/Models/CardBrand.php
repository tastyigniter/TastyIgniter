<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates a card's brand, such as `VISA` or `MASTERCARD`.
 */
class CardBrand
{
    public const OTHER_BRAND = 'OTHER_BRAND';

    public const VISA = 'VISA';

    public const MASTERCARD = 'MASTERCARD';

    public const AMERICAN_EXPRESS = 'AMERICAN_EXPRESS';

    public const DISCOVER = 'DISCOVER';

    public const DISCOVER_DINERS = 'DISCOVER_DINERS';

    public const JCB = 'JCB';

    public const CHINA_UNIONPAY = 'CHINA_UNIONPAY';

    public const SQUARE_GIFT_CARD = 'SQUARE_GIFT_CARD';

    public const SQUARE_CAPITAL_CARD = 'SQUARE_CAPITAL_CARD';

    public const INTERAC = 'INTERAC';

    public const EFTPOS = 'EFTPOS';

    public const FELICA = 'FELICA';

    public const EBT = 'EBT';
}

<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The brand of a credit card.
 */
class V1TenderCardBrand
{
    public const OTHER_BRAND = 'OTHER_BRAND';

    public const VISA = 'VISA';

    public const MASTER_CARD = 'MASTER_CARD';

    public const AMERICAN_EXPRESS = 'AMERICAN_EXPRESS';

    public const DISCOVER = 'DISCOVER';

    public const DISCOVER_DINERS = 'DISCOVER_DINERS';

    public const JCB = 'JCB';

    public const CHINA_UNIONPAY = 'CHINA_UNIONPAY';

    public const SQUARE_GIFT_CARD = 'SQUARE_GIFT_CARD';
}

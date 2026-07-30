<?php

declare(strict_types=1);

namespace Square\Models;

class V1PaymentItemizationItemizationType
{
    public const ITEM = 'ITEM';

    public const CUSTOM_AMOUNT = 'CUSTOM_AMOUNT';

    public const GIFT_CARD_ACTIVATION = 'GIFT_CARD_ACTIVATION';

    public const GIFT_CARD_RELOAD = 'GIFT_CARD_RELOAD';

    public const GIFT_CARD_UNKNOWN = 'GIFT_CARD_UNKNOWN';

    public const OTHER = 'OTHER';
}

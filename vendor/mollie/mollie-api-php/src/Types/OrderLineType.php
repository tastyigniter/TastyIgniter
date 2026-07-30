<?php

namespace Mollie\Api\Types;

class OrderLineType
{
    public const TYPE_PHYSICAL = 'physical';
    public const TYPE_DISCOUNT = 'discount';
    public const TYPE_DIGITAL = 'digital';
    public const TYPE_SHIPPING_FEE = 'shipping_fee';
    public const TYPE_STORE_CREDIT = 'store_credit';
    public const TYPE_GIFT_CARD = 'gift_card';
    public const TYPE_SURCHARGE = 'surcharge';
}

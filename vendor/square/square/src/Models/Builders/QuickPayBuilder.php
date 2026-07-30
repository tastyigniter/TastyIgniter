<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\QuickPay;

/**
 * Builder for model QuickPay
 *
 * @see QuickPay
 */
class QuickPayBuilder
{
    /**
     * @var QuickPay
     */
    private $instance;

    private function __construct(QuickPay $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new quick pay Builder object.
     */
    public static function init(string $name, Money $priceMoney, string $locationId): self
    {
        return new self(new QuickPay($name, $priceMoney, $locationId));
    }

    /**
     * Initializes a new quick pay object.
     */
    public function build(): QuickPay
    {
        return CoreHelper::clone($this->instance);
    }
}

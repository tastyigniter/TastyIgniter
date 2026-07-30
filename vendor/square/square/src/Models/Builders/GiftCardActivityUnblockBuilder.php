<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCardActivityUnblock;

/**
 * Builder for model GiftCardActivityUnblock
 *
 * @see GiftCardActivityUnblock
 */
class GiftCardActivityUnblockBuilder
{
    /**
     * @var GiftCardActivityUnblock
     */
    private $instance;

    private function __construct(GiftCardActivityUnblock $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new gift card activity unblock Builder object.
     */
    public static function init(): self
    {
        return new self(new GiftCardActivityUnblock());
    }

    /**
     * Initializes a new gift card activity unblock object.
     */
    public function build(): GiftCardActivityUnblock
    {
        return CoreHelper::clone($this->instance);
    }
}

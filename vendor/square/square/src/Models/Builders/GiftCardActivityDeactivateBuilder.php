<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GiftCardActivityDeactivate;

/**
 * Builder for model GiftCardActivityDeactivate
 *
 * @see GiftCardActivityDeactivate
 */
class GiftCardActivityDeactivateBuilder
{
    /**
     * @var GiftCardActivityDeactivate
     */
    private $instance;

    private function __construct(GiftCardActivityDeactivate $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new gift card activity deactivate Builder object.
     */
    public static function init(string $reason): self
    {
        return new self(new GiftCardActivityDeactivate($reason));
    }

    /**
     * Initializes a new gift card activity deactivate object.
     */
    public function build(): GiftCardActivityDeactivate
    {
        return CoreHelper::clone($this->instance);
    }
}

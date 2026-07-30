<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyProgramTerminology;

/**
 * Builder for model LoyaltyProgramTerminology
 *
 * @see LoyaltyProgramTerminology
 */
class LoyaltyProgramTerminologyBuilder
{
    /**
     * @var LoyaltyProgramTerminology
     */
    private $instance;

    private function __construct(LoyaltyProgramTerminology $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty program terminology Builder object.
     */
    public static function init(string $one, string $other): self
    {
        return new self(new LoyaltyProgramTerminology($one, $other));
    }

    /**
     * Initializes a new loyalty program terminology object.
     */
    public function build(): LoyaltyProgramTerminology
    {
        return CoreHelper::clone($this->instance);
    }
}

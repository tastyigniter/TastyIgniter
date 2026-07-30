<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1PhoneNumber;

/**
 * Builder for model V1PhoneNumber
 *
 * @see V1PhoneNumber
 */
class V1PhoneNumberBuilder
{
    /**
     * @var V1PhoneNumber
     */
    private $instance;

    private function __construct(V1PhoneNumber $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 phone number Builder object.
     */
    public static function init(string $callingCode, string $number): self
    {
        return new self(new V1PhoneNumber($callingCode, $number));
    }

    /**
     * Initializes a new v1 phone number object.
     */
    public function build(): V1PhoneNumber
    {
        return CoreHelper::clone($this->instance);
    }
}

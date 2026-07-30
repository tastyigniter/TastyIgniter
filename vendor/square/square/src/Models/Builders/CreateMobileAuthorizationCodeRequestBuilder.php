<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateMobileAuthorizationCodeRequest;

/**
 * Builder for model CreateMobileAuthorizationCodeRequest
 *
 * @see CreateMobileAuthorizationCodeRequest
 */
class CreateMobileAuthorizationCodeRequestBuilder
{
    /**
     * @var CreateMobileAuthorizationCodeRequest
     */
    private $instance;

    private function __construct(CreateMobileAuthorizationCodeRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create mobile authorization code request Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateMobileAuthorizationCodeRequest());
    }

    /**
     * Sets location id field.
     */
    public function locationId(?string $value): self
    {
        $this->instance->setLocationId($value);
        return $this;
    }

    /**
     * Initializes a new create mobile authorization code request object.
     */
    public function build(): CreateMobileAuthorizationCodeRequest
    {
        return CoreHelper::clone($this->instance);
    }
}

<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ApplicationDetails;

/**
 * Builder for model ApplicationDetails
 *
 * @see ApplicationDetails
 */
class ApplicationDetailsBuilder
{
    /**
     * @var ApplicationDetails
     */
    private $instance;

    private function __construct(ApplicationDetails $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new application details Builder object.
     */
    public static function init(): self
    {
        return new self(new ApplicationDetails());
    }

    /**
     * Sets square product field.
     */
    public function squareProduct(?string $value): self
    {
        $this->instance->setSquareProduct($value);
        return $this;
    }

    /**
     * Sets application id field.
     */
    public function applicationId(?string $value): self
    {
        $this->instance->setApplicationId($value);
        return $this;
    }

    /**
     * Unsets application id field.
     */
    public function unsetApplicationId(): self
    {
        $this->instance->unsetApplicationId();
        return $this;
    }

    /**
     * Initializes a new application details object.
     */
    public function build(): ApplicationDetails
    {
        return CoreHelper::clone($this->instance);
    }
}

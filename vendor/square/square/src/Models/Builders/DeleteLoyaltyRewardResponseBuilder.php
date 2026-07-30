<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteLoyaltyRewardResponse;

/**
 * Builder for model DeleteLoyaltyRewardResponse
 *
 * @see DeleteLoyaltyRewardResponse
 */
class DeleteLoyaltyRewardResponseBuilder
{
    /**
     * @var DeleteLoyaltyRewardResponse
     */
    private $instance;

    private function __construct(DeleteLoyaltyRewardResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete loyalty reward response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteLoyaltyRewardResponse());
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Initializes a new delete loyalty reward response object.
     */
    public function build(): DeleteLoyaltyRewardResponse
    {
        return CoreHelper::clone($this->instance);
    }
}

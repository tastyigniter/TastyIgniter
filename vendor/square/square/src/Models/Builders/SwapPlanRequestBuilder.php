<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SwapPlanRequest;

/**
 * Builder for model SwapPlanRequest
 *
 * @see SwapPlanRequest
 */
class SwapPlanRequestBuilder
{
    /**
     * @var SwapPlanRequest
     */
    private $instance;

    private function __construct(SwapPlanRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new swap plan request Builder object.
     */
    public static function init(string $newPlanId): self
    {
        return new self(new SwapPlanRequest($newPlanId));
    }

    /**
     * Initializes a new swap plan request object.
     */
    public function build(): SwapPlanRequest
    {
        return CoreHelper::clone($this->instance);
    }
}

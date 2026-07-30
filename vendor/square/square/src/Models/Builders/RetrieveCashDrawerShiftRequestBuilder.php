<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveCashDrawerShiftRequest;

/**
 * Builder for model RetrieveCashDrawerShiftRequest
 *
 * @see RetrieveCashDrawerShiftRequest
 */
class RetrieveCashDrawerShiftRequestBuilder
{
    /**
     * @var RetrieveCashDrawerShiftRequest
     */
    private $instance;

    private function __construct(RetrieveCashDrawerShiftRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve cash drawer shift request Builder object.
     */
    public static function init(string $locationId): self
    {
        return new self(new RetrieveCashDrawerShiftRequest($locationId));
    }

    /**
     * Initializes a new retrieve cash drawer shift request object.
     */
    public function build(): RetrieveCashDrawerShiftRequest
    {
        return CoreHelper::clone($this->instance);
    }
}

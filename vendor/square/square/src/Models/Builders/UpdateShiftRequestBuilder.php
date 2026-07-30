<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Shift;
use Square\Models\UpdateShiftRequest;

/**
 * Builder for model UpdateShiftRequest
 *
 * @see UpdateShiftRequest
 */
class UpdateShiftRequestBuilder
{
    /**
     * @var UpdateShiftRequest
     */
    private $instance;

    private function __construct(UpdateShiftRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update shift request Builder object.
     */
    public static function init(Shift $shift): self
    {
        return new self(new UpdateShiftRequest($shift));
    }

    /**
     * Initializes a new update shift request object.
     */
    public function build(): UpdateShiftRequest
    {
        return CoreHelper::clone($this->instance);
    }
}

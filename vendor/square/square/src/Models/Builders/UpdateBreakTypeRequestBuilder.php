<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BreakType;
use Square\Models\UpdateBreakTypeRequest;

/**
 * Builder for model UpdateBreakTypeRequest
 *
 * @see UpdateBreakTypeRequest
 */
class UpdateBreakTypeRequestBuilder
{
    /**
     * @var UpdateBreakTypeRequest
     */
    private $instance;

    private function __construct(UpdateBreakTypeRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update break type request Builder object.
     */
    public static function init(BreakType $breakType): self
    {
        return new self(new UpdateBreakTypeRequest($breakType));
    }

    /**
     * Initializes a new update break type request object.
     */
    public function build(): UpdateBreakTypeRequest
    {
        return CoreHelper::clone($this->instance);
    }
}

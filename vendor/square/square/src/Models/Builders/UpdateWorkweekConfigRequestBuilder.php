<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\UpdateWorkweekConfigRequest;
use Square\Models\WorkweekConfig;

/**
 * Builder for model UpdateWorkweekConfigRequest
 *
 * @see UpdateWorkweekConfigRequest
 */
class UpdateWorkweekConfigRequestBuilder
{
    /**
     * @var UpdateWorkweekConfigRequest
     */
    private $instance;

    private function __construct(UpdateWorkweekConfigRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update workweek config request Builder object.
     */
    public static function init(WorkweekConfig $workweekConfig): self
    {
        return new self(new UpdateWorkweekConfigRequest($workweekConfig));
    }

    /**
     * Initializes a new update workweek config request object.
     */
    public function build(): UpdateWorkweekConfigRequest
    {
        return CoreHelper::clone($this->instance);
    }
}

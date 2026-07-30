<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\FilterValue;
use Square\Models\SegmentFilter;

/**
 * Builder for model SegmentFilter
 *
 * @see SegmentFilter
 */
class SegmentFilterBuilder
{
    /**
     * @var SegmentFilter
     */
    private $instance;

    private function __construct(SegmentFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new segment filter Builder object.
     */
    public static function init(string $serviceVariationId): self
    {
        return new self(new SegmentFilter($serviceVariationId));
    }

    /**
     * Sets team member id filter field.
     */
    public function teamMemberIdFilter(?FilterValue $value): self
    {
        $this->instance->setTeamMemberIdFilter($value);
        return $this;
    }

    /**
     * Initializes a new segment filter object.
     */
    public function build(): SegmentFilter
    {
        return CoreHelper::clone($this->instance);
    }
}

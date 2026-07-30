<?php

namespace Mollie\Api\Resources;

use Mollie\Api\Types\CapabilityStatus;

class Capability extends BaseResource
{
    /**
     * @var string
     */
    public $resource;

    /**
     * @var string
     *
     * @example payments
     */
    public $name;

    /**
     * @var \stdClass
     */
    public $requirements;

    /**
     * @var string
     *
     * possible values: disabled, pending, enabled
     *
     * @example enabled
     */
    public $status;

    /**
     * @var string
     */
    public $statusReason;

    /**
     * @var string
     */
    public $organizationId;

    /**
     * Links to help navigate through the Mollie API and related resources.
     *
     * @var \stdClass
     */
    public $_links;

    public function isEnabled()
    {
        return $this->status === CapabilityStatus::ENABLED;
    }

    public function isPending()
    {
        return $this->status === CapabilityStatus::PENDING;
    }

    public function isDisabled()
    {
        return $this->status === CapabilityStatus::DISABLED;
    }
}

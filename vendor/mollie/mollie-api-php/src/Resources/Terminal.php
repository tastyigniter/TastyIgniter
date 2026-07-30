<?php

namespace Mollie\Api\Resources;

use Mollie\Api\Types\TerminalStatus;

class Terminal extends BaseResource
{
    /**
     * @var string
     */
    public $resource;

    /**
     * Id of the terminal (on the Mollie platform).
     *
     * @example term_7MgL4wea46qkRcoTZjWEH
     * @var string
     */
    public $id;

    /**
     * The profile ID this terminal belongs to.
     *
     * @example pfl_QkEhN94Ba
     * @var string
     */
    public $profileId;

    /**
     * Mollie determines the read-only status of a terminal as pending,
     * active, or inactive based on its actions. Pending means not activated,
     * active means payments are accepted, and inactive means it is deactivated.
     *
     * @example active
     * @var string
     */
    public $status;

    /**
     * The brand of the terminal.
     *
     * @var string
     */
    public $brand;

    /**
     * The model of the terminal.
     *
     * @var string
     */
    public $model;

    /**
     * The serial number of the terminal. The serial number is provided at terminal creation time.
     *
     * @var string
     */
    public $serialNumber;

    /**
     * The currency which is set for the terminal, in ISO 4217 format.
     *
     * @example EUR
     * @var string
     */
    public $currency;

    /**
     * A short description of the terminal. The description will be visible
     * in the Dashboard, but also on the device itself for identification purposes.
     *
     * @var string
     */
    public $description;

    /**
     * The timezone of the terminal.
     *
     * @example Europe/Brussels
     * @var string
     */
    public $timezone;

    /**
     * This will be a full locale provided by the user.
     *
     * @example nl_NL
     * @var string
     */
    public $locale;

    /**
     * UTC datetime the terminal was created, in ISO 8601 format.
     *
     * @example "2021-12-25T10:30:54+00:00"
     * @var string
     */
    public $createdAt;

    /**
     * UTC datetime the terminal was last updated, in ISO 8601 format.
     *
     * @example "2021-12-25T10:30:54+00:00"
     * @var string
     */
    public $updatedAt;

    /**
     * UTC datetime the terminal was disabled, in ISO 8601 format.
     * This parameter is omitted if the terminal is not disabled yet.
     *
     * @example "2021-12-25T10:30:54+00:00"
     * @var string
     */
    public $disabledAt;

    /**
     * UTC datetime the terminal was activated, in ISO 8601 format.
     * This parameter is omitted if the terminal is not active yet.
     *
     * @example "2021-12-25T10:30:54+00:00"
     * @var string
     */
    public $activatedAt;

    /**
     * Links to help navigate through the Mollie API and related resources.
     *
     * @var \stdClass
     */
    public $_links;

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->status === TerminalStatus::STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->status === TerminalStatus::STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function isInactive()
    {
        return $this->status === TerminalStatus::STATUS_INACTIVE;
    }
}

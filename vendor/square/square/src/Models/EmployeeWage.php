<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The hourly wage rate that an employee earns on a `Shift` for doing the job
 * specified by the `title` property of this object. Deprecated at version 2020-08-26. Use
 * `TeamMemberWage` instead.
 */
class EmployeeWage implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var array
     */
    private $employeeId = [];

    /**
     * @var array
     */
    private $title = [];

    /**
     * @var Money|null
     */
    private $hourlyRate;

    /**
     * Returns Id.
     * The UUID for this object.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The UUID for this object.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Employee Id.
     * The `Employee` that this wage is assigned to.
     */
    public function getEmployeeId(): ?string
    {
        if (count($this->employeeId) == 0) {
            return null;
        }
        return $this->employeeId['value'];
    }

    /**
     * Sets Employee Id.
     * The `Employee` that this wage is assigned to.
     *
     * @maps employee_id
     */
    public function setEmployeeId(?string $employeeId): void
    {
        $this->employeeId['value'] = $employeeId;
    }

    /**
     * Unsets Employee Id.
     * The `Employee` that this wage is assigned to.
     */
    public function unsetEmployeeId(): void
    {
        $this->employeeId = [];
    }

    /**
     * Returns Title.
     * The job title that this wage relates to.
     */
    public function getTitle(): ?string
    {
        if (count($this->title) == 0) {
            return null;
        }
        return $this->title['value'];
    }

    /**
     * Sets Title.
     * The job title that this wage relates to.
     *
     * @maps title
     */
    public function setTitle(?string $title): void
    {
        $this->title['value'] = $title;
    }

    /**
     * Unsets Title.
     * The job title that this wage relates to.
     */
    public function unsetTitle(): void
    {
        $this->title = [];
    }

    /**
     * Returns Hourly Rate.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getHourlyRate(): ?Money
    {
        return $this->hourlyRate;
    }

    /**
     * Sets Hourly Rate.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps hourly_rate
     */
    public function setHourlyRate(?Money $hourlyRate): void
    {
        $this->hourlyRate = $hourlyRate;
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (isset($this->id)) {
            $json['id']          = $this->id;
        }
        if (!empty($this->employeeId)) {
            $json['employee_id'] = $this->employeeId['value'];
        }
        if (!empty($this->title)) {
            $json['title']       = $this->title['value'];
        }
        if (isset($this->hourlyRate)) {
            $json['hourly_rate'] = $this->hourlyRate;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}

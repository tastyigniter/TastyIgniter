<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Shift;
use Square\Models\ShiftWage;

/**
 * Builder for model Shift
 *
 * @see Shift
 */
class ShiftBuilder
{
    /**
     * @var Shift
     */
    private $instance;

    private function __construct(Shift $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new shift Builder object.
     */
    public static function init(string $startAt): self
    {
        return new self(new Shift($startAt));
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets employee id field.
     */
    public function employeeId(?string $value): self
    {
        $this->instance->setEmployeeId($value);
        return $this;
    }

    /**
     * Unsets employee id field.
     */
    public function unsetEmployeeId(): self
    {
        $this->instance->unsetEmployeeId();
        return $this;
    }

    /**
     * Sets location id field.
     */
    public function locationId(?string $value): self
    {
        $this->instance->setLocationId($value);
        return $this;
    }

    /**
     * Unsets location id field.
     */
    public function unsetLocationId(): self
    {
        $this->instance->unsetLocationId();
        return $this;
    }

    /**
     * Sets timezone field.
     */
    public function timezone(?string $value): self
    {
        $this->instance->setTimezone($value);
        return $this;
    }

    /**
     * Unsets timezone field.
     */
    public function unsetTimezone(): self
    {
        $this->instance->unsetTimezone();
        return $this;
    }

    /**
     * Sets end at field.
     */
    public function endAt(?string $value): self
    {
        $this->instance->setEndAt($value);
        return $this;
    }

    /**
     * Unsets end at field.
     */
    public function unsetEndAt(): self
    {
        $this->instance->unsetEndAt();
        return $this;
    }

    /**
     * Sets wage field.
     */
    public function wage(?ShiftWage $value): self
    {
        $this->instance->setWage($value);
        return $this;
    }

    /**
     * Sets breaks field.
     */
    public function breaks(?array $value): self
    {
        $this->instance->setBreaks($value);
        return $this;
    }

    /**
     * Unsets breaks field.
     */
    public function unsetBreaks(): self
    {
        $this->instance->unsetBreaks();
        return $this;
    }

    /**
     * Sets status field.
     */
    public function status(?string $value): self
    {
        $this->instance->setStatus($value);
        return $this;
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Sets team member id field.
     */
    public function teamMemberId(?string $value): self
    {
        $this->instance->setTeamMemberId($value);
        return $this;
    }

    /**
     * Unsets team member id field.
     */
    public function unsetTeamMemberId(): self
    {
        $this->instance->unsetTeamMemberId();
        return $this;
    }

    /**
     * Initializes a new shift object.
     */
    public function build(): Shift
    {
        return CoreHelper::clone($this->instance);
    }
}

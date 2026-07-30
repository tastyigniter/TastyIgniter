<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\InventoryTransfer;
use Square\Models\SourceApplication;

/**
 * Builder for model InventoryTransfer
 *
 * @see InventoryTransfer
 */
class InventoryTransferBuilder
{
    /**
     * @var InventoryTransfer
     */
    private $instance;

    private function __construct(InventoryTransfer $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new inventory transfer Builder object.
     */
    public static function init(): self
    {
        return new self(new InventoryTransfer());
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
     * Sets reference id field.
     */
    public function referenceId(?string $value): self
    {
        $this->instance->setReferenceId($value);
        return $this;
    }

    /**
     * Unsets reference id field.
     */
    public function unsetReferenceId(): self
    {
        $this->instance->unsetReferenceId();
        return $this;
    }

    /**
     * Sets state field.
     */
    public function state(?string $value): self
    {
        $this->instance->setState($value);
        return $this;
    }

    /**
     * Sets from location id field.
     */
    public function fromLocationId(?string $value): self
    {
        $this->instance->setFromLocationId($value);
        return $this;
    }

    /**
     * Unsets from location id field.
     */
    public function unsetFromLocationId(): self
    {
        $this->instance->unsetFromLocationId();
        return $this;
    }

    /**
     * Sets to location id field.
     */
    public function toLocationId(?string $value): self
    {
        $this->instance->setToLocationId($value);
        return $this;
    }

    /**
     * Unsets to location id field.
     */
    public function unsetToLocationId(): self
    {
        $this->instance->unsetToLocationId();
        return $this;
    }

    /**
     * Sets catalog object id field.
     */
    public function catalogObjectId(?string $value): self
    {
        $this->instance->setCatalogObjectId($value);
        return $this;
    }

    /**
     * Unsets catalog object id field.
     */
    public function unsetCatalogObjectId(): self
    {
        $this->instance->unsetCatalogObjectId();
        return $this;
    }

    /**
     * Sets catalog object type field.
     */
    public function catalogObjectType(?string $value): self
    {
        $this->instance->setCatalogObjectType($value);
        return $this;
    }

    /**
     * Unsets catalog object type field.
     */
    public function unsetCatalogObjectType(): self
    {
        $this->instance->unsetCatalogObjectType();
        return $this;
    }

    /**
     * Sets quantity field.
     */
    public function quantity(?string $value): self
    {
        $this->instance->setQuantity($value);
        return $this;
    }

    /**
     * Unsets quantity field.
     */
    public function unsetQuantity(): self
    {
        $this->instance->unsetQuantity();
        return $this;
    }

    /**
     * Sets occurred at field.
     */
    public function occurredAt(?string $value): self
    {
        $this->instance->setOccurredAt($value);
        return $this;
    }

    /**
     * Unsets occurred at field.
     */
    public function unsetOccurredAt(): self
    {
        $this->instance->unsetOccurredAt();
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
     * Sets source field.
     */
    public function source(?SourceApplication $value): self
    {
        $this->instance->setSource($value);
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
     * Initializes a new inventory transfer object.
     */
    public function build(): InventoryTransfer
    {
        return CoreHelper::clone($this->instance);
    }
}

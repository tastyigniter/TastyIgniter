<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Dispute;
use Square\Models\DisputedPayment;
use Square\Models\Money;

/**
 * Builder for model Dispute
 *
 * @see Dispute
 */
class DisputeBuilder
{
    /**
     * @var Dispute
     */
    private $instance;

    private function __construct(Dispute $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new dispute Builder object.
     */
    public static function init(): self
    {
        return new self(new Dispute());
    }

    /**
     * Sets dispute id field.
     */
    public function disputeId(?string $value): self
    {
        $this->instance->setDisputeId($value);
        return $this;
    }

    /**
     * Unsets dispute id field.
     */
    public function unsetDisputeId(): self
    {
        $this->instance->unsetDisputeId();
        return $this;
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
     * Sets amount money field.
     */
    public function amountMoney(?Money $value): self
    {
        $this->instance->setAmountMoney($value);
        return $this;
    }

    /**
     * Sets reason field.
     */
    public function reason(?string $value): self
    {
        $this->instance->setReason($value);
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
     * Sets due at field.
     */
    public function dueAt(?string $value): self
    {
        $this->instance->setDueAt($value);
        return $this;
    }

    /**
     * Unsets due at field.
     */
    public function unsetDueAt(): self
    {
        $this->instance->unsetDueAt();
        return $this;
    }

    /**
     * Sets disputed payment field.
     */
    public function disputedPayment(?DisputedPayment $value): self
    {
        $this->instance->setDisputedPayment($value);
        return $this;
    }

    /**
     * Sets evidence ids field.
     */
    public function evidenceIds(?array $value): self
    {
        $this->instance->setEvidenceIds($value);
        return $this;
    }

    /**
     * Unsets evidence ids field.
     */
    public function unsetEvidenceIds(): self
    {
        $this->instance->unsetEvidenceIds();
        return $this;
    }

    /**
     * Sets card brand field.
     */
    public function cardBrand(?string $value): self
    {
        $this->instance->setCardBrand($value);
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
     * Sets brand dispute id field.
     */
    public function brandDisputeId(?string $value): self
    {
        $this->instance->setBrandDisputeId($value);
        return $this;
    }

    /**
     * Unsets brand dispute id field.
     */
    public function unsetBrandDisputeId(): self
    {
        $this->instance->unsetBrandDisputeId();
        return $this;
    }

    /**
     * Sets reported date field.
     */
    public function reportedDate(?string $value): self
    {
        $this->instance->setReportedDate($value);
        return $this;
    }

    /**
     * Unsets reported date field.
     */
    public function unsetReportedDate(): self
    {
        $this->instance->unsetReportedDate();
        return $this;
    }

    /**
     * Sets reported at field.
     */
    public function reportedAt(?string $value): self
    {
        $this->instance->setReportedAt($value);
        return $this;
    }

    /**
     * Unsets reported at field.
     */
    public function unsetReportedAt(): self
    {
        $this->instance->unsetReportedAt();
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
     * Initializes a new dispute object.
     */
    public function build(): Dispute
    {
        return CoreHelper::clone($this->instance);
    }
}

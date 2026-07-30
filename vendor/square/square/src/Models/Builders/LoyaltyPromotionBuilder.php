<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyPromotion;
use Square\Models\LoyaltyPromotionAvailableTimeData;
use Square\Models\LoyaltyPromotionIncentive;
use Square\Models\LoyaltyPromotionTriggerLimit;
use Square\Models\Money;

/**
 * Builder for model LoyaltyPromotion
 *
 * @see LoyaltyPromotion
 */
class LoyaltyPromotionBuilder
{
    /**
     * @var LoyaltyPromotion
     */
    private $instance;

    private function __construct(LoyaltyPromotion $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty promotion Builder object.
     */
    public static function init(
        string $name,
        LoyaltyPromotionIncentive $incentive,
        LoyaltyPromotionAvailableTimeData $availableTime
    ): self {
        return new self(new LoyaltyPromotion($name, $incentive, $availableTime));
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
     * Sets trigger limit field.
     */
    public function triggerLimit(?LoyaltyPromotionTriggerLimit $value): self
    {
        $this->instance->setTriggerLimit($value);
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
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets canceled at field.
     */
    public function canceledAt(?string $value): self
    {
        $this->instance->setCanceledAt($value);
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
     * Sets loyalty program id field.
     */
    public function loyaltyProgramId(?string $value): self
    {
        $this->instance->setLoyaltyProgramId($value);
        return $this;
    }

    /**
     * Sets minimum spend amount money field.
     */
    public function minimumSpendAmountMoney(?Money $value): self
    {
        $this->instance->setMinimumSpendAmountMoney($value);
        return $this;
    }

    /**
     * Sets qualifying item variation ids field.
     */
    public function qualifyingItemVariationIds(?array $value): self
    {
        $this->instance->setQualifyingItemVariationIds($value);
        return $this;
    }

    /**
     * Unsets qualifying item variation ids field.
     */
    public function unsetQualifyingItemVariationIds(): self
    {
        $this->instance->unsetQualifyingItemVariationIds();
        return $this;
    }

    /**
     * Sets qualifying category ids field.
     */
    public function qualifyingCategoryIds(?array $value): self
    {
        $this->instance->setQualifyingCategoryIds($value);
        return $this;
    }

    /**
     * Unsets qualifying category ids field.
     */
    public function unsetQualifyingCategoryIds(): self
    {
        $this->instance->unsetQualifyingCategoryIds();
        return $this;
    }

    /**
     * Initializes a new loyalty promotion object.
     */
    public function build(): LoyaltyPromotion
    {
        return CoreHelper::clone($this->instance);
    }
}

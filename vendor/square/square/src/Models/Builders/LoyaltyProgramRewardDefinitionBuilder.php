<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyProgramRewardDefinition;
use Square\Models\Money;

/**
 * Builder for model LoyaltyProgramRewardDefinition
 *
 * @see LoyaltyProgramRewardDefinition
 */
class LoyaltyProgramRewardDefinitionBuilder
{
    /**
     * @var LoyaltyProgramRewardDefinition
     */
    private $instance;

    private function __construct(LoyaltyProgramRewardDefinition $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty program reward definition Builder object.
     */
    public static function init(string $scope, string $discountType): self
    {
        return new self(new LoyaltyProgramRewardDefinition($scope, $discountType));
    }

    /**
     * Sets percentage discount field.
     */
    public function percentageDiscount(?string $value): self
    {
        $this->instance->setPercentageDiscount($value);
        return $this;
    }

    /**
     * Sets catalog object ids field.
     */
    public function catalogObjectIds(?array $value): self
    {
        $this->instance->setCatalogObjectIds($value);
        return $this;
    }

    /**
     * Sets fixed discount money field.
     */
    public function fixedDiscountMoney(?Money $value): self
    {
        $this->instance->setFixedDiscountMoney($value);
        return $this;
    }

    /**
     * Sets max discount money field.
     */
    public function maxDiscountMoney(?Money $value): self
    {
        $this->instance->setMaxDiscountMoney($value);
        return $this;
    }

    /**
     * Initializes a new loyalty program reward definition object.
     */
    public function build(): LoyaltyProgramRewardDefinition
    {
        return CoreHelper::clone($this->instance);
    }
}

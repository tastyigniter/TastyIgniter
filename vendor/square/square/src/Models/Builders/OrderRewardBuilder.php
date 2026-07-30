<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\OrderReward;

/**
 * Builder for model OrderReward
 *
 * @see OrderReward
 */
class OrderRewardBuilder
{
    /**
     * @var OrderReward
     */
    private $instance;

    private function __construct(OrderReward $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order reward Builder object.
     */
    public static function init(string $id, string $rewardTierId): self
    {
        return new self(new OrderReward($id, $rewardTierId));
    }

    /**
     * Initializes a new order reward object.
     */
    public function build(): OrderReward
    {
        return CoreHelper::clone($this->instance);
    }
}

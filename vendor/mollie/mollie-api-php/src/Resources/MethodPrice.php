<?php

namespace Mollie\Api\Resources;

class MethodPrice extends BaseResource
{
    /**
     * The area or product-type where the pricing is applied for, translated in the optional locale passed.
     *
     * @example "The Netherlands"
     * @var string
     */
    public $description;

    /**
     * The fixed price per transaction. This excludes the variable amount.
     *
     * @var \stdClass An amount object consisting of `value` and `currency`
     */
    public $fixed;

    /**
     * A string containing the percentage being charged over the payment amount besides the fixed price.
     *
     * @var string An string representing the percentage as a float (for example: "0.1" for 10%)
     */
    public $variable;
}

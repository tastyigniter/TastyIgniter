<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ReceiptOptions;

/**
 * Builder for model ReceiptOptions
 *
 * @see ReceiptOptions
 */
class ReceiptOptionsBuilder
{
    /**
     * @var ReceiptOptions
     */
    private $instance;

    private function __construct(ReceiptOptions $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new receipt options Builder object.
     */
    public static function init(string $paymentId): self
    {
        return new self(new ReceiptOptions($paymentId));
    }

    /**
     * Sets print only field.
     */
    public function printOnly(?bool $value): self
    {
        $this->instance->setPrintOnly($value);
        return $this;
    }

    /**
     * Unsets print only field.
     */
    public function unsetPrintOnly(): self
    {
        $this->instance->unsetPrintOnly();
        return $this;
    }

    /**
     * Sets is duplicate field.
     */
    public function isDuplicate(?bool $value): self
    {
        $this->instance->setIsDuplicate($value);
        return $this;
    }

    /**
     * Unsets is duplicate field.
     */
    public function unsetIsDuplicate(): self
    {
        $this->instance->unsetIsDuplicate();
        return $this;
    }

    /**
     * Initializes a new receipt options object.
     */
    public function build(): ReceiptOptions
    {
        return CoreHelper::clone($this->instance);
    }
}

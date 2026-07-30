<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency\Contracts;

interface FormatterInterface
{
    /**
     * Format the value into the desired currency.
     */
    public function format(float $value, ?string $code = null): string;
}

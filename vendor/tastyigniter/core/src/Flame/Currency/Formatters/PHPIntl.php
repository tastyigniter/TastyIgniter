<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency\Formatters;

use Igniter\Flame\Currency\Contracts\FormatterInterface;
use NumberFormatter;
use Override;

class PHPIntl implements FormatterInterface
{
    /**
     * Number formatter instance.
     */
    protected NumberFormatter $formatter;

    /**
     * Create a new instance.
     */
    public function __construct()
    {
        $this->formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
    }

    #[Override]
    public function format(float $value, ?string $code = null): string
    {
        return $this->formatter->formatCurrency($value, $code);
    }
}

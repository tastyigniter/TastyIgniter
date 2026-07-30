<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Constraints\Factory;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class MaximumConstraint implements ConstraintInterface
{
    use ErrorBagProxy;

    public function __construct(?Factory $factory = null)
    {
        $this->initialiseErrorBag($factory ?: new Factory());
    }

    public function check(&$value, $schema = null, ?JsonPointer $path = null, $i = null): void
    {
        if (!property_exists($schema, 'maximum')) {
            return;
        }

        if (!is_numeric($value)) {
            return;
        }

        if ($value <= $schema->maximum) {
            return;
        }

        $this->addError(ConstraintError::MAXIMUM(), $path, ['maximum' => $schema->maximum, 'found' => $value]);
    }
}

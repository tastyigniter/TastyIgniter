<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Constraints\Factory;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class ExclusiveMinimumConstraint implements ConstraintInterface
{
    use ErrorBagProxy;

    public function __construct(?Factory $factory = null)
    {
        $this->initialiseErrorBag($factory ?: new Factory());
    }

    public function check(&$value, $schema = null, ?JsonPointer $path = null, $i = null): void
    {
        if (!property_exists($schema, 'exclusiveMinimum')) {
            return;
        }

        if (!is_numeric($value)) {
            return;
        }

        if ($value > $schema->exclusiveMinimum) {
            return;
        }

        $this->addError(ConstraintError::EXCLUSIVE_MINIMUM(), $path, ['exclusiveMinimum' => $schema->exclusiveMinimum, 'found' => $value]);
    }
}

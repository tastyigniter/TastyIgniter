<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Constraints\Factory;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;
use JsonSchema\Tool\DeepComparer;

class UniqueItemsConstraint implements ConstraintInterface
{
    use ErrorBagProxy;

    public function __construct(?Factory $factory = null)
    {
        $this->initialiseErrorBag($factory ?: new Factory());
    }

    public function check(&$value, $schema = null, ?JsonPointer $path = null, $i = null): void
    {
        if (!property_exists($schema, 'uniqueItems')) {
            return;
        }
        if (!is_array($value)) {
            return;
        }

        if ($schema->uniqueItems !== true) {
            // If unique items not is true duplicates are allowed.
            return;
        }

        $count = count($value);
        for ($x = 0; $x < $count - 1; $x++) {
            for ($y = $x + 1; $y < $count; $y++) {
                if (DeepComparer::isEqual($value[$x], $value[$y])) {
                    $this->addError(ConstraintError::UNIQUE_ITEMS(), $path);

                    return;
                }
            }
        }
    }
}

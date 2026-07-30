<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Constraints\Factory;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class TypeConstraint implements ConstraintInterface
{
    use ErrorBagProxy;

    public function __construct(?Factory $factory = null)
    {
        $this->initialiseErrorBag($factory ?: new Factory());
    }

    public function check(&$value, $schema = null, ?JsonPointer $path = null, $i = null): void
    {
        if (!property_exists($schema, 'type')) {
            return;
        }

        $schemaTypes = (array) $schema->type;
        $valueType = strtolower(gettype($value));
        // All specific number types are a number
        $valueIsNumber = $valueType === 'double' ||  $valueType === 'integer';
        // A float with zero fractional part is an integer
        $isInteger = $valueIsNumber && fmod($value, 1.0) === 0.0;

        foreach ($schemaTypes as $type) {
            if ($valueType === $type) {
                return;
            }

            if ($type === 'number' && $valueIsNumber) {
                return;
            }
            if ($type === 'integer' && $isInteger) {
                return;
            }
        }

        $this->addError(ConstraintError::TYPE(), $path, ['found' => $valueType, 'expected' => implode(', ', $schemaTypes)]);
    }
}

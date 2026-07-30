<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Constraints\Factory;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;
use JsonSchema\Tool\DeepComparer;

class EnumConstraint implements ConstraintInterface
{
    use ErrorBagProxy;

    public function __construct(?Factory $factory = null)
    {
        $this->initialiseErrorBag($factory ?: new Factory());
    }

    public function check(&$value, $schema = null, ?JsonPointer $path = null, $i = null): void
    {
        if (!property_exists($schema, 'enum')) {
            return;
        }

        foreach ($schema->enum as $enumCase) {
            if (DeepComparer::isEqual($value, $enumCase)) {
                return;
            }

            if (is_numeric($value) && is_numeric($enumCase) && DeepComparer::isEqual((float) $value, (float) $enumCase)) {
                return;
            }
        }

        $this->addError(ConstraintError::ENUM(), $path, ['enum' => $schema->enum]);
    }
}

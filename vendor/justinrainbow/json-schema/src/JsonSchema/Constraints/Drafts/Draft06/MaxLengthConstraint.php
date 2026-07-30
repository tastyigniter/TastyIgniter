<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Constraints\Factory;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class MaxLengthConstraint implements ConstraintInterface
{
    use ErrorBagProxy;

    public function __construct(?Factory $factory = null)
    {
        $this->initialiseErrorBag($factory ?: new Factory());
    }

    public function check(&$value, $schema = null, ?JsonPointer $path = null, $i = null): void
    {
        if (!property_exists($schema, 'maxLength')) {
            return;
        }

        if (!is_string($value)) {
            return;
        }

        $length = mb_strlen($value);
        if ($length <= $schema->maxLength) {
            return;
        }

        $this->addError(ConstraintError::LENGTH_MAX(), $path, ['maxLength' => $schema->maxLength, 'found' => $length]);
    }
}

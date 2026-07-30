<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Constraints\Factory;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class MaxItemsConstraint implements ConstraintInterface
{
    use ErrorBagProxy;

    public function __construct(?Factory $factory = null)
    {
        $this->initialiseErrorBag($factory ?: new Factory());
    }

    public function check(&$value, $schema = null, ?JsonPointer $path = null, $i = null): void
    {
        if (!property_exists($schema, 'maxItems')) {
            return;
        }

        if (!is_array($value)) {
            return;
        }

        $count = count($value);
        if ($count <= $schema->maxItems) {
            return;
        }

        $this->addError(ConstraintError::MAX_ITEMS(), $path, ['maxItems' => $schema->maxItems, 'found' => $count]);
    }
}

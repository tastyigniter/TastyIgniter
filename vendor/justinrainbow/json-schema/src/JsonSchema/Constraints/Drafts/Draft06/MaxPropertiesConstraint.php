<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Constraints\Factory;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class MaxPropertiesConstraint implements ConstraintInterface
{
    use ErrorBagProxy;

    public function __construct(?Factory $factory = null)
    {
        $this->initialiseErrorBag($factory ?: new Factory());
    }

    public function check(&$value, $schema = null, ?JsonPointer $path = null, $i = null): void
    {
        if (!property_exists($schema, 'maxProperties')) {
            return;
        }

        if (!is_object($value)) {
            return;
        }

        $count = count(get_object_vars($value));
        if ($count <= $schema->maxProperties) {
            return;
        }

        $this->addError(ConstraintError::PROPERTIES_MAX(), $path, ['maxProperties' => $schema->maxProperties, 'found' => $count]);
    }
}

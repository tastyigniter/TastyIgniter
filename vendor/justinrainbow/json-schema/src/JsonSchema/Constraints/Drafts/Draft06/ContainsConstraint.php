<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class ContainsConstraint implements ConstraintInterface
{
    use ErrorBagProxy;

    /** @var Factory */
    private $factory;

    public function __construct(?Factory $factory = null)
    {
        $this->factory = $factory ?: new Factory();
        $this->initialiseErrorBag($this->factory);
    }

    public function check(&$value, $schema = null, ?JsonPointer $path = null, $i = null): void
    {
        if (!property_exists($schema, 'contains')) {
            return;
        }

        $properties = [];
        if (!is_array($value)) {
            return;
        }

        foreach ($value as $propertyName => $propertyValue) {
            $schemaConstraint = $this->factory->createInstanceFor('schema');

            $schemaConstraint->check($propertyValue, $schema->contains, $path, $i);
            if ($schemaConstraint->isValid()) {
                return;
            }
        }

        $this->addError(ConstraintError::CONTAINS(), $path, ['contains' => $schema->contains]);
    }
}

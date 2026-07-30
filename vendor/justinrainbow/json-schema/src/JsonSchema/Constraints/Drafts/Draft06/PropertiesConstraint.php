<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class PropertiesConstraint implements ConstraintInterface
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
        if (!property_exists($schema, 'properties')) {
            return;
        }

        if (!is_object($value)) {
            return;
        }

        foreach ($schema->properties as $propertyName => $propertySchema) {
            $schemaConstraint = $this->factory->createInstanceFor('schema');
            if (!property_exists($value, $propertyName)) {
                continue;
            }

            $schemaConstraint->check($value->{$propertyName}, $propertySchema, $path, $i);
            if ($schemaConstraint->isValid()) {
                continue;
            }

            $this->addErrors($schemaConstraint->getErrors());
        }
    }
}

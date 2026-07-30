<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class ItemsConstraint implements ConstraintInterface
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
        if (!property_exists($schema, 'items')) {
            return;
        }

        if (!is_array($value)) {
            return;
        }

        foreach ($value as $propertyName => $propertyValue) {
            $itemSchema = $schema->items;
            if (is_array($itemSchema)) {
                if (!array_key_exists($propertyName, $itemSchema)) {
                    continue;
                }

                $itemSchema  = $itemSchema[$propertyName];
            }
            $schemaConstraint = $this->factory->createInstanceFor('schema');
            $schemaConstraint->check($propertyValue, $itemSchema, $path, $i);
            if ($schemaConstraint->isValid()) {
                continue;
            }

            $this->addErrors($schemaConstraint->getErrors());
        }
    }
}

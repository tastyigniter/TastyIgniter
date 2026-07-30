<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft2019;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class AdditionalItemsConstraint implements ConstraintInterface
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
        if (!property_exists($schema, 'additionalItems')) {
            return;
        }

        if ($schema->additionalItems === true) {
            return;
        }
        if ($schema->additionalItems === false && !property_exists($schema, 'items')) {
            return;
        }

        if (!is_array($value)) {
            return;
        }
        if (!property_exists($schema, 'items')) {
            return;
        }
        if (is_object($schema->items)) {
            return;
        }

        $additionalItems = array_diff_key($value, property_exists($schema, 'items') ? $schema->items : []);
        $basePath = $path ?? new JsonPointer('');

        foreach ($additionalItems as $propertyName => $propertyValue) {
            $incrementedPath = $basePath->withPropertyPaths(array_merge($basePath->getPropertyPaths(), [$propertyName]));

            $schemaConstraint = $this->factory->createInstanceFor('schema');
            $schemaConstraint->check($propertyValue, $schema->additionalItems, $incrementedPath, $i);

            if ($schemaConstraint->isValid()) {
                continue;
            }

            $this->addError(ConstraintError::ADDITIONAL_ITEMS(), $incrementedPath, ['item' => $i, 'property' => $propertyName, 'additionalItems' => $schema->additionalItems]);
        }
    }
}

<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class AllOfConstraint implements ConstraintInterface
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
        if (!property_exists($schema, 'allOf')) {
            return;
        }

        foreach ($schema->allOf as $allOfSchema) {
            $schemaConstraint = $this->factory->createInstanceFor('schema');
            $schemaConstraint->check($value, $allOfSchema, $path, $i);

            if ($schemaConstraint->isValid()) {
                continue;
            }
            $this->addError(ConstraintError::ALL_OF(), $path);
            $this->addErrors($schemaConstraint->getErrors());
        }
    }
}

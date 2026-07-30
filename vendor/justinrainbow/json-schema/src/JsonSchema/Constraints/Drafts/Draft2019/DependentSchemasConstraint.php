<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft2019;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class DependentSchemasConstraint implements ConstraintInterface
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
        if (!property_exists($schema, 'dependentSchemas')) {
            return;
        }

        if (!is_object($value)) {
            return;
        }

        foreach ($schema->dependentSchemas as $dependant => $dependentSchema) {
            if (!property_exists($value, $dependant)) {
                continue;
            }

            if ($dependentSchema === true) {
                continue;
            }

            if ($dependentSchema === false) {
                $this->addError(ConstraintError::FALSE(), $path, ['dependant' => $dependant]);
                continue;
            }

            if (is_object($dependentSchema)) {
                $schemaConstraint = $this->factory->createInstanceFor('schema');
                $schemaConstraint->check($value, $dependentSchema, $path, $i);
                if (!$schemaConstraint->isValid()) {
                    $this->addErrors($schemaConstraint->getErrors());
                }
            }
        }
    }
}

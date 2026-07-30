<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class OneOfConstraint implements ConstraintInterface
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
        if (!property_exists($schema, 'oneOf')) {
            return;
        }

        $matchedSchema = 0;
        foreach ($schema->oneOf as $oneOfSchema) {
            $schemaConstraint = $this->factory->createInstanceFor('schema');
            $schemaConstraint->check($value, $oneOfSchema, $path, $i);

            if ($schemaConstraint->isValid()) {
                $matchedSchema++;
                continue;
            }

            $this->addErrors($schemaConstraint->getErrors());
        }

        if ($matchedSchema !== 1) {
            $this->addError(ConstraintError::ONE_OF(), $path);
        } else {
            $this->errorBag()->reset();
        }
    }
}

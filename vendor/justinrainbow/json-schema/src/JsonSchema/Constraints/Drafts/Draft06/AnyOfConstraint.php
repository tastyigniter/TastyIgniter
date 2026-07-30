<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;
use JsonSchema\Exception\ValidationException;

class AnyOfConstraint implements ConstraintInterface
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
        if (!property_exists($schema, 'anyOf')) {
            return;
        }

        foreach ($schema->anyOf as $anyOfSchema) {
            $schemaConstraint = $this->factory->createInstanceFor('schema');

            try {
                $schemaConstraint->check($value, $anyOfSchema, $path, $i);

                if ($schemaConstraint->isValid()) {
                    $this->errorBag()->reset();

                    return;
                }

                $this->addErrors($schemaConstraint->getErrors());
            } catch (ValidationException $e) {
            }
        }

        $this->addError(ConstraintError::ANY_OF(), $path);
    }
}

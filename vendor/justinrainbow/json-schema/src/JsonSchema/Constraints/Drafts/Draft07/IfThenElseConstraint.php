<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft07;

use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class IfThenElseConstraint implements ConstraintInterface
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
        if (!property_exists($schema, 'if')) {
            return;
        }

        $schemaConstraint = $this->factory->createInstanceFor('schema');
        $ifSchema = $schema->if;

        if (!is_bool($ifSchema)) {
            $schemaConstraint->check($value, $ifSchema, $path, $i);
            $meetsIfConditions = $schemaConstraint->isValid();
            $schemaConstraint->reset();
        } else {
            $meetsIfConditions = $ifSchema;
        }

        if ($meetsIfConditions) {
            if (!property_exists($schema, 'then')) {
                return;
            }

            $schemaConstraint->check($value, $schema->then, $path, $i);
            if ($schemaConstraint->isValid()) {
                return;
            }

            $this->addErrors($schemaConstraint->getErrors());

            return;
        }

        if (!property_exists($schema, 'else')) {
            return;
        }

        $schemaConstraint->check($value, $schema->else, $path, $i);
        if ($schemaConstraint->isValid()) {
            return;
        }

        $this->addErrors($schemaConstraint->getErrors());
    }
}

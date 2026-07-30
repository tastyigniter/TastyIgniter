<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class RefConstraint implements ConstraintInterface
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
        if (!property_exists($schema, '$ref')) {
            return;
        }

        try {
            $refSchema = $this->factory->getSchemaStorage()->resolveRefSchema($schema);
        } catch (\Exception $e) {
            return;
        }

        $schemaConstraint = $this->factory->createInstanceFor('schema');
        $schemaConstraint->check($value, $refSchema, $path, $i);

        if ($schemaConstraint->isValid()) {
            return;
        }

        $this->addErrors($schemaConstraint->getErrors());
    }
}

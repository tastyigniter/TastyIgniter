<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class NotConstraint implements ConstraintInterface
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
        if (!property_exists($schema, 'not')) {
            return;
        }

        $schemaConstraint = $this->factory->createInstanceFor('schema');
        $schemaConstraint->check($value, $schema->not, $path, $i);

        if (!$schemaConstraint->isValid()) {
            return;
        }

        $this->addError(ConstraintError::NOT(), $path);
    }
}

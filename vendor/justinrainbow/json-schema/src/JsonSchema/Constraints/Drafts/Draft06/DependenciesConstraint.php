<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class DependenciesConstraint implements ConstraintInterface
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
        if (!property_exists($schema, 'dependencies')) {
            return;
        }

        if (!is_object($value)) {
            return;
        }

        foreach ($schema->dependencies as $dependant => $dependencies) {
            if (!property_exists($value, $dependant)) {
                continue;
            }
            if ($dependencies === true) {
                continue;
            }
            if ($dependencies === false) {
                $this->addError(ConstraintError::FALSE(), $path, ['dependant' => $dependant]);
                continue;
            }

            if (is_array($dependencies)) {
                foreach ($dependencies as $dependency) {
                    if (property_exists($value, $dependant) && !property_exists($value, $dependency)) {
                        $this->addError(ConstraintError::DEPENDENCIES(), $path, ['dependant' => $dependant, 'dependency' => $dependency]);
                    }
                }
            }

            if (is_object($dependencies)) {
                $schemaConstraint = $this->factory->createInstanceFor('schema');
                $schemaConstraint->check($value, $dependencies, $path, $i);
                if (!$schemaConstraint->isValid()) {
                    $this->addErrors($schemaConstraint->getErrors());
                }
            }
        }
    }
}

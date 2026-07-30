<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft2019;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class DependentRequiredConstraint implements ConstraintInterface
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
        if (!property_exists($schema, 'dependentRequired')) {
            return;
        }

        if (!is_object($value)) {
            return;
        }

        foreach ($schema->dependentRequired as $dependant => $dependencies) {
            if (!property_exists($value, $dependant)) {
                continue;
            }

            foreach ($dependencies as $dependency) {
                if (!property_exists($value, $dependency)) {
                    $this->addError(ConstraintError::DEPENDENCIES(), $path, [
                        'dependant' => $dependant,
                        'dependency' => $dependency,
                    ]);
                }
            }
        }
    }
}

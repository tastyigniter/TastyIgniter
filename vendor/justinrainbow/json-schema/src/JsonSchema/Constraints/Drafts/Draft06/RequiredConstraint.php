<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Constraints\Factory;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class RequiredConstraint implements ConstraintInterface
{
    use ErrorBagProxy;

    public function __construct(?Factory $factory = null)
    {
        $this->initialiseErrorBag($factory ?: new Factory());
    }

    public function check(&$value, $schema = null, ?JsonPointer $path = null, $i = null): void
    {
        if (!property_exists($schema, 'required')) {
            return;
        }

        if (!is_object($value)) {
            return;
        }

        foreach ($schema->required as $required) {
            if (property_exists($value, $required)) {
                continue;
            }

            $this->addError(ConstraintError::REQUIRED(), $this->incrementPath($path, $required), ['property' => $required]);
        }
    }

    /**
     * @todo refactor as this was only copied from UndefinedConstraint
     * Bubble down the path
     *
     * @param JsonPointer|null $path Current path
     * @param mixed            $i    What to append to the path
     */
    protected function incrementPath(?JsonPointer $path, $i): JsonPointer
    {
        $path = $path ?? new JsonPointer('');

        if ($i === null || $i === '') {
            return $path;
        }

        return $path->withPropertyPaths(array_merge($path->getPropertyPaths(), [$i]));
    }
}

<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft07;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class PropertiesNamesConstraint implements ConstraintInterface
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
        if (!property_exists($schema, 'propertyNames')) {
            return;
        }

        if (!is_object($value)) {
            return;
        }
        if ($schema->propertyNames === true) {
            return;
        }

        $propertyNames = get_object_vars($value);

        if ($schema->propertyNames === false) {
            foreach ($propertyNames as $propertyName => $_) {
                $this->addError(ConstraintError::PROPERTY_NAMES(), $path, ['propertyNames' => $schema->propertyNames, 'violating' => 'false', 'name' => $propertyName]);
            }

            return;
        }

        if (property_exists($schema->propertyNames, 'maxLength')) {
            foreach ($propertyNames as $propertyName => $_) {
                $length = mb_strlen($propertyName);
                if ($length > $schema->propertyNames->maxLength) {
                    $this->addError(ConstraintError::PROPERTY_NAMES(), $path, ['propertyNames' => $schema->propertyNames, 'violating' => 'maxLength', 'length' => $length, 'name' => $propertyName]);
                }
            }
        }

        if (property_exists($schema->propertyNames, 'pattern')) {
            foreach ($propertyNames as $propertyName => $_) {
                if (!preg_match('/' . str_replace('/', '\/', $schema->propertyNames->pattern) . '/', $propertyName)) {
                    $this->addError(ConstraintError::PROPERTY_NAMES(), $path, ['propertyNames' => $schema->propertyNames, 'violating' => 'pattern', 'name' => $propertyName]);
                }
            }
        }

        if (property_exists($schema->propertyNames, 'const')) {
            foreach ($propertyNames as $propertyName => $_) {
                if ($propertyName !== $schema->propertyNames->const) {
                    $this->addError(ConstraintError::PROPERTY_NAMES(), $path, ['propertyNames' => $schema->propertyNames, 'violating' => 'const', 'name' => $propertyName]);
                }
            }
        }

        if (property_exists($schema->propertyNames, 'enum')) {
            $diff = array_diff(array_keys($propertyNames), $schema->propertyNames->enum);
            foreach ($diff as $propertyName) {
                $this->addError(ConstraintError::PROPERTY_NAMES(), $path, ['propertyNames' => $schema->propertyNames, 'violating' => 'enum', 'name' => $propertyName]);
            }
        }
    }
}

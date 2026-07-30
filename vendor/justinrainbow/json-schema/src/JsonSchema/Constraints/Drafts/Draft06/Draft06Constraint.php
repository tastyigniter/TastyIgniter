<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\Constraint;
use JsonSchema\Entity\JsonPointer;
use JsonSchema\SchemaStorage;
use JsonSchema\Uri\UriRetriever;

class Draft06Constraint extends Constraint
{
    public function __construct(?\JsonSchema\Constraints\Factory $factory = null)
    {
        parent::__construct(new Factory(
            $factory ? $factory->getSchemaStorage() : new SchemaStorage(),
            $factory ? $factory->getUriRetriever() : new UriRetriever(),
            $factory ? $factory->getConfig() : Constraint::CHECK_MODE_NORMAL
        ));
    }

    public function check(&$value, $schema = null, ?JsonPointer $path = null, $i = null): void
    {
        if (is_bool($schema)) {
            if ($schema === false) {
                $this->addError(ConstraintError::FALSE(), $path, []);
            }

            return;
        }

        // Apply defaults
        $this->checkForKeyword('ref', $value, $schema, $path, $i);
        $this->checkForKeyword('required', $value, $schema, $path, $i);
        $this->checkForKeyword('contains', $value, $schema, $path, $i);
        $this->checkForKeyword('properties', $value, $schema, $path, $i);
        $this->checkForKeyword('propertyNames', $value, $schema, $path, $i);
        $this->checkForKeyword('patternProperties', $value, $schema, $path, $i);
        $this->checkForKeyword('type', $value, $schema, $path, $i);
        $this->checkForKeyword('not', $value, $schema, $path, $i);
        $this->checkForKeyword('dependencies', $value, $schema, $path, $i);
        $this->checkForKeyword('allOf', $value, $schema, $path, $i);
        $this->checkForKeyword('anyOf', $value, $schema, $path, $i);
        $this->checkForKeyword('oneOf', $value, $schema, $path, $i);

        $this->checkForKeyword('additionalProperties', $value, $schema, $path, $i);
        $this->checkForKeyword('items', $value, $schema, $path, $i);
        $this->checkForKeyword('additionalItems', $value, $schema, $path, $i);
        $this->checkForKeyword('uniqueItems', $value, $schema, $path, $i);
        $this->checkForKeyword('minItems', $value, $schema, $path, $i);
        $this->checkForKeyword('minProperties', $value, $schema, $path, $i);
        $this->checkForKeyword('maxProperties', $value, $schema, $path, $i);
        $this->checkForKeyword('minimum', $value, $schema, $path, $i);
        $this->checkForKeyword('maximum', $value, $schema, $path, $i);
        $this->checkForKeyword('minLength', $value, $schema, $path, $i);
        $this->checkForKeyword('exclusiveMinimum', $value, $schema, $path, $i);
        $this->checkForKeyword('maxItems', $value, $schema, $path, $i);
        $this->checkForKeyword('maxLength', $value, $schema, $path, $i);
        $this->checkForKeyword('exclusiveMaximum', $value, $schema, $path, $i);
        $this->checkForKeyword('enum', $value, $schema, $path, $i);
        $this->checkForKeyword('const', $value, $schema, $path, $i);
        $this->checkForKeyword('multipleOf', $value, $schema, $path, $i);
        $this->checkForKeyword('format', $value, $schema, $path, $i);
        $this->checkForKeyword('pattern', $value, $schema, $path, $i);
    }

    /**
     * @param mixed $value
     * @param mixed $schema
     * @param mixed $i
     */
    protected function checkForKeyword(string $keyword, $value, $schema = null, ?JsonPointer $path = null, $i = null): void
    {
        $validator = $this->factory->createInstanceFor($keyword);
        $validator->check($value, $schema, $path, $i);

        $this->addErrors($validator->getErrors());
    }
}

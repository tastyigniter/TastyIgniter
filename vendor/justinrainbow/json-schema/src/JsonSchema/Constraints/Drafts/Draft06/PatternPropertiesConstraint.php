<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class PatternPropertiesConstraint implements ConstraintInterface
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
        if (!property_exists($schema, 'patternProperties')) {
            return;
        }

        if (!is_object($value)) {
            return;
        }

        $properties = get_object_vars($value);

        foreach ($properties as $propertyName => $propertyValue) {
            foreach ($schema->patternProperties as $patternPropertyRegex => $patternPropertySchema) {
                $matchPattern = $this->createPregMatchPattern($patternPropertyRegex);
                if (preg_match($matchPattern, (string) $propertyName)) {
                    $schemaConstraint = $this->factory->createInstanceFor('schema');
                    $schemaConstraint->check($propertyValue, $patternPropertySchema, $path, $i);
                    if ($schemaConstraint->isValid()) {
                        continue;
                    }

                    $this->addErrors($schemaConstraint->getErrors());
                }
            }
        }
    }

    private function createPregMatchPattern(string $pattern): string
    {
        $replacements = [
//            '\D' => '[^0-9]',
            '\d' => '[0-9]',
            '\p{digit}' => '[0-9]',
//            '\w' => '[A-Za-z0-9_]',
//            '\W' => '[^A-Za-z0-9_]',
//            '\s' => '[\s\x{200B}]' // Explicitly include zero width white space
            '\p{Letter}' => '\p{L}', // Map ECMA long property name to PHP (PCRE) Unicode property abbreviations
        ];

        $pattern = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $pattern
        );

        return '/' . str_replace('/', '\/', $pattern) . '/u';
    }
}

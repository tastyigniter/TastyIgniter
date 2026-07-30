<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft07;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Constraints\Factory;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;

class ContentConstraint implements ConstraintInterface
{
    use ErrorBagProxy;

    public function __construct(?Factory $factory = null)
    {
        $this->initialiseErrorBag($factory ?: new Factory());
    }

    public function check(&$value, $schema = null, ?JsonPointer $path = null, $i = null): void
    {
        if (!property_exists($schema, 'contentMediaType') && !property_exists($schema, 'contentEncoding')) {
            return;
        }
        if (!is_string($value)) {
            return;
        }

        $decodedValue = $value;

        if (property_exists($schema, 'contentEncoding')) {
            if ($schema->contentEncoding === 'base64') {
                if (!preg_match('/^[A-Za-z0-9+\/=]+$/', $decodedValue)) {
                    $this->addError(ConstraintError::CONTENT_ENCODING(), $path, ['contentEncoding' => $schema->contentEncoding]);

                    return;
                }
                $decodedValue = base64_decode($decodedValue);
            }
        }

        if (property_exists($schema, 'contentMediaType')) {
            if ($schema->contentMediaType === 'application/json') {
                json_decode($decodedValue, false);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return;
                }
            }

            $this->addError(ConstraintError::CONTENT_MEDIA_TYPE(), $path, ['contentMediaType' => $schema->contentMediaType]);
        }
    }
}

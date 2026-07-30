<?php

declare(strict_types=1);

namespace JsonSchema\Entity;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\Constraint;
use JsonSchema\Constraints\Factory;
use JsonSchema\Exception\ValidationException;
use JsonSchema\Validator;

/**
 * @phpstan-type Error array{
 *     "property": string,
 *     "pointer": string,
 *     "message": string,
 *     "constraint": array{"name": string, "params": array<string, mixed>},
 *     "context": int-mask-of<Validator::ERROR_*>
 * }
 * @phpstan-type ErrorList list<Error>
 */
class ErrorBag
{
    /** @var Factory */
    private $factory;

    /** @var ErrorList */
    private $errors = [];

    /**
     * @var int-mask-of<Validator::ERROR_*> All error types that have occurred
     */
    protected $errorMask = Validator::ERROR_NONE;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function reset(): void
    {
        $this->errors = [];
        $this->errorMask = Validator::ERROR_NONE;
    }

    /** @return ErrorList */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /** @param array<string, mixed> $more */
    public function addError(ConstraintError $constraint, ?JsonPointer $path = null, array $more = []): void
    {
        $message = $constraint->getMessage();
        $name = $constraint->getValue();
        /** @var Error $error */
        $error = [
            'property' => $this->convertJsonPointerIntoPropertyPath($path ?: new JsonPointer('')),
            'pointer' => ltrim((string) ($path ?: new JsonPointer('')), '#'),
            'message' => ucfirst(vsprintf($message, array_map(static function ($val) {
                if (is_scalar($val)) {
                    return is_bool($val) ? var_export($val, true) : $val;
                }

                return json_encode($val);
            }, array_values($more)))),
            'constraint' => [
                'name' => $name,
                'params' => $more
            ],
            'context' => $this->factory->getErrorContext(),
        ];

        if ($this->factory->getConfig(Constraint::CHECK_MODE_EXCEPTIONS)) {
            throw new ValidationException(sprintf('Error validating %s: %s', $error['pointer'], $error['message']));
        }
        $this->errors[] = $error;
        /* @see https://github.com/phpstan/phpstan/issues/9384 */
        $this->errorMask |= $error['context']; // @phpstan-ignore assign.propertyType
    }

    /** @param ErrorList $errors */
    public function addErrors(array $errors): void
    {
        if (!$errors) {
            return;
        }

        $this->errors = array_merge($this->errors, $errors);
        $errorMask = &$this->errorMask;
        array_walk($errors, static function ($error) use (&$errorMask) {
            $errorMask |= $error['context'];
        });
    }

    private function convertJsonPointerIntoPropertyPath(JsonPointer $pointer): string
    {
        $result = array_map(
            static function ($path) {
                return sprintf(is_numeric($path) ? '[%d]' : '.%s', $path);
            },
            $pointer->getPropertyPaths()
        );

        return trim(implode('', $result), '.');
    }
}

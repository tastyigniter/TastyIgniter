<?php

declare(strict_types=1);

namespace JsonSchema\Entity;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\Factory;

/**
 * @phpstan-import-type Error from ErrorBag
 * @phpstan-import-type ErrorList from ErrorBag
 */
trait ErrorBagProxy
{
    /** @var ?ErrorBag */
    protected $errorBag = null;

    /** @return ErrorList */
    public function getErrors(): array
    {
        return $this->errorBag()->getErrors();
    }

    /** @param ErrorList $errors */
    public function addErrors(array $errors): void
    {
        $this->errorBag()->addErrors($errors);
    }

    /**
     * @param array<string, mixed> $more more array elements to add to the error
     */
    public function addError(ConstraintError $constraint, ?JsonPointer $path = null, array $more = []): void
    {
        $this->errorBag()->addError($constraint, $path, $more);
    }

    public function isValid(): bool
    {
        return $this->errorBag()->getErrors() === [];
    }

    protected function initialiseErrorBag(Factory $factory): ErrorBag
    {
        if (is_null($this->errorBag)) {
            $this->errorBag = new ErrorBag($factory);
        }

        return $this->errorBag;
    }

    protected function errorBag(): ErrorBag
    {
        if (is_null($this->errorBag)) {
            throw new \RuntimeException('ErrorBag not initialized');
        }

        return $this->errorBag;
    }

    public function __clone()
    {
        $this->errorBag()->reset();
    }
}

<?php

declare(strict_types=1);

namespace Core\Response;

use Core\Response\Types\ErrorType;

class ResponseError
{
    /**
     * @var array<string,ErrorType>
     */
    private $errors;
    private $useApiResponse = false;
    private $nullOn404 = false;

    /**
     * Adds an error to the errors array with the errorCode and ErrorType provided.
     */
    public function addError(string $errorCode, ErrorType $error): void
    {
        $this->errors[$errorCode] = $error;
    }

    public function returnApiResponse(): void
    {
        $this->useApiResponse = true;
    }

    /**
     * Sets the nullOn404 flag.
     */
    public function nullOn404(): void
    {
        $this->nullOn404 = true;
    }

    private function shouldReturnNull(int $statusCode): bool
    {
        if (!$this->nullOn404) {
            return false;
        }
        if ($statusCode !== 404) {
            return false;
        }
        return true;
    }

    /**
     * Returns calculated result on failure or throws an exception.
     */
    public function getResult(Context $context)
    {
        $statusCode = $context->getResponse()->getStatusCode();
        if ($this->shouldReturnNull($statusCode)) {
            if ($this->useApiResponse) {
                return $context->toApiResponse(null);
            }
            return null;
        }
        if ($this->useApiResponse) {
            return $context->toApiResponse($context->getResponseBody());
        }
        if (isset($this->errors[strval($statusCode)])) {
            throw $this->errors[strval($statusCode)]->throwable($context);
        }
        if (isset($this->errors[strval(0)])) {
            throw $this->errors[strval(0)]->throwable($context); // throw default error (if set)
        }
        throw $context->toApiException('HTTP Response Not OK');
    }
}

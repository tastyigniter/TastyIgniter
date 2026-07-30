<?php

declare(strict_types=1);

namespace Square\Http;

use Core\Types\Sdk\CoreApiResponse;
use Square\ApiHelper;
use Square\Models\Error;

/**
 * Holds the result of an API call.
 */
class ApiResponse extends CoreApiResponse
{
    /**
     * Create a new instance of this class with the given context and result.
     *
     * @param mixed $decodedBody Decoded response body
     * @param mixed $result Deserialized result from the response
     * @param HttpContext $context Http context
     */
    public static function createFromContext($decodedBody, $result, HttpContext $context): self
    {
        $request = $context->getRequest();
        $statusCode = $context->getResponse()->getStatusCode();
        $reasonPhrase = null; // TODO
        $headers = $context->getResponse()->getHeaders();
        $body = $context->getResponse()->getRawBody();

        if (!is_array($decodedBody)) {
            $decodedBody = (array) $decodedBody;
        }
        $cursor = $decodedBody['cursor'] ?? null;
        $errors = [];
        if ($statusCode >= 400 && $statusCode < 600) {
            if (isset($decodedBody['errors'])) {
                $errors = ApiHelper::getJsonHelper()->mapClass($decodedBody['errors'], Error::class, 1);
            } else {
                $error = new Error('V1_ERROR', $decodedBody['type'] ?? 'Unknown');
                $error->setDetail($decodedBody['message'] ?? null);
                $error->setField($decodedBody['field'] ?? null);
                $errors = [$error];
            }
        }
        return new self($request, $statusCode, $reasonPhrase, $headers, $result, $body, $errors, $cursor);
    }

    /**
     * @var Error[]
     */
    private $errors;

    /**
     * @var mixed
     */
    private $cursor;

    /**
     * @param HttpRequest $request
     * @param int|null $statusCode
     * @param string|null $reasonPhrase
     * @param array|null $headers
     * @param mixed $result
     * @param mixed $body
     * @param Error[] $errors
     * @param mixed $cursor
     */
    public function __construct(
        HttpRequest $request,
        ?int $statusCode,
        ?string $reasonPhrase,
        ?array $headers,
        $result,
        $body,
        array $errors,
        $cursor
    ) {
        parent::__construct($request, $statusCode, $reasonPhrase, $headers, $result, $body);
        $this->errors = $errors;
        $this->cursor = $cursor;
    }

    /**
     * Returns the errors if any.
     *
     * @return Error[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Returns the pagination cursor.
     *
     * @return mixed
     */
    public function getCursor()
    {
        return $this->cursor;
    }

    /**
     * Returns the original request that resulted in this response.
     */
    public function getRequest(): HttpRequest
    {
        return $this->request;
    }
}

<?php

namespace Mollie\Api\Exceptions;

use DateTime;

class ApiException extends \Exception
{
    /**
     * @var string
     */
    protected $field;

    /**
     * @var string
     */
    protected $plainMessage;

    /**
     * @var \Psr\Http\Message\RequestInterface|null
     */
    protected $request;

    /**
     * @var \Psr\Http\Message\ResponseInterface|null
     */
    protected $response;

    /**
     * ISO8601 representation of the moment this exception was thrown
     *
     * @var \DateTimeImmutable
     */
    protected $raisedAt;

    /**
     * @var array
     */
    protected $links = [];

    /**
     * @param string $message
     * @param int $code
     * @param string|null $field
     * @param \Psr\Http\Message\RequestInterface|null $request
     * @param \Psr\Http\Message\ResponseInterface|null $response
     * @param \Throwable|null $previous
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function __construct(
        $message = "",
        $code = 0,
        $field = null,
        $request = null,
        $response = null,
        $previous = null
    ) {
        $this->plainMessage = $message;

        $this->raisedAt = new \DateTimeImmutable();

        $formattedRaisedAt = $this->raisedAt->format(DateTime::ISO8601);
        $message = "[{$formattedRaisedAt}] " . $message;

        if (! empty($field)) {
            $this->field = (string)$field;
            $message .= ". Field: {$this->field}";
        }

        if (! empty($response)) {
            $this->response = $response;

            $object = static::parseResponseBody($this->response);

            if (isset($object->_links)) {
                foreach ($object->_links as $key => $value) {
                    $this->links[$key] = $value;
                }
            }
        }

        if ($this->hasLink('documentation')) {
            $message .= ". Documentation: {$this->getDocumentationUrl()}";
        }

        $this->request = $request;
        if ($request) {
            $requestBody = $request->getBody()->__toString();

            if ($requestBody) {
                $message .= ". Request body: {$requestBody}";
            }
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Psr\Http\Message\RequestInterface $request
     * @param \Throwable|null $previous
     * @return \Mollie\Api\Exceptions\ApiException
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public static function createFromResponse($response, $request = null, $previous = null)
    {
        $object = static::parseResponseBody($response);

        $field = null;
        if (! empty($object->field)) {
            $field = $object->field;
        }

        return new self(
            "Error executing API call ({$object->status}: {$object->title}): {$object->detail}",
            $response->getStatusCode(),
            $field,
            $request,
            $response,
            $previous
        );
    }

    /**
     * @return string|null
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string|null
     */
    public function getDocumentationUrl()
    {
        return $this->getUrl('documentation');
    }

    /**
     * @return string|null
     */
    public function getDashboardUrl()
    {
        return $this->getUrl('dashboard');
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    public function hasResponse()
    {
        return $this->response !== null;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasLink($key)
    {
        return array_key_exists($key, $this->links);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getLink($key)
    {
        if ($this->hasLink($key)) {
            return $this->links[$key];
        }

        return null;
    }

    /**
     * @param string $key
     * @return null
     */
    public function getUrl($key)
    {
        if ($this->hasLink($key)) {
            return $this->getLink($key)->href;
        }

        return null;
    }

    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get the ISO8601 representation of the moment this exception was thrown
     *
     * @return \DateTimeImmutable
     */
    public function getRaisedAt()
    {
        return $this->raisedAt;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \stdClass
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    protected static function parseResponseBody($response)
    {
        $body = (string) $response->getBody();

        $object = @json_decode($body);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new self("Unable to decode Mollie response: '{$body}'.");
        }

        return $object;
    }

    /**
     * Retrieve the plain exception message.
     *
     * @return string
     */
    public function getPlainMessage()
    {
        return $this->plainMessage;
    }
}

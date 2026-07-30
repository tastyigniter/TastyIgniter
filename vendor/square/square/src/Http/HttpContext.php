<?php

declare(strict_types=1);

namespace Square\Http;

use Core\Types\Sdk\CoreContext;

/**
 * Represents an HTTP call in context
 */
class HttpContext extends CoreContext
{
    /**
     * Returns the HTTP Request
     *
     * @return HttpRequest request
     */
    public function getRequest(): HttpRequest
    {
        return $this->request;
    }

    /**
     * Returns the HTTP Response
     *
     * @return HttpResponse response
     */
    public function getResponse(): HttpResponse
    {
        return $this->response;
    }
}

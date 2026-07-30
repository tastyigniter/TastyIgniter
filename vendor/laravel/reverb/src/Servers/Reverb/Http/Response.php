<?php

namespace Laravel\Reverb\Servers\Reverb\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

class Response extends JsonResponse
{
    /**
     * Create a new Http response instance.
     */
    public function __construct(mixed $data = null, int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct($data, $status, $headers, $json);

        $this->headers->set('Content-Length', (string) strlen($this->content));
    }
}

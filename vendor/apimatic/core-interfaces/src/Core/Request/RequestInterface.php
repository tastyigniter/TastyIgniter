<?php

namespace CoreInterfaces\Core\Request;

interface RequestInterface
{
    public function getHttpMethod(): string;
    public function getQueryUrl(): string;
    /**
     * @return array<string,mixed>
     */
    public function getHeaders(): array;
    /**
     * @return array<string,mixed>
     */
    public function getParameters(): array;
    /**
     * @return array<string,mixed>
     */
    public function getEncodedParameters(): array;
    /**
     * @return array<string,mixed>
     */
    public function getMultipartParameters(): array;
    public function getBody();
    public function getRetryOption(): string;
    public function convert();
    public function toApiException(string $message);
}

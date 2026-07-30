<?php

namespace CoreInterfaces\Core\Request;

interface RequestSetterInterface extends RequestInterface
{
    public function setHttpMethod(string $requestMethod): void;
    public function appendPath(string $path): void;
    public function addTemplate(string $key, $value): void;
    public function addHeader(string $key, $value): void;
    public function addEncodedFormParam(string $key, $value, $realValue): void;
    public function addMultipartFormParam(string $key, $value): void;
    public function addBodyParam($value, string $key = ''): void;
    public function setBodyFormat(string $format, callable $serializer): void;
    public function setRetryOption(string $retryOption): void;
}

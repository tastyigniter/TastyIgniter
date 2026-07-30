<?php

namespace CoreInterfaces\Core;

use CoreInterfaces\Core\Request\RequestInterface;
use CoreInterfaces\Core\Response\ResponseInterface;

interface ContextInterface
{
    public function getRequest(): RequestInterface;
    public function getResponse(): ResponseInterface;
}

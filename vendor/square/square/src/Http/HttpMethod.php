<?php

declare(strict_types=1);

namespace Square\Http;

use CoreInterfaces\Core\Request\RequestMethod;

/**
 * HTTP Methods Enumeration
 */
class HttpMethod
{
    public const GET = RequestMethod::GET;
    public const POST = RequestMethod::POST;
    public const PUT = RequestMethod::PUT;
    public const PATCH = RequestMethod::PATCH;
    public const DELETE = RequestMethod::DELETE;
    public const HEAD = RequestMethod::HEAD;
}

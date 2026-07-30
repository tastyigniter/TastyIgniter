<?php

declare(strict_types=1);

namespace Igniter\Api\Exceptions;

use Illuminate\Auth\AuthenticationException as Exception;

class AuthenticationException extends Exception
{
    public function render($request)
    {
        return response()->json(['message' => $this->getMessage()], 401);
    }
}

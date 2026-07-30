<?php

declare(strict_types=1);

namespace Igniter\Api\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowTokenUser
{
    public function __invoke(Request $request): Response
    {
        $user = $request->user();
        $statusCode = $user ? 200 : 401;

        return response()->json([
            'status_code' => $statusCode,
            'user' => $user,
        ])->setStatusCode($statusCode);
    }
}

<?php

declare(strict_types=1);

namespace Igniter\Api\Http\Controllers;

use Igniter\Api\Models\Token;
use Igniter\User\Auth\CustomerGuard;
use Igniter\User\Auth\UserGuard;
use Igniter\User\Models\Customer;
use Igniter\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CreateToken extends Controller
{
    public function __invoke(Request $request): Response
    {
        $request->validate([
            'email' => ['required', 'email:filter'],
            'password' => 'required',
            'is_admin' => 'boolean',
            'device_name' => ['required', 'string', 'max:255'],
            'abilities.*' => 'regex:/^[a-zA-Z-_\*\.\:]+$/',
        ]);

        $forAdmin = $request->get('is_admin', false);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        /** @var CustomerGuard|UserGuard $auth */
        $auth = app($forAdmin ? 'admin.auth' : 'main.auth');
        /** @var null|Customer|User $user */
        $user = $auth->getByCredentials($credentials);

        if (!$user || !$auth->validateCredentials($user, $credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (!$user->is_activated) {
            throw ValidationException::withMessages([
                'email' => ['Inactive user account'],
            ]);
        }

        $token = Token::createToken($user, $request->device_name, $request->abilities ?? ['*']);

        return response()->json([
            'status_code' => 201,
            'token' => $token->plainTextToken,
        ])->setStatusCode(201);
    }
}

<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Classes;

use net\authorize\api\contract\v1\CreateTransactionRequest;
use net\authorize\api\controller\CreateTransactionController;

class AuthorizeNetTransactionRequest extends CreateTransactionRequest
{
    protected ?CreateTransactionController $controller = null;

    public function controller(): CreateTransactionController
    {
        return $this->controller ??= new CreateTransactionController($this);
    }
}

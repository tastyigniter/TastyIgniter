<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Payments\Fixtures;

use Igniter\PayRegister\Classes\BasePaymentGateway;
use Override;

class TestPayment extends BasePaymentGateway
{
    #[Override]
    public function defineFieldsConfig(): string
    {
        return __DIR__.'/../../_fixtures/fields';
    }

    #[Override]
    public function registerEntryPoints(): array
    {
        return [
            'test_endpoint' => 'processReturnUrl',
        ];
    }

    public function processReturnUrl(): string
    {
        return 'test_endpoint';
    }
}

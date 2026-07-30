<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Tests\Payments\Fixtures;

use Igniter\PayRegister\Classes\BasePaymentGateway;
use Igniter\PayRegister\Concerns\WithPaymentRefund;
use Igniter\PayRegister\Models\PaymentLog;
use Override;

class TestPaymentWithNoRefund extends BasePaymentGateway
{
    use WithPaymentRefund;

    #[Override]
    public function defineFieldsConfig(): string
    {
        return __DIR__.'/../../_fixtures/fields';
    }

    #[Override]
    public function canRefundPayment(PaymentLog $paymentLog): bool
    {
        return false;
    }
}

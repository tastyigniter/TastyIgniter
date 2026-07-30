<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\PayRegister\Models\Payment;
use League\Fractal\TransformerAbstract;

class PaymentMethodTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    public function transform(Payment $payment): array
    {
        return [
            'id' => $payment->getKey(),
            'payment_id' => $payment->getKey(),
            'code' => $payment->code,
            'name' => $payment->name,
            'description' => $payment->description,
        ];
    }
}

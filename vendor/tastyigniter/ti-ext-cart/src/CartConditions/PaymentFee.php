<?php

declare(strict_types=1);

namespace Igniter\Cart\CartConditions;

use Igniter\Cart\CartCondition;
use Igniter\PayRegister\Models\Payment;
use Override;

class PaymentFee extends CartCondition
{
    protected $paymentModel;

    public ?int $priority = 600;

    #[Override]
    public function getLabel(): string
    {
        $paymentFeeType = (int)optional($this->paymentModel)->order_fee_type;
        $paymentFee = optional($this->paymentModel)->order_fee;

        return $paymentFeeType === 2
            ? lang($this->label).sprintf(' [%s%%]', $paymentFee)
            : lang($this->label);
    }

    #[Override]
    public function beforeApply(): ?bool
    {
        if ((string)($paymentCode = $this->getMetaData('code', '')) === '') {
            return false;
        }

        if (is_null($this->paymentModel)) {
            $this->paymentModel = Payment::whereCode($paymentCode)->first();
        }

        // only apply if payment has applicable fee
        $paymentFee = optional($this->paymentModel)->order_fee;
        if ($paymentFee <= 0) {
            return false;
        }

        return null;
    }

    #[Override]
    public function getActions(): array
    {
        $paymentFeeType = (int)optional($this->paymentModel)->order_fee_type;
        $paymentFee = optional($this->paymentModel)->order_fee ?? 0;

        return [
            ['value' => '+'.$paymentFee.($paymentFeeType === 2 ? '%' : '')],
        ];
    }
}

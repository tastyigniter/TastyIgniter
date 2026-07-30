<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Address;
use Square\Models\ApplicationDetails;
use Square\Models\BankAccountPaymentDetails;
use Square\Models\BuyNowPayLaterDetails;
use Square\Models\CardPaymentDetails;
use Square\Models\CashPaymentDetails;
use Square\Models\DeviceDetails;
use Square\Models\DigitalWalletDetails;
use Square\Models\ExternalPaymentDetails;
use Square\Models\Money;
use Square\Models\Payment;
use Square\Models\RiskEvaluation;

/**
 * Builder for model Payment
 *
 * @see Payment
 */
class PaymentBuilder
{
    /**
     * @var Payment
     */
    private $instance;

    private function __construct(Payment $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment Builder object.
     */
    public static function init(): self
    {
        return new self(new Payment());
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Sets amount money field.
     */
    public function amountMoney(?Money $value): self
    {
        $this->instance->setAmountMoney($value);
        return $this;
    }

    /**
     * Sets tip money field.
     */
    public function tipMoney(?Money $value): self
    {
        $this->instance->setTipMoney($value);
        return $this;
    }

    /**
     * Sets total money field.
     */
    public function totalMoney(?Money $value): self
    {
        $this->instance->setTotalMoney($value);
        return $this;
    }

    /**
     * Sets app fee money field.
     */
    public function appFeeMoney(?Money $value): self
    {
        $this->instance->setAppFeeMoney($value);
        return $this;
    }

    /**
     * Sets approved money field.
     */
    public function approvedMoney(?Money $value): self
    {
        $this->instance->setApprovedMoney($value);
        return $this;
    }

    /**
     * Sets processing fee field.
     */
    public function processingFee(?array $value): self
    {
        $this->instance->setProcessingFee($value);
        return $this;
    }

    /**
     * Sets refunded money field.
     */
    public function refundedMoney(?Money $value): self
    {
        $this->instance->setRefundedMoney($value);
        return $this;
    }

    /**
     * Sets status field.
     */
    public function status(?string $value): self
    {
        $this->instance->setStatus($value);
        return $this;
    }

    /**
     * Sets delay duration field.
     */
    public function delayDuration(?string $value): self
    {
        $this->instance->setDelayDuration($value);
        return $this;
    }

    /**
     * Sets delay action field.
     */
    public function delayAction(?string $value): self
    {
        $this->instance->setDelayAction($value);
        return $this;
    }

    /**
     * Unsets delay action field.
     */
    public function unsetDelayAction(): self
    {
        $this->instance->unsetDelayAction();
        return $this;
    }

    /**
     * Sets delayed until field.
     */
    public function delayedUntil(?string $value): self
    {
        $this->instance->setDelayedUntil($value);
        return $this;
    }

    /**
     * Sets source type field.
     */
    public function sourceType(?string $value): self
    {
        $this->instance->setSourceType($value);
        return $this;
    }

    /**
     * Sets card details field.
     */
    public function cardDetails(?CardPaymentDetails $value): self
    {
        $this->instance->setCardDetails($value);
        return $this;
    }

    /**
     * Sets cash details field.
     */
    public function cashDetails(?CashPaymentDetails $value): self
    {
        $this->instance->setCashDetails($value);
        return $this;
    }

    /**
     * Sets bank account details field.
     */
    public function bankAccountDetails(?BankAccountPaymentDetails $value): self
    {
        $this->instance->setBankAccountDetails($value);
        return $this;
    }

    /**
     * Sets external details field.
     */
    public function externalDetails(?ExternalPaymentDetails $value): self
    {
        $this->instance->setExternalDetails($value);
        return $this;
    }

    /**
     * Sets wallet details field.
     */
    public function walletDetails(?DigitalWalletDetails $value): self
    {
        $this->instance->setWalletDetails($value);
        return $this;
    }

    /**
     * Sets buy now pay later details field.
     */
    public function buyNowPayLaterDetails(?BuyNowPayLaterDetails $value): self
    {
        $this->instance->setBuyNowPayLaterDetails($value);
        return $this;
    }

    /**
     * Sets location id field.
     */
    public function locationId(?string $value): self
    {
        $this->instance->setLocationId($value);
        return $this;
    }

    /**
     * Sets order id field.
     */
    public function orderId(?string $value): self
    {
        $this->instance->setOrderId($value);
        return $this;
    }

    /**
     * Sets reference id field.
     */
    public function referenceId(?string $value): self
    {
        $this->instance->setReferenceId($value);
        return $this;
    }

    /**
     * Sets customer id field.
     */
    public function customerId(?string $value): self
    {
        $this->instance->setCustomerId($value);
        return $this;
    }

    /**
     * Sets employee id field.
     */
    public function employeeId(?string $value): self
    {
        $this->instance->setEmployeeId($value);
        return $this;
    }

    /**
     * Sets team member id field.
     */
    public function teamMemberId(?string $value): self
    {
        $this->instance->setTeamMemberId($value);
        return $this;
    }

    /**
     * Sets refund ids field.
     */
    public function refundIds(?array $value): self
    {
        $this->instance->setRefundIds($value);
        return $this;
    }

    /**
     * Sets risk evaluation field.
     */
    public function riskEvaluation(?RiskEvaluation $value): self
    {
        $this->instance->setRiskEvaluation($value);
        return $this;
    }

    /**
     * Sets buyer email address field.
     */
    public function buyerEmailAddress(?string $value): self
    {
        $this->instance->setBuyerEmailAddress($value);
        return $this;
    }

    /**
     * Sets billing address field.
     */
    public function billingAddress(?Address $value): self
    {
        $this->instance->setBillingAddress($value);
        return $this;
    }

    /**
     * Sets shipping address field.
     */
    public function shippingAddress(?Address $value): self
    {
        $this->instance->setShippingAddress($value);
        return $this;
    }

    /**
     * Sets note field.
     */
    public function note(?string $value): self
    {
        $this->instance->setNote($value);
        return $this;
    }

    /**
     * Sets statement description identifier field.
     */
    public function statementDescriptionIdentifier(?string $value): self
    {
        $this->instance->setStatementDescriptionIdentifier($value);
        return $this;
    }

    /**
     * Sets capabilities field.
     */
    public function capabilities(?array $value): self
    {
        $this->instance->setCapabilities($value);
        return $this;
    }

    /**
     * Sets receipt number field.
     */
    public function receiptNumber(?string $value): self
    {
        $this->instance->setReceiptNumber($value);
        return $this;
    }

    /**
     * Sets receipt url field.
     */
    public function receiptUrl(?string $value): self
    {
        $this->instance->setReceiptUrl($value);
        return $this;
    }

    /**
     * Sets device details field.
     */
    public function deviceDetails(?DeviceDetails $value): self
    {
        $this->instance->setDeviceDetails($value);
        return $this;
    }

    /**
     * Sets application details field.
     */
    public function applicationDetails(?ApplicationDetails $value): self
    {
        $this->instance->setApplicationDetails($value);
        return $this;
    }

    /**
     * Sets version token field.
     */
    public function versionToken(?string $value): self
    {
        $this->instance->setVersionToken($value);
        return $this;
    }

    /**
     * Unsets version token field.
     */
    public function unsetVersionToken(): self
    {
        $this->instance->unsetVersionToken();
        return $this;
    }

    /**
     * Initializes a new payment object.
     */
    public function build(): Payment
    {
        return CoreHelper::clone($this->instance);
    }
}

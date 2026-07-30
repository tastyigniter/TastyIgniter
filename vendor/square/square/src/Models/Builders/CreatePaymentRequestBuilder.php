<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Address;
use Square\Models\CashPaymentDetails;
use Square\Models\CreatePaymentRequest;
use Square\Models\ExternalPaymentDetails;
use Square\Models\Money;

/**
 * Builder for model CreatePaymentRequest
 *
 * @see CreatePaymentRequest
 */
class CreatePaymentRequestBuilder
{
    /**
     * @var CreatePaymentRequest
     */
    private $instance;

    private function __construct(CreatePaymentRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create payment request Builder object.
     */
    public static function init(string $sourceId, string $idempotencyKey): self
    {
        return new self(new CreatePaymentRequest($sourceId, $idempotencyKey));
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
     * Sets app fee money field.
     */
    public function appFeeMoney(?Money $value): self
    {
        $this->instance->setAppFeeMoney($value);
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
     * Sets autocomplete field.
     */
    public function autocomplete(?bool $value): self
    {
        $this->instance->setAutocomplete($value);
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
     * Sets customer id field.
     */
    public function customerId(?string $value): self
    {
        $this->instance->setCustomerId($value);
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
     * Sets team member id field.
     */
    public function teamMemberId(?string $value): self
    {
        $this->instance->setTeamMemberId($value);
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
     * Sets verification token field.
     */
    public function verificationToken(?string $value): self
    {
        $this->instance->setVerificationToken($value);
        return $this;
    }

    /**
     * Sets accept partial authorization field.
     */
    public function acceptPartialAuthorization(?bool $value): self
    {
        $this->instance->setAcceptPartialAuthorization($value);
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
     * Sets cash details field.
     */
    public function cashDetails(?CashPaymentDetails $value): self
    {
        $this->instance->setCashDetails($value);
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
     * Initializes a new create payment request object.
     */
    public function build(): CreatePaymentRequest
    {
        return CoreHelper::clone($this->instance);
    }
}

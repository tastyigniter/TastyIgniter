<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BankAccount;

/**
 * Builder for model BankAccount
 *
 * @see BankAccount
 */
class BankAccountBuilder
{
    /**
     * @var BankAccount
     */
    private $instance;

    private function __construct(BankAccount $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bank account Builder object.
     */
    public static function init(
        string $id,
        string $accountNumberSuffix,
        string $country,
        string $currency,
        string $accountType,
        string $holderName,
        string $primaryBankIdentificationNumber,
        string $status,
        bool $creditable,
        bool $debitable
    ): self {
        return new self(new BankAccount(
            $id,
            $accountNumberSuffix,
            $country,
            $currency,
            $accountType,
            $holderName,
            $primaryBankIdentificationNumber,
            $status,
            $creditable,
            $debitable
        ));
    }

    /**
     * Sets secondary bank identification number field.
     */
    public function secondaryBankIdentificationNumber(?string $value): self
    {
        $this->instance->setSecondaryBankIdentificationNumber($value);
        return $this;
    }

    /**
     * Unsets secondary bank identification number field.
     */
    public function unsetSecondaryBankIdentificationNumber(): self
    {
        $this->instance->unsetSecondaryBankIdentificationNumber();
        return $this;
    }

    /**
     * Sets debit mandate reference id field.
     */
    public function debitMandateReferenceId(?string $value): self
    {
        $this->instance->setDebitMandateReferenceId($value);
        return $this;
    }

    /**
     * Unsets debit mandate reference id field.
     */
    public function unsetDebitMandateReferenceId(): self
    {
        $this->instance->unsetDebitMandateReferenceId();
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
     * Unsets reference id field.
     */
    public function unsetReferenceId(): self
    {
        $this->instance->unsetReferenceId();
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
     * Unsets location id field.
     */
    public function unsetLocationId(): self
    {
        $this->instance->unsetLocationId();
        return $this;
    }

    /**
     * Sets fingerprint field.
     */
    public function fingerprint(?string $value): self
    {
        $this->instance->setFingerprint($value);
        return $this;
    }

    /**
     * Unsets fingerprint field.
     */
    public function unsetFingerprint(): self
    {
        $this->instance->unsetFingerprint();
        return $this;
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
        return $this;
    }

    /**
     * Sets bank name field.
     */
    public function bankName(?string $value): self
    {
        $this->instance->setBankName($value);
        return $this;
    }

    /**
     * Unsets bank name field.
     */
    public function unsetBankName(): self
    {
        $this->instance->unsetBankName();
        return $this;
    }

    /**
     * Initializes a new bank account object.
     */
    public function build(): BankAccount
    {
        return CoreHelper::clone($this->instance);
    }
}

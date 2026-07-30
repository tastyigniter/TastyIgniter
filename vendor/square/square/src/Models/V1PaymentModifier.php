<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * V1PaymentModifier
 */
class V1PaymentModifier implements \JsonSerializable
{
    /**
     * @var array
     */
    private $name = [];

    /**
     * @var V1Money|null
     */
    private $appliedMoney;

    /**
     * @var array
     */
    private $modifierOptionId = [];

    /**
     * Returns Name.
     * The modifier option's name.
     */
    public function getName(): ?string
    {
        if (count($this->name) == 0) {
            return null;
        }
        return $this->name['value'];
    }

    /**
     * Sets Name.
     * The modifier option's name.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The modifier option's name.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Applied Money.
     */
    public function getAppliedMoney(): ?V1Money
    {
        return $this->appliedMoney;
    }

    /**
     * Sets Applied Money.
     *
     * @maps applied_money
     */
    public function setAppliedMoney(?V1Money $appliedMoney): void
    {
        $this->appliedMoney = $appliedMoney;
    }

    /**
     * Returns Modifier Option Id.
     * The ID of the applied modifier option, if available. Modifier options applied in older versions of
     * Square Register might not have an ID.
     */
    public function getModifierOptionId(): ?string
    {
        if (count($this->modifierOptionId) == 0) {
            return null;
        }
        return $this->modifierOptionId['value'];
    }

    /**
     * Sets Modifier Option Id.
     * The ID of the applied modifier option, if available. Modifier options applied in older versions of
     * Square Register might not have an ID.
     *
     * @maps modifier_option_id
     */
    public function setModifierOptionId(?string $modifierOptionId): void
    {
        $this->modifierOptionId['value'] = $modifierOptionId;
    }

    /**
     * Unsets Modifier Option Id.
     * The ID of the applied modifier option, if available. Modifier options applied in older versions of
     * Square Register might not have an ID.
     */
    public function unsetModifierOptionId(): void
    {
        $this->modifierOptionId = [];
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (!empty($this->name)) {
            $json['name']               = $this->name['value'];
        }
        if (isset($this->appliedMoney)) {
            $json['applied_money']      = $this->appliedMoney;
        }
        if (!empty($this->modifierOptionId)) {
            $json['modifier_option_id'] = $this->modifierOptionId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}

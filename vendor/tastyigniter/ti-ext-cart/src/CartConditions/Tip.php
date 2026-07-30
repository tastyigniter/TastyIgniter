<?php

declare(strict_types=1);

namespace Igniter\Cart\CartConditions;

use Igniter\Cart\CartCondition;
use Igniter\Cart\Models\CartSettings;
use Igniter\System\Models\Currency;
use Override;

class Tip extends CartCondition
{
    protected $tippingEnabled = false;

    protected $tipValueType;

    public ?int $priority = 100;

    #[Override]
    public function onLoad(): void
    {
        $this->tippingEnabled = (bool)CartSettings::get('enable_tipping');
        $this->tipValueType = CartSettings::get('tip_value_type', 'F'); // @phpstan-ignore-line arguments.count
    }

    #[Override]
    public function getLabel(): string
    {
        return lang($this->label);
    }

    #[Override]
    public function beforeApply(): ?bool
    {
        if (!$this->tippingEnabled) {
            return false;
        }

        // if amount is not set, empty or 0
        if (!$tipAmount = $this->getMetaData('amount')) {
            return false;
        }

        $value = $this->getMetaData('amount');
        if (!preg_match('/^\d+([\.\d]{2})?(%)?$/', (string)$value) || $value <= 0) {
            $this->removeMetaData('amount');
            flash()->warning(lang('igniter.cart::default.alert_tip_not_applied'))->now();
        }

        return null;
    }

    #[Override]
    public function getActions(): array
    {
        $amount = $this->getMetaData('amount');
        if (!$this->getMetaData('isCustom') && $this->tipValueType != 'F') {
            $amount .= '%';
        }

        $precision = optional(Currency::getDefault())->decimal_position ?? 2;

        return [
            ['value' => '+'.$amount, 'valuePrecision' => (int)$precision],
        ];
    }
}

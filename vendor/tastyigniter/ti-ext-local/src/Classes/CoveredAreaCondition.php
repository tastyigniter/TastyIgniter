<?php

declare(strict_types=1);

namespace Igniter\Local\Classes;

class CoveredAreaCondition
{
    public string $type;

    public float $amount;

    public float $total;

    public int $priority;

    public function __construct(array $condition = [])
    {
        $this->type = array_get($condition, 'type', 'all');
        $this->amount = (float)array_get($condition, 'amount', -1);
        $this->total = (float)array_get($condition, 'total', 0);
        $this->priority = (int)array_get($condition, 'priority', 999);
    }

    public function getLabel(): string
    {
        $condition['amount'] = lang('igniter::main.text_free');
        if ($this->amount < 0) {
            $condition['amount'] = lang('igniter.local::default.text_delivery_not_available');
        } elseif ($this->amount > 0) {
            $condition['amount'] = currency_format($this->amount);
        }

        $condition['total'] = $this->total !== 0.0
            ? currency_format($this->total)
            : lang('igniter.local::default.text_delivery_all_orders');

        $type = $this->type === 'all' ? 'all_orders' : $this->type.'_total';
        $label = lang('igniter.local::default.text_condition_'.$type);

        return parse_values($condition, $label);
    }

    public function getCharge(): null|float|int
    {
        return ($this->amount < 0) ? null : $this->amount;
    }

    public function getMinTotal(): float|int
    {
        return $this->total;
    }

    public function isValid($cartTotal): bool
    {
        if ($this->type === 'above' || $this->type === 'equals_or_greater') {
            return $cartTotal >= $this->total;
        }

        if ($this->type === 'equals_or_less') {
            return $cartTotal <= $this->total;
        }

        if ($this->type === 'greater') {
            return $cartTotal > $this->total;
        }

        if ($this->type === 'below' || $this->type === 'less') {
            return $cartTotal < $this->total;
        }

        return true;
    }
}

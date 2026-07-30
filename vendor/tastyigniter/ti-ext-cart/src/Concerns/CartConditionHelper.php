<?php

declare(strict_types=1);

namespace Igniter\Cart\Concerns;

use Illuminate\Support\Collection;
use InvalidArgumentException;

trait CartConditionHelper
{
    /**
     * @var Collection
     */
    protected $actionCollection;

    protected function validate(array $rules): bool
    {
        $validated = collect($rules)->filter(fn($rule) => $this->ruleIsValid($rule))->count();

        $passed = $validated == count($rules);

        if (is_null($this->passed)) {
            $passed ? $this->whenValid() : $this->whenInvalid();
        }

        return $this->passed = $passed;
    }

    /**
     * Added for backward compatibility
     */
    protected function processValue(float $subTotal): int|float
    {
        return $this->calculate($subTotal);
    }

    protected function processActionValue(array $action, float $total): array
    {
        $action = $this->parseAction($action);
        $actionValue = array_get($action, 'value', '0');
        $actionValuePrecision = (int)array_get($action, 'valuePrecision', 2);

        if ($this->valueIsPercentage((string)$actionValue)) {
            $cleanValue = $this->cleanValue((string)$actionValue);
            $value = ($total * ($cleanValue / 100));
        } else {
            $value = (float)$this->cleanValue((string)$actionValue);
        }

        $value = round($value, $actionValuePrecision);

        $this->calculatedValue += $value;
        $action['cleanValue'] = $value;

        return $action;
    }

    protected function calculateActionValue(array $action, float $total): float
    {
        $actionValue = (string)array_get($action, 'value', 0);
        $calculatedValue = array_get($action, 'cleanValue', 0);
        $actionMultiplier = array_get($action, 'multiplier');
        $actionMax = array_get($action, 'max', false);

        $result = $total;
        if (!$this->actionIsInclusive($action)) {
            if ($this->valueIsToBeSubtracted($actionValue)) {
                $result = ($total - $calculatedValue);
            } elseif ($this->valueIsToBeAdded($actionValue)) {
                $result = ($total + $calculatedValue);
            } elseif ($this->valueIsToBeMultiplied($actionValue)) {
                $result = ($total * $calculatedValue);
            } elseif ($this->valueIsToBeDivided($actionValue)) {
                $result = $total / $calculatedValue;
            }
        }

        if ($actionMultiplier) {
            $result = $total * $this->operandValue($actionMultiplier);
        }

        if ($this->actionHasReachedMax($actionMax, $result)) {
            $result = $actionMax;
        }

        return (float)max($result, 0);
    }

    protected function actionHasReachedMax($actionMax, $value)
    {
        return ($actionMax && $value > $actionMax) ? $actionMax : false;
    }

    /**
     * Removes some arithmetic signs (%,+,-, /, *) only
     */
    protected function cleanValue(string $value): int|float|string
    {
        return str_replace(['%', '-', '+', '*', '/'], '', $value) ?: 0;
    }

    protected function operandValue(int|string $key): int|float|string
    {
        if (!is_string($key)) {
            return $key;
        }

        if (property_exists($this, $key)) {
            return $this->{$key};
        }

        if ($key !== 'total' && $this->target && method_exists($this->target, $key)) {
            return call_user_func([$this->target, $key]);
        }

        return $key;
    }

    protected function ruleIsValid(string $rule): bool
    {
        [$leftOperand, $operator, $rightOperand] = $this->parseRule($rule);
        $leftOperand = $this->operandValue($leftOperand);
        $rightOperand = $this->operandValue($rightOperand);

        return match ($operator) {
            '=' => $leftOperand == $rightOperand,
            '==' => $leftOperand === $rightOperand,
            '!=' => $leftOperand != $rightOperand,
            '<' => $leftOperand < $rightOperand,
            '<=' => $leftOperand <= $rightOperand,
            '>' => $leftOperand > $rightOperand,
            '>=' => $leftOperand >= $rightOperand,
            default => false,
        };
    }

    protected function parseRule(string $rule): array
    {
        preg_match('/([a-zA-Z0-9\-?]+)\s*([\=\!\<\>]{1,2})\s*([\-?a-zA-Z0-9]+)/', $rule, $matches);

        if ($matches === []) {
            throw new InvalidArgumentException(sprintf('Cart condition rule [%s] format is invalid on %s.', $rule, $this::class));
        }

        array_shift($matches);

        return $matches;
    }

    protected function parseAction(array $action): array
    {
        if ($action === []) {
            return $action;
        }

        if (!array_key_exists('value', $action)) {
            throw new InvalidArgumentException(sprintf('Cart condition action [%s] format is invalid on %s.', json_encode($action), $this::class));
        }

        return $action;
    }

    protected function actionIsInclusive(array $action): bool
    {
        return array_get($action, 'inclusive', false);
    }

    /**
     * Check if value is a percentage
     */
    protected function valueIsPercentage(string $value): bool
    {
        return preg_match('/%/', $value) == 1;
    }

    /**
     * Check if value is a subtract
     */
    protected function valueIsToBeSubtracted(string $value): bool
    {
        return preg_match('/\-/', $value) == 1;
    }

    /**
     * Check if value is to be added
     */
    protected function valueIsToBeAdded(string $value): bool
    {
        return preg_match('/\+/', $value) == 1;
    }

    /**
     * Check if value is to be added
     */
    protected function valueIsToBeMultiplied(string $value): bool
    {
        return preg_match('/\*/', $value) == 1;
    }

    /**
     * Check if value is to be added
     */
    protected function valueIsToBeDivided(string $value): bool
    {
        return preg_match('/\\//', $value) == 1;
    }

    //
    // Session
    //

    public function getSessionKey(): string
    {
        return $this->sessionKey;
    }

    public function setSessionKey(string $sessionKey): static
    {
        $this->sessionKey = $sessionKey;

        return $this;
    }
}

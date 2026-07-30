<?php

declare(strict_types=1);

namespace Igniter\Cart;

use Igniter\Cart\Concerns\CartConditionHelper;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Override;

/**
 * CartCondition class
 */
abstract class CartCondition implements Arrayable, Jsonable
{
    use CartConditionHelper;

    //
    // Configurable properties
    //

    /**
     * The name for this cart condition.
     */
    public string $name = 'default';

    /**
     * The label for this cart condition.
     */
    public ?string $label = null;

    /**
     * The priority for this cart condition.
     */
    public ?int $priority = 0;

    public bool $removeable = false;

    //
    // Object properties
    //

    protected ?string $sessionKey = null;

    protected null|CartContent|CartItem $target = null;

    protected $passed;

    protected $calculatedValue;

    /**
     * CartItem constructor.
     *
     * @param array $config
     */
    public function __construct(
        /**
         * The config for this cart condition.
         */
        protected $config = [])
    {
        $this->fillFromConfig($this->config);
    }

    public function fillFromConfig($config): void
    {
        $this->label = array_get($config, 'label', $this->label);
        $this->name = array_get($config, 'name', $this->name);
        $this->priority = array_get($config, 'priority', $this->priority);
        $this->removeable = array_get($config, 'removeable', $this->removeable);

        $this->setSessionKey(array_get($config, 'sessionKey', $this->sessionKey ?? sprintf('cart-conditions.%s.%s',
            array_get($config, 'cartInstance', 'default'),
            $this->name,
        )));

        if ($metaData = array_get($config, 'metaData')) {
            Session::put($this->getSessionKey(), $metaData);
        }
    }

    public function isValid()
    {
        return $this->passed;
    }

    public function isApplied()
    {
        return $this->isValid();
    }

    public function isInclusive()
    {
        return collect($this->getActions())
            ->filter(fn($action) => array_get($action, 'inclusive', false))
            ->isNotEmpty();
    }

    /**
     * Apply condition to cart content
     *
     * @return float|string
     */
    public function apply($subTotal)
    {
        if ($this->beforeApply() === false) {
            return $subTotal;
        }

        if ($this->validate($this->getRules())) {
            $subTotal = $this->calculate($subTotal);
        }

        $this->afterApply();

        return $subTotal;
    }

    /**
     * Get the calculated the value of this condition
     * Used internally when applying to cart item
     *
     * @return float|string
     */
    public function calculate($subTotal)
    {
        $this->calculatedValue = 0;

        return collect($this->getActions())
            ->map(fn(array $action): array => $this->processActionValue($action, $subTotal))
            ->reduce(fn(float $total, array $action): float => $this->calculateActionValue($action, $total), $subTotal);
    }

    //
    // Extensions & Overrides
    //

    /**
     * Called before condition is loaded into cart session
     */
    public function onLoad() {}

    /**
     * Called before the applying of condition on the entire cart.
     */
    public function beforeApply() {}

    /**
     * Called after the applying of condition on the entire cart.
     */
    public function afterApply() {}

    /**
     * Returns the rules for this cart condition.
     *
     * @return array
     */
    public function getRules()
    {
        return [];
    }

    /**
     * Returns the actions for this cart condition.
     *
     * @return array
     */
    public function getActions()
    {
        return [];
    }

    /**
     * Called once when the condition validation passes.
     */
    public function whenValid() {}

    /**
     * Called once when the condition validation fails.
     */
    public function whenInvalid() {}

    //
    // Getters and Setters
    //

    public function withTarget(CartContent|CartItem|null $target)
    {
        $this->target = $target;

        return $this;
    }

    public function setCartContent(CartContent|CartItem|null $cartContent)
    {
        traceLog('CartCondition::setCartContent() is deprecated. See CartCondition::withTarget()');

        return $this->withTarget($cartContent);
    }

    public function getCartContent()
    {
        traceLog('CartCondition::getCartContent() is deprecated. Use Cart::content() instead');

        return $this->target;
    }

    public function getLabel()
    {
        return is_lang_key($this->label) ? lang($this->label) : $this->label;
    }

    public function getValue()
    {
        return $this->calculatedValue;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set the order in which this condition is applied.
     */
    public function setPriority(?int $priority = 999): void
    {
        $this->priority = $priority;
    }

    public function getMetaData($key = null, $default = null)
    {
        $metaData = Session::get($this->getSessionKey(), []);
        if (is_null($key)) {
            return $metaData;
        }

        return Arr::get($metaData, $key, $default);
    }

    public function setMetaData($key, $value = null): void
    {
        $metaData = Session::get($this->getSessionKey(), []);

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                Arr::set($metaData, $k, $v);
            }
        } else {
            Arr::set($metaData, $key, $value);
        }

        Session::put($this->getSessionKey(), $metaData);
    }

    public function removeMetaData($key = null): void
    {
        $metaData = Session::get($this->getSessionKey(), []);

        if (is_null($key)) {
            $metaData = [];
        } else {
            Arr::pull($metaData, $key);
        }

        Session::put($this->getSessionKey(), $metaData);
    }

    public function clearMetaData(): void
    {
        Session::pull($this->getSessionKey());
    }

    //
    //
    //

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    #[Override]
    public function toArray()
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'priority' => $this->priority,
            'removeable' => $this->removeable,
            'sessionKey' => $this->sessionKey,
            'config' => $this->config,
            'metaData' => Session::get($this->getSessionKey(), []),
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    #[Override]
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * String representation of object
     */
    public function __serialize(): array
    {
        return $this->toArray();
    }

    /**
     * Constructs the object
     */
    public function __unserialize(array $data): void
    {
        $this->fillFromConfig($data);
    }
}

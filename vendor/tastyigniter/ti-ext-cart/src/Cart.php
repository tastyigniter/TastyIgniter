<?php

declare(strict_types=1);

namespace Igniter\Cart;

use Closure;
use Exception;
use Igniter\Cart\Concerns\ActsAsItemable;
use Igniter\Cart\Contracts\Buyable;
use Igniter\Cart\Exceptions\InvalidRowIDException;
use Igniter\Cart\Exceptions\UnknownModelException;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Session\SessionManager;
use LogicException;

class Cart
{
    /**
     * Holds the current cart instance.
     */
    protected string $instance = 'default';

    /**
     * @var ?CartConditions Instance of the cart condition.
     */
    protected $conditions;

    /**
     * Cart constructor.
     */
    public function __construct(
        /**
         * Instance of the session manager.
         */
        protected SessionManager $session,
        /**
         * Instance of the event dispatcher.
         */
        protected Dispatcher $events,
    ) {}

    /**
     * Set the current cart instance.
     */
    public function instance(?string $instance = null): static
    {
        $instance = $instance ?: $this->instance;

        $this->instance = $instance;

        $this->fireEvent('created', $instance);

        return $this;
    }

    /**
     * Get the current cart instance.
     */
    public function currentInstance(): string
    {
        return $this->instance;
    }

    /**
     * Add an item to the cart.
     */
    public function add($buyable, int $qty = 0, array $options = [], $comment = null): array|CartItem
    {
        if ($this->isMulti($buyable)) {
            return array_map(fn($item): CartItem|array => $this->add($item), $buyable);
        }

        $cartItem = $this->createCartItem($buyable, $qty, $options, $comment);

        $this->fireEvent('adding', $cartItem);

        $content = $this->getContent();

        if ($content->has($cartItem->rowId)) {
            $cartItem->qty += $content->get($cartItem->rowId)->qty;
        }

        $this->applyAllConditionsToItem($cartItem);

        $content->put($cartItem->rowId, $cartItem);

        $this->putSession('content', $content);

        $this->fireEvent('added', $cartItem);

        return $cartItem;
    }

    /**
     * Update the cart item with the given rowId.
     */
    public function update(string $rowId, mixed $qty): CartItem
    {
        $cartItem = $this->get($rowId);

        $this->fireEvent('updating', $cartItem);

        if ($qty instanceof Buyable) {
            $cartItem->updateFromBuyable($qty);
        } elseif (is_array($qty)) {
            $cartItem->updateFromArray($qty);
        } else {
            $cartItem->qty = $qty;
        }

        $content = $this->getContent();

        if ($rowId !== $cartItem->rowId) {
            $content->pull($rowId);

            if ($content->has($cartItem->rowId)) {
                $existingCartItem = $this->get($cartItem->rowId);
                $cartItem->setQuantity($existingCartItem->qty + $cartItem->qty);
            }
        }

        if ($cartItem->qty <= 0) {
            $this->remove($cartItem->rowId);

            return $cartItem;
        }

        $this->applyAllConditionsToItem($cartItem);

        $content->put($cartItem->rowId, $cartItem);

        $this->putSession('content', $content);

        $this->fireEvent('updated', $cartItem);

        return $cartItem;
    }

    /**
     * Remove the cart item with the given rowId from the cart.
     */
    public function remove(string $rowId): void
    {
        $cartItem = $this->get($rowId);

        $this->fireEvent('removing', $cartItem);

        $content = $this->getContent();

        $content->pull($cartItem->rowId);

        $this->putSession('content', $content);

        $this->fireEvent('removed', $cartItem);
    }

    /**
     * Get a cart item from the cart by its rowId.
     */
    public function get(string $rowId): CartItem
    {
        $content = $this->getContent();

        if (!$content->has($rowId)) {
            throw new InvalidRowIDException(sprintf('The cart does not contain rowId %s.', $rowId));
        }

        return $content->get($rowId);
    }

    /**
     * Destroy the current cart instance.
     */
    public function destroy(?int $identifier = null): void
    {
        $this->fireEvent('clearing');

        $this->clearContent();
        $this->clearConditions();
        if (!is_null($identifier)) {
            $this->deleteStored($identifier);
        }

        $this->fireEvent('cleared');
    }

    /**
     * Get the content of the cart.
     */
    public function content(): CartContent
    {
        return $this->getContent();
    }

    /**
     * Get the number of items in the cart.
     */
    public function count(): int
    {
        return $this->getContent()->quantity();
    }

    /**
     * Get the total price of the items (with conditions) in the cart.
     *
     * @return string
     */
    public function total()
    {
        return $this->conditions()->apply($this->getContent());
    }

    /**
     * Get the subtotal (with conditions) of the items in the cart.
     *
     * @return float
     */
    public function subtotal()
    {
        return $this->getContent()->subtotal();
    }

    /**
     * Search the cart content for a cart item matching the given search closure.
     */
    public function search(Closure $search): CartContent
    {
        $content = $this->getContent();

        return $content->filter($search);
    }

    /**
     * Associate the cart item with the given rowId with the given model.
     */
    public function associate(string $rowId, mixed $model): void
    {
        if (is_string($model) && !class_exists($model)) {
            throw new UnknownModelException(sprintf('The supplied model %s does not exist.', $model));
        }

        $cartItem = $this->get($rowId);

        $cartItem->associate($model);

        $content = $this->getContent();

        $content->put($cartItem->rowId, $cartItem);

        $this->putSession('content', $content);
    }

    //
    // Conditions
    //

    /**
     * @return CartConditions
     */
    public function conditions()
    {
        $conditions = $this->getConditions();

        $conditions->apply($content = $this->getContent());

        return $conditions->applied();
    }

    public function conditionsWithoutApplied(): CartConditions
    {
        return $this->getConditions();
    }

    /**
     * Get condition applied on the cart by its name
     */
    public function getCondition($name): ?CartCondition
    {
        return $this->getConditions()->get($name);
    }

    /**
     * Clear a condition on a cart by its name,
     */
    public function removeCondition($name): ?bool
    {
        $cartCondition = $this->getCondition($name);

        $this->fireEvent('condition.removing', $cartCondition);

        if (!$cartCondition || !$cartCondition->removeable) {
            return false;
        }

        $cartCondition->clearMetaData();

        $this->removeItemCondition($cartCondition);

        $this->fireEvent('condition.removed', $cartCondition);

        return null;
    }

    public function clearConditions(): void
    {
        $this->fireEvent('condition.clearing');

        $this->getConditions()->each(function(CartCondition $condition): void {
            $condition->clearMetaData();
        });

        $this->clearItemConditions();

        $this->fireEvent('condition.cleared');
    }

    public function condition(CartCondition $condition): void
    {
        traceLog('Deprecated. Use Cart::loadCondition($condition) instead');
        $this->loadCondition($condition);
    }

    public function loadConditions(): void
    {
        traceLog('Deprecated. Use resolve(CartConditionManager::class)->loadCartConditions($cart) instead');
    }

    public function loadCondition(CartCondition $condition): void
    {
        // Extensibility
        $this->fireEvent('condition.loading', $condition);

        $conditions = $this->getConditions();

        if (is_null($condition->getPriority())) {
            $last = $conditions->last();
            $condition->setPriority(is_null($last) ? 1 : $last->getPriority() + 1);
        }

        $condition->onLoad();

        $this->fireEvent('condition.loaded', $condition);

        $conditions->put($condition->name, $condition);

        $this->loadItemsCondition($condition);

        $this->conditions = $conditions->sorted();
    }

    /**
     * Applies all conditions to a cart item.
     */
    protected function applyAllConditionsToItem(CartItem $cartItem)
    {
        foreach ($this->getConditions() as $condition) {
            $this->applyConditionToItem($condition, $cartItem);
        }
    }

    protected function applyConditionToItem(CartCondition $condition, CartItem $cartItem)
    {
        if (($itemCondition = $this->getApplicableItemCondition($condition, $cartItem)) instanceof CartCondition) {
            if (!$cartItem->conditions->has($itemCondition->name)) {
                $cartItem->conditions->put($itemCondition->name, $itemCondition);
            }
        } elseif ($cartItem->conditions) {
            $cartItem->conditions->forget($condition->name);
        }
    }

    protected function getApplicableItemCondition($condition, $cartItem): ?CartCondition
    {
        if (!in_array(ActsAsItemable::class, class_uses($condition))) {
            return null;
        }

        if (!$condition::isApplicableTo($cartItem)) {
            return null;
        }

        return $condition->toItem();
    }

    /**
     * Load condition on all existing cart items
     */
    protected function loadItemsCondition(CartCondition $condition)
    {
        $content = $this->getContent();

        $content->each(function(CartItem $cartItem) use ($condition): void {
            $this->applyConditionToItem($condition, $cartItem);
        });

        $this->putSession('content', $content);
    }

    /**
     * Remove an applied condition from all cart items
     */
    protected function removeItemCondition(CartCondition $condition)
    {
        $content = $this->getContent();

        $content->each(function(CartItem $cartItem) use ($condition): void {
            $cartItem->conditions->forget($condition->name);
        });

        $this->putSession('content', $content);
    }

    /**
     * Remove all applied conditions from all cart items
     */
    protected function clearItemConditions()
    {
        $content = $this->getContent();

        $content->each(function(CartItem $cartItem): void {
            $cartItem->clearConditions();
        });

        $this->putSession('content', $content);
    }

    //
    //
    //

    public function clearContent(): void
    {
        $this->fireEvent('content.clearing');

        $this->session->pull(sprintf('cart.%s.%s', $this->instance, 'content'));

        $this->fireEvent('content.cleared');
    }

    /**
     * Get the carts content, if there is no cart content set yet, return a new empty Collection
     */
    protected function getContent(): CartContent
    {
        if (!$content = $this->getSession('content')) {
            $content = new CartContent;
        }

        return $content;
    }

    /**
     * Get the carts conditions, if there is no cart condition set yet, return a new empty Collection
     */
    protected function getConditions(): CartConditions
    {
        if (!$this->conditions) {
            $this->conditions = new CartConditions;
        }

        return $this->conditions;
    }

    /**
     * Create a new CartItem from the supplied attributes.
     */
    protected function createCartItem($buyable, int $qty = 0, array $options = [], $comment = null): CartItem
    {
        if ($buyable instanceof Buyable) {
            $cartItem = CartItem::fromBuyable($buyable, $options, $comment);
            $cartItem->setQuantity($qty);
            $cartItem->associate($buyable);
        } else {
            $cartItem = CartItem::fromArray($buyable);
            $cartItem->setQuantity(array_get($buyable, 'qty', $qty));
        }

        return $cartItem;
    }

    /**
     * Check if the item is a multidimensional array or an array of Buyables.
     */
    protected function isMulti(mixed $item): bool
    {
        if (!is_array($item)) {
            return false;
        }

        return is_array(head($item)) || head($item) instanceof Buyable;
    }

    /**
     * Store the current instance of the cart.
     */
    public function store(int $identifier): void
    {
        $cartStore = $this->createModel()->firstOrCreate([
            'identifier' => $identifier,
            'instance' => $this->currentInstance(),
        ]);

        $cartStore->data = serialize([
            'content' => $this->getContent(),
            'conditions' => $this->getConditions(),
        ]);

        $cartStore->save();

        $this->fireEvent('stored', $identifier);
    }

    /**
     * Restore the cart with the given identifier.
     */
    public function restore(int $identifier): void
    {
        if (!$this->storedCartWithIdentifierExists($identifier)) {
            return;
        }

        $stored = $this->getStoredCartByIdentifier($identifier);

        $storedData = unserialize($stored->data);

        $content = $this->getContent();

        $storedContent = array_get($storedData, 'content');
        foreach ($storedContent as $cartItem) {
            $content->put($cartItem->rowId, $cartItem);
        }

        $storedConditions = array_get($storedData, 'conditions');
        foreach ($storedConditions as $cartCondition) {
            $this->getConditions()->put($cartCondition->name, $cartCondition);
        }

        $this->putSession('content', $content);

        $this->fireEvent('restored');

        $this->deleteStored($identifier);
    }

    public function deleteStored(int $identifier): void
    {
        $this->createModel()
            ->where('identifier', $identifier)
            ->where('instance', $this->currentInstance())
            ->delete();
    }

    /**
     * @return bool
     */
    protected function storedCartWithIdentifierExists($identifier)
    {
        return $this->createModel()
            ->where('identifier', $identifier)
            ->where('instance', $this->currentInstance())
            ->exists();
    }

    protected function getStoredCartByIdentifier($identifier)
    {
        return $this->createModel()
            ->where('identifier', $identifier)
            ->where('instance', $this->currentInstance())
            ->first();
    }

    /**
     * Create a new instance of the model
     * @return mixed
     * @throws Exception
     */
    protected function createModel()
    {
        $modelClass = config('igniter-cart.model');
        if (!$modelClass || !class_exists($modelClass)) {
            throw new LogicException(sprintf('Missing model [%s] in %s', $modelClass, static::class));
        }

        return new $modelClass;
    }

    //
    // Session
    //

    public function keepSession(Closure $callback)
    {
        if (config('igniter-cart.destroyOnLogout')) {
            return $callback();
        }

        $cartContent = $this->getContent();
        $cartConditions = $this->getConditions();

        $result = $callback();

        $this->putSession('content', $cartContent);
        $this->putSession('conditions', $cartConditions);

        return $result;
    }

    protected function getSession($key, $default = null)
    {
        return $this->session->get(sprintf('cart.%s.%s', $this->instance, $key), $default);
    }

    protected function putSession($key, $content)
    {
        $this->session->put(sprintf('cart.%s.%s', $this->instance, $key), $content);
    }

    //
    // Events
    //

    /**
     * @return mixed
     */
    protected function fireEvent(string $name, $payload = null)
    {
        if (is_null($payload)) {
            return $this->events->fire('cart.'.$name, [$this]);
        }

        return $this->events->fire('cart.'.$name, [$this, $payload]);
    }
}

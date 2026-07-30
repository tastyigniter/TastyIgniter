<?php

declare(strict_types=1);

namespace Igniter\Cart;

use Igniter\Cart\Contracts\Buyable;
use Igniter\Cart\Models\Menu;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use InvalidArgumentException;
use Override;

/**
 * CartItem class
 * @property Menu $model
 */
class CartItem implements Arrayable, Jsonable
{
    /**
     * The rowID of the cart item.
     *
     * @var string
     */
    public $rowId;

    /**
     * The ID of the cart item.
     *
     * @var int|string
     */
    public $id;

    /**
     * The quantity for this cart item.
     *
     * @var int|float
     */
    public $qty;

    /**
     * The name of the cart item.
     *
     * @var string
     */
    public $name;

    /**
     * The price of the cart item.
     *
     * @var float
     */
    public $price;

    /**
     * The comment of the cart item.
     *
     * @var string
     */
    public $comment;

    /**
     * The options for this cart item.
     */
    public CartItemOptions $options;

    /**
     * The conditions for this cart item.
     */
    public CartItemConditions $conditions;

    /**
     * The FQN of the associated model.
     */
    protected ?string $associatedModel = null;

    /**
     * CartItem constructor.
     */
    public function __construct(
        int|string $id,
        string $name,
        float $price,
        array $options = [],
        ?string $comment = null,
        array|CartItemConditions $conditions = [],
    ) {
        if ($id === 0 || strlen((string)$id) < 1) {
            throw new InvalidArgumentException('Please supply a valid cart item identifier.');
        }

        if (strlen($name) < 1) {
            throw new InvalidArgumentException('Please supply a valid cart item name.');
        }

        if ($price < 0) {
            throw new InvalidArgumentException('Please supply a valid cart item price.');
        }

        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->options = $this->makeCartItemOptions($options);
        $this->conditions = $this->makeCartItemConditions($conditions);
        $this->comment = $comment;
        $this->rowId = $this->generateRowId($id, $options);
    }

    /**
     * Returns the formatted price
     *
     * @return float
     */
    public function price()
    {
        return $this->price;
    }

    /**
     * Returns the subtotal.
     * Subtotal is price for whole CartItem with options
     *
     * @return float
     */
    public function subtotal()
    {
        $subtotal = $this->subtotalWithoutConditions();

        return optional($this->conditions)->apply($subtotal, $this) ?? $subtotal;
    }

    public function subtotalWithoutConditions(): float|int
    {
        $price = $this->price();

        $optionsSum = $this->options->subtotal();

        return $this->qty * ($price + $optionsSum);
    }

    public function comment()
    {
        return $this->comment;
    }

    public function hasOptions(): int
    {
        return count($this->options);
    }

    public function hasOptionValue($valueIndex)
    {
        return $this->options->filter(fn($option): bool => in_array($valueIndex, $option->values->pluck('id')->all()))->isNotEmpty();
    }

    public function hasConditions(): int
    {
        return $this->conditions->count();
    }

    public function clearConditions(): static
    {
        $this->conditions = new CartItemConditions;

        return $this;
    }

    public function getModel()
    {
        return is_null($this->associatedModel) ? null : (new $this->associatedModel)->find($this->id);
    }

    /**
     * Set the quantity for this cart item.
     *
     * @param int|float $qty
     */
    public function setQuantity($qty): void
    {
        if (!is_numeric($qty)) {
            throw new InvalidArgumentException('Please supply a valid quantity.');
        }

        $this->qty = $qty;
    }

    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    /**
     * Update the cart item from a Buyable.
     */
    public function updateFromBuyable(Buyable $item): void
    {
        $this->id = $item->getBuyableIdentifier();
        $this->name = $item->getBuyableName();
        $this->price = $item->getBuyablePrice();
    }

    /**
     * Update the cart item from an array.
     */
    public function updateFromArray(array $attributes): void
    {
        $this->id = array_get($attributes, 'id', $this->id);
        $this->name = array_get($attributes, 'name', $this->name);
        $this->price = array_get($attributes, 'price', $this->price);
        $this->qty = array_get($attributes, 'qty', $this->qty);
        $this->options = $this->makeCartItemOptions(array_get($attributes, 'options', $this->options));
        $this->conditions = $this->makeCartItemConditions(array_get($attributes, 'conditions', $this->conditions));
        $this->comment = array_get($attributes, 'comment', $this->comment);

        $this->rowId = $this->generateRowId($this->id, $this->options->all());
    }

    /**
     * Associate the cart item with the given model.
     */
    public function associate(mixed $model): static
    {
        $this->associatedModel = is_string($model) ? $model : $model::class;

        return $this;
    }

    /**
     * Get an attribute from the cart item or get the associated model.
     */
    public function __get(string $attribute): mixed
    {
        if ($attribute === 'subtotal') {
            return $this->subtotal();
        }

        if ($attribute === 'model' && !is_null($this->associatedModel)) {
            return (new $this->associatedModel)->find($this->id);
        }

        return null;
    }

    /**
     * Create a new instance from a Buyable.
     */
    public static function fromBuyable(Buyable $item, array $options = [], $comment = null, array $conditions = []): self
    {
        return new self(
            $item->getBuyableIdentifier(),
            $item->getBuyableName(),
            $item->getBuyablePrice(),
            $options,
            $comment,
            $conditions,
        );
    }

    /**
     * Create a new instance from the given array.
     */
    public static function fromArray(array $attributes): self
    {
        return new self(
            $attributes['id'],
            $attributes['name'],
            $attributes['price'],
            array_get($attributes, 'options', []),
            array_get($attributes, 'comment'),
            array_get($attributes, 'conditions', []),
        );
    }

    /**
     * Generate a unique id for the cart item.
     */
    protected function generateRowId(string|int $id, array $options): string
    {
        ksort($options);

        return md5($id.serialize($options).$this->comment);
    }

    protected function makeCartItemOptions($options)
    {
        if ($options instanceof CartItemOptions) {
            return $options;
        }

        return new CartItemOptions(array_map(CartItemOption::fromArray(...), $options));
    }

    protected function makeCartItemConditions($conditions)
    {
        if ($conditions instanceof CartItemConditions) {
            return $conditions;
        }

        return new CartItemConditions($conditions);
    }

    /**
     * Get the instance as an array.
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'rowId' => $this->rowId,
            'id' => $this->id,
            'name' => $this->name,
            'qty' => $this->qty,
            'price' => $this->price,
            'options' => $this->options->toArray(),
            'conditions' => $this->conditions->toArray(),
            'comment' => $this->comment,
            'subtotal' => $this->subtotal(),
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
    public function toJson($options = 0): string|false
    {
        return json_encode($this->toArray(), $options);
    }
}

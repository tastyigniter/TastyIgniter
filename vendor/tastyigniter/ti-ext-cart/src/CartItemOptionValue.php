<?php

declare(strict_types=1);

namespace Igniter\Cart;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use InvalidArgumentException;
use Override;

class CartItemOptionValue implements Arrayable, Jsonable
{
    /**
     * The ID of the cart item option value.
     *
     * @var int|string
     */
    public $id;

    /**
     * The name of the cart item option value.
     *
     * @var string
     */
    public $name;

    /**
     * The quantity for this cart item option value.
     *
     * @var int|float
     */
    public $qty = 1;

    /**
     * The price of the cart item option value.
     *
     * @var float
     */
    public $price;

    /**
     * The number of free units within qty for this cart item option value.
     *
     * @var int
     */
    public $free_qty = 0;

    /**
     * CartItem constructor.
     */
    public function __construct(int|string $id, string $name, float $price)
    {
        if ($id === 0 || strlen((string)$id) < 1) {
            throw new InvalidArgumentException('Please supply a valid cart item option value identifier.');
        }

        if (strlen($name) < 1) {
            throw new InvalidArgumentException('Please supply a valid cart item option value name.');
        }

        if ($price < 0) {
            throw new InvalidArgumentException('Please supply a valid cart item option value price.');
        }

        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * Returns the formatted price of this cart item option value
     */
    public function price(): float
    {
        return $this->price;
    }

    /**
     * Returns the subtotal.
     * Subtotal is price for whole CartItem with options
     */
    public function subtotal(): int|float
    {
        return max(0, $this->qty - $this->free_qty) * $this->price;
    }

    /**
     * Set the number of free units within qty for this cart item option value.
     */
    public function setFreeQty(int $freeQty): void
    {
        $this->free_qty = max(0, $freeQty);
    }

    /**
     * Set the quantity for this cart item.
     *
     * @param int|float $qty
     */
    public function setQuantity($qty): void
    {
        if (!is_numeric($qty)) {
            throw new InvalidArgumentException('Please supply a valid item option quantity.');
        }

        $this->qty = $qty;
    }

    /**
     * Update the cart item option value from an array.
     */
    public function updateFromArray(array $attributes): void
    {
        $this->id = array_get($attributes, 'id', $this->id);
        $this->name = array_get($attributes, 'name', $this->name);
        $this->price = array_get($attributes, 'price', $this->price);
        $this->qty = array_get($attributes, 'qty', $this->qty);
        $this->setFreeQty((int)array_get($attributes, 'free_qty', $this->free_qty));
    }

    /**
     * Create a new instance from the given array.
     */
    public static function fromArray(array $attributes): self
    {
        $instance = new self(
            $attributes['id'],
            $attributes['name'],
            $attributes['price'],
        );

        $instance->qty = array_get($attributes, 'qty', $instance->qty);
        $instance->setFreeQty((int)array_get($attributes, 'free_qty', $instance->free_qty));

        return $instance;
    }

    /**
     * Get the instance as an array.
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'qty' => $this->qty,
            'price' => $this->price,
            'free_qty' => $this->free_qty,
            'subtotal' => $this->subtotal(),
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     * @return string
     */
    #[Override]
    public function toJson($options = 0): string|false
    {
        return json_encode($this->toArray(), $options);
    }
}

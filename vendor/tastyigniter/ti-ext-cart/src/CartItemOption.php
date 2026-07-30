<?php

declare(strict_types=1);

namespace Igniter\Cart;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Override;

class CartItemOption implements Arrayable, Jsonable
{
    /**
     * The ID of the cart item option.
     *
     * @var int|string
     */
    public $id;

    /**
     * The name of the cart item option.
     *
     * @var string
     */
    public $name;

    /**
     * @var Collection The values for this cart item option.
     */
    public $values;

    /**
     * CartItem constructor.
     */
    public function __construct(int|string $id, string $name, array|CartItemOptionValues $values = [])
    {
        if ($id === 0 || strlen((string)$id) < 1) {
            throw new InvalidArgumentException('Please supply a valid cart item option identifier.');
        }

        if (strlen($name) < 1) {
            throw new InvalidArgumentException('Please supply a valid cart item option name.');
        }

        $this->id = $id;
        $this->name = $name;
        $this->values = $this->makeCartOptionValues($values);
    }

    /**
     * Returns the subtotal.
     * Subtotal is price for whole CartItem with options
     */
    public function subtotal(): float|int
    {
        return $this->values->reduce(fn($subtotal, CartItemOptionValue $optionValue): float|int => $subtotal + $optionValue->subtotal(), 0);
    }

    /**
     * Update the cart item from an array.
     */
    public function updateFromArray(array $attributes): void
    {
        $this->id = array_get($attributes, 'id', $this->id);
        $this->name = array_get($attributes, 'name', $this->name);
        $this->values = $this->makeCartOptionValues(array_get($attributes, 'values', $this->values));
    }

    /**
     * Create a new instance from the given array.
     */
    public static function fromArray(array $attributes): self
    {
        return new self(
            $attributes['id'],
            $attributes['name'],
            array_get($attributes, 'values', []),
        );
    }

    protected function makeCartOptionValues($values)
    {
        if ($values instanceof CartItemOptionValues) {
            return $values;
        }

        return new CartItemOptionValues(array_map(CartItemOptionValue::fromArray(...), $values));
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
            'values' => $this->values,
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

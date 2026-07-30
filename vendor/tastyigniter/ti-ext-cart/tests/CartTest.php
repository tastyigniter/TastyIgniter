<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests;

use Igniter\Cart\Cart;
use Igniter\Cart\CartCondition;
use Igniter\Cart\CartConditions\Tax;
use Igniter\Cart\CartItem;
use Igniter\Cart\CartItemOption;
use Igniter\Cart\CartItemOptionValue;
use Igniter\Cart\Concerns\ActsAsItemable;
use Igniter\Cart\Exceptions\InvalidRowIDException;
use Igniter\Cart\Exceptions\UnknownModelException;
use Igniter\Cart\Models\Cart as CartModel;
use Igniter\Cart\Models\Menu;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use InvalidArgumentException;
use LogicException;

beforeEach(function(): void {
    $this->cart = resolve(Cart::class);
});

it('adds item to the cart correctly', function(): void {
    $cartItem = $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);
    $cartItem->setComment('Test comment');

    expect($this->cart->content())->toHaveCount(1)
        ->and($cartItem->id)->toBe(1)
        ->and($cartItem->comment())->toBe('Test comment');
});

it('adds multiple items to the cart correctly', function(): void {
    $cartItems = $this->cart->add([
        [
            'id' => 1,
            'name' => 'Test Item',
            'price' => 10.00,
        ],
        [
            'id' => 2,
            'name' => 'Test Item 2',
            'price' => 20.00,
        ],
    ]);

    expect($this->cart->content())->toHaveCount(2)
        ->and($cartItems[0]->id)->toBe(1)
        ->and($cartItems[1]->id)->toBe(2);
});

it('adds item updates quantity correctly', function(): void {
    $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);
    $cartItem = $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 3);

    expect($this->cart->content())->toHaveCount(1)
        ->and($cartItem->qty)->toBe(4);
});

it('adds item with options to the cart correctly', function(): void {
    $cartItem = $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
        'options' => [
            [
                'id' => 111,
                'name' => 'Size',
                'values' => [
                    [
                        'id' => 1111,
                        'name' => 'Small',
                        'price' => 0.00,
                    ],
                    [
                        'id' => 1112,
                        'name' => 'Medium',
                        'price' => 1.00,
                    ],
                    [
                        'id' => 1113,
                        'name' => 'Large',
                        'price' => 2.00,
                    ],
                ],
            ],
            [
                'id' => 222,
                'name' => 'Topings',
                'values' => [
                    [
                        'id' => 2221,
                        'name' => 'Cheese',
                        'price' => 1.00,
                    ],
                ],
            ],
        ],
    ], 1);

    expect($this->cart->content())->toHaveCount(1)
        ->and($cartItem->hasOptions())->toBe(2)
        ->and($cartItem->hasOptionValue(1113))->toBeTrue()
        ->and($cartItem->options->subtotal())->toBe(4.0);
});

it('adds item with conditions to the cart correctly', function(): void {
    $condition = new class(['name' => 'VAT', 'value' => '10%']) extends CartCondition
    {
        use ActsAsItemable {
            ActsAsItemable::isApplicableTo as parentIsApplicableTo;
        }

        public static function isApplicableTo($cartItem): bool
        {
            self::parentIsApplicableTo($cartItem);

            return true;
        }

        public function toArray(): array
        {
            return ['name' => 'VATPlus', 'value' => '10%'];
        }
    };

    Location::setModel(LocationModel::factory()->create());
    $this->cart->loadCondition($condition);
    $cartItem = $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
        'conditions' => ['VAT' => $condition],
    ], 1);

    expect($this->cart->total())->toBe(10.00)
        ->and($cartItem->hasConditions())->toBe(2)
        ->and($cartItem->conditions->count())->toEqual(2);
});

it('does not add item condition when not applicable', function(): void {
    Location::setModel(LocationModel::factory()->create());
    $cartItem = $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
        'conditions' => [
            'VAT' => new Tax([
                'name' => 'VAT',
                'type' => 'tax',
                'target' => 'total',
                'value' => '10%',
            ]),
        ],
    ], 1);

    $this->cart->loadCondition(new Tax([
        'name' => 'VAT',
        'type' => 'tax',
        'target' => 'total',
        'value' => '10%',
    ]));

    expect($this->cart->total())->toBe(10.00)
        ->and($cartItem->conditions->count())->toEqual(0);
});

it('updates item in the cart correctly', function(): void {
    $cartItem = $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);

    $this->cart->update($cartItem->rowId, 2);

    expect($this->cart->get($cartItem->rowId)->qty)->toBe(2);
});

it('updates cart item from Buyable instance', function(): void {
    $menu = Menu::factory()->create([
        'menu_name' => 'Test Menu',
        'menu_price' => 40.00,
    ]);
    $cartItem = $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);

    $updatedCartItem = $this->cart->update($cartItem->rowId, $menu);

    expect($updatedCartItem->price)->toBe(40.0);
});

it('updates cart item from array', function(): void {
    $cartItem = $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);

    $updatedCartItem = $this->cart->update($cartItem->rowId, [
        'id' => 2,
        'name' => 'Updated Item',
        'price' => 20.00,
    ]);

    expect($updatedCartItem->toArray()['name'])->toBe('Updated Item')
        ->and($updatedCartItem->toJson())->toContain('Updated Item');
});

it('throws exception when setting invalid quantity on cart item', function(): void {
    $cartItem = $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);

    expect($cartItem->invalidProperty)->toBeNull();

    $cartItem->setQuantity('invalid-quantity');
})->throws(InvalidArgumentException::class);

it('removes cart item when quantity is zero or less', function(): void {
    $cartItem = $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);

    $this->cart->update($cartItem->rowId, 0);

    expect($this->cart->content())->toBeEmpty();
});

it('updates cart item merges quantities when rowId changes', function(): void {
    $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);

    $cartItem = $this->cart->add([
        'id' => 2,
        'name' => 'Test Item 2',
        'price' => 10.00,
    ], 1);

    $this->cart->update($cartItem->rowId, [
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ]);

    expect($this->cart->content())->toHaveCount(1)
        ->and($this->cart->content()->first()->qty)->toBe(2);
});

it('updates cart item option from array', function(): void {
    $cartItemOption = new CartItemOption(1, 'Option 1', []);
    $attributes = ['id' => 2, 'name' => 'Updated Option'];

    $cartItemOption->updateFromArray($attributes);

    expect($cartItemOption->id)->toBe(2)
        ->and($cartItemOption->name)->toBe('Updated Option')
        ->and($cartItemOption->toJson())->toContain('Updated Option');
});

it('throws exception when creating cart item with invalid value', function(): void {
    expect(fn(): CartItemOption => new CartItemOption('', 'Option 1', []))
        ->toThrow(InvalidArgumentException::class)
        ->and(fn(): CartItemOption => new CartItemOption(1, '', []))
        ->toThrow(InvalidArgumentException::class);
});

it('throws exception when creating cart item option with invalid value', function(): void {
    expect(fn(): CartItem => new CartItem('', 'Option 1', 10, []))
        ->toThrow(InvalidArgumentException::class)
        ->and(fn(): CartItem => new CartItem(1, '', 10, []))
        ->toThrow(InvalidArgumentException::class)
        ->and(fn(): CartItem => new CartItem(1, 'Option 1', -0.3, []))
        ->toThrow(InvalidArgumentException::class);
});

it('updates cart item option value from array', function(): void {
    $cartItemOptionValue = new CartItemOptionValue(1, 'Option Value 1', 10);
    $attributes = ['id' => 2, 'name' => 'Updated Option Value'];

    $cartItemOptionValue->updateFromArray($attributes);
    $cartItemOptionValue->setQuantity(10);

    expect($cartItemOptionValue->id)->toBe(2)
        ->and($cartItemOptionValue->price())->toBe(10.0)
        ->and($cartItemOptionValue->name)->toBe('Updated Option Value')
        ->and($cartItemOptionValue->toJson())->toContain('Updated Option Value');
});

it('throws exception when creating cart item option value with invalid value', function(): void {
    expect(fn(): CartItemOptionValue => new CartItemOptionValue('', 'Option 1', 10))->toThrow(InvalidArgumentException::class)
        ->and(fn(): CartItemOptionValue => new CartItemOptionValue(1, '', 10))->toThrow(InvalidArgumentException::class)
        ->and(fn(): CartItemOptionValue => new CartItemOptionValue(1, 'Option 1', -1))->toThrow(InvalidArgumentException::class);
});

it('throws exception when setting invalid quantity on cart item option value', function(): void {
    $cartItemOptionValue = new CartItemOptionValue(1, 'Option Value 1', 10);

    $cartItemOptionValue->setQuantity('invalid-quantity');
})->throws(InvalidArgumentException::class);

it('removes item from the cart correctly', function(): void {
    $cartItem = $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);

    $this->cart->remove($cartItem->rowId);

    expect($this->cart->content())->toBeEmpty();
});

it('throws exception when rowId does not exist', function(): void {
    $this->cart->remove('invalid-row-id');
})->throws(InvalidRowIDException::class);

it('associates cart item with valid model', function(): void {
    $menu = Menu::factory()->create([
        'menu_name' => 'Test Menu',
        'menu_price' => 40.00,
    ]);

    $cartItem = $this->cart->add($menu, 1);

    $this->cart->associate($cartItem->rowId, $menu);

    expect($cartItem->getModel()->getKey())->toBe($menu->getKey());
});

it('throws exception when associating with non-existent model', function(): void {
    $this->cart->associate('rowId123', 'InvalidModel');
})->throws(UnknownModelException::class);

it('removes cart & item conditions when it is removable', function(): void {
    $condition = new Tax([
        'name' => 'VAT',
        'type' => 'tax',
        'target' => 'total',
        'value' => '10%',
        'removeable' => true,
    ]);
    $this->cart->loadCondition($condition);
    $cartItem = $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
        'conditions' => [
            'VAT' => $condition,
        ],
    ], 1);

    $this->cart->removeCondition($condition->name);

    expect($this->cart->get($cartItem->rowId)->conditions->count())->toEqual(0);
});

it('does not remove cart & item condition when it is not removable', function(): void {
    $condition = new Tax([
        'name' => 'VAT',
        'type' => 'tax',
        'target' => 'total',
        'value' => '10%',
        'removeable' => false,
    ]);
    $this->cart->condition($condition);
    $cartItem = $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);
    $cartItem->conditions->put('VAT', $condition);

    $this->cart->removeCondition($condition->name);

    expect($this->cart->get($cartItem->rowId)->conditions->count())->toEqual(1);
});

it('clears conditions', function(): void {
    $condition = new Tax([
        'name' => 'VAT',
        'type' => 'tax',
        'target' => 'total',
        'value' => '10%',
    ]);
    $this->cart->loadCondition($condition);
    $cartItem = $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);
    $cartItem->conditions->put('VAT', $condition);

    $this->cart->clearConditions();

    expect($this->cart->get($cartItem->rowId)->conditions->count())->toEqual(0);
});

it('logs deprecation message when loadConditions is called', function(): void {
    expect($this->cart->loadConditions())->toBeNull();
});

it('applies conditions to the cart correctly', function(): void {
    $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);

    $condition = new Tax([
        'name' => 'VAT',
        'type' => 'tax',
        'target' => 'total',
        'value' => '10%',
    ]);
    $this->cart->loadCondition($condition);

    expect($this->cart->total())->toBe(10.00)
        ->and($this->cart->content()->subtotalWithoutConditions())->toBeGreaterThan(0);
});

it('loads condition and sets priority based on last condition', function(): void {
    $condition1 = new Tax([
        'name' => 'VAT',
        'type' => 'tax',
        'target' => 'total',
        'value' => '10%',
    ]);
    $condition2 = new Tax([
        'name' => 'VAT',
        'type' => 'tax',
        'target' => 'total',
        'value' => '20%',
    ]);
    $condition1->priority = null;
    $condition2->priority = null;

    $this->cart->loadCondition($condition1);
    $this->cart->loadCondition($condition2);

    $conditions = $this->cart->conditionsWithoutApplied();

    expect($conditions->first()->priority)->toBe(2)
        ->and($conditions->last()->priority)->toBe(2);
});

it('clears the cart correctly', function(): void {
    $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);

    $this->cart->destroy(1);

    expect($this->cart->content())->toBeEmpty();
});

it('searches the cart correctly', function(): void {
    $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);

    $searchResult = $this->cart->search(fn($cartItem, $rowId): bool => $cartItem->id === 1);

    expect($searchResult)->toHaveCount(1);
});

it('stores the cart correctly', function(): void {
    $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);

    $this->cart->store(123);

    expect(CartModel::where('identifier', 123)->exists())->toBeTrue();
});

it('restores the cart correctly', function(): void {
    $this->cart->add([
        'id' => 1,
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);

    $this->cart->loadCondition(new Tax([
        'name' => 'VAT',
        'type' => 'tax',
        'target' => 'total',
        'value' => '10%',
    ]));

    expect($this->cart->restore(123))->toBeNull();

    $this->cart->store(123);
    $this->cart->destroy();

    $this->cart->restore(123);

    expect($this->cart->content())->toHaveCount(1);
});

it('keeps session when destroyOnLogout is false', function(): void {
    config(['igniter-cart.destroyOnLogout' => false]);

    $result = $this->cart->keepSession(fn(): string => 'callback result');

    expect($result)->toBe('callback result');
});

it('does not keep session when destroyOnLogout is true', function(): void {
    config(['igniter-cart.destroyOnLogout' => true]);

    $result = $this->cart->keepSession(fn(): string => 'callback result');

    expect($result)->toBe('callback result');
});

it('throws exception when model class does not exists', function(): void {
    config(['igniter-cart.model' => 'InvalidModel']);

    $this->cart->deleteStored(1);
})->throws(LogicException::class);

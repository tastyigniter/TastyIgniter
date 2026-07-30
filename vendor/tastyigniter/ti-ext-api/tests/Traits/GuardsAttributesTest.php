<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Traits;

use Igniter\Api\Classes\AbstractRepository;

beforeEach(function(): void {
    $this->traitObject = new class extends AbstractRepository
    {
        protected $fillable = ['name', 'email'];

        protected $guarded = ['password'];

        protected $hidden = ['password'];

        protected $visible = ['name', 'email'];

        public function getNameAttribute($value): string
        {
            return 'John Doe';
        }

        public function setNameAttribute($value)
        {
            return $value;
        }
    };
});

it('returns fillable attributes correctly', function(): void {
    $result = $this->traitObject->getFillable();

    expect($result)->toBe(['name', 'email']);
});

it('returns guarded attributes correctly', function(): void {
    $result = $this->traitObject->getGuarded();

    expect($result)->toBe(['password']);
});

it('returns hidden attributes correctly', function(): void {
    $result = $this->traitObject->getHidden();

    expect($result)->toBe(['password']);
});

it('returns visible attributes correctly', function(): void {
    $result = $this->traitObject->getVisible();

    expect($result)->toBe(['name', 'email']);
});

it('sets model attribute using mutator', function(): void {
    $result = $this->traitObject->setModelAttribute('name', 'John');

    expect($result)->toBe($this->traitObject);
});

it('gets model attribute using mutator', function(): void {
    $result = $this->traitObject->getModelAttribute('name', 'John');

    expect($result)->toBe('John Doe');
});

it('determines if a get mutator exists for an attribute', function(): void {
    $result = $this->traitObject->hasGetMutator('name');

    expect($result)->toBeTrue();
});

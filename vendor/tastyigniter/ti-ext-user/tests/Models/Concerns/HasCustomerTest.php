<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Models\Concerns;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Relations\BelongsTo;
use Igniter\Flame\Database\Relations\HasMany;
use Igniter\User\Models\Concerns\HasCustomer;
use Mockery;
use ReflectionClass;

beforeEach(function(): void {
    $this->model = Mockery::mock(HasCustomer::class)->makePartial()->shouldAllowMockingProtectedMethods();
});

it('applies customer scope with customer id as integer', function(): void {
    $query = Mockery::mock(Builder::class);
    $relation = Mockery::mock(BelongsTo::class);
    $relation->shouldReceive('getQualifiedForeignKeyName')->andReturn('customer_id');
    $this->model->shouldReceive('customer')->andReturn($relation);
    $this->model->shouldReceive('getRelationType')->andReturn('belongsTo');
    $query->shouldReceive('where')->with('customer_id', 1)->andReturnSelf();

    $result = $this->model->scopeApplyCustomer($query, 1);

    expect($result)->toBe($query);
});

it('applies customer scope with customer id as model', function(): void {
    $query = Mockery::mock(Builder::class);
    $customer = Mockery::mock(Model::class)->makePartial();
    $relation = Mockery::mock(BelongsTo::class);
    $customer->shouldReceive('getKey')->andReturn(1);
    $relation->shouldReceive('getQualifiedForeignKeyName')->andReturn('customer_id');
    $this->model->shouldReceive('customer')->andReturn($relation);
    $this->model->shouldReceive('getRelationType')->andReturn('belongsTo');
    $query->shouldReceive('where')->with('customer_id', 1)->andReturnSelf();

    $result = $this->model->scopeApplyCustomer($query, $customer);

    expect($result)->toBe($query);
});

it('applies customer scope with hasMany relation', function(): void {
    $query = Mockery::mock(Builder::class);
    $relation = Mockery::mock(HasMany::class);
    $relation->shouldReceive('getQualifiedForeignKeyName')->andReturn('customer_id');
    $this->model->shouldReceive('customer')->andReturn($relation);
    $this->model->shouldReceive('getRelationType')->andReturn('hasMany');
    $query->shouldReceive('whereHas')->with('customer', Mockery::on(function($callback): true {
        $subQuery = Mockery::mock(Builder::class);
        $subQuery->shouldReceive('where')->with('customer_id', 1)->andReturnSelf();
        $callback($subQuery);

        return true;
    }))->andReturnSelf();

    $result = $this->model->scopeApplyCustomer($query, 1);

    expect($result)->toBe($query);
});

it('returns customer relation name from constant', function(): void {
    $model = new class extends Model
    {
        public const string CUSTOMER_RELATION = 'custom_relation';

        use HasCustomer;

        public function getNameInTest(): string
        {
            return $this->getCustomerRelationName();
        }
    };

    $result = $model->getNameInTest();

    expect($result)->toBe('custom_relation');
});

it('returns default customer relation name', function(): void {
    $reflection = new ReflectionClass($this->model);
    $method = $reflection->getMethod('getCustomerRelationName');

    $result = $method->invoke($this->model);

    expect($result)->toBe('customer');
});

it('returns true for single relation type', function(): void {
    $this->model->shouldReceive('getRelationType')->with('customer')->andReturn('hasOne');

    $reflection = new ReflectionClass($this->model);
    $method = $reflection->getMethod('customerIsSingleRelationType');

    $result = $method->invoke($this->model);

    expect($result)->toBeTrue();
});

it('returns false for multiple relation type', function(): void {
    $this->model->shouldReceive('getRelationType')->with('customer')->andReturn('hasMany');

    $reflection = new ReflectionClass($this->model);
    $method = $reflection->getMethod('customerIsSingleRelationType');

    $result = $method->invoke($this->model);

    expect($result)->toBeFalse();
});

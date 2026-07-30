<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Classes;

use Igniter\Api\Classes\AbstractRepository;
use Igniter\Api\Tests\Fixtures\TestModel;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\SystemException;
use Igniter\User\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Mockery;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

beforeEach(function(): void {
    $this->repository = Mockery::mock(AbstractRepository::class)->makePartial()->shouldAllowMockingProtectedMethods();
    $this->model = Mockery::mock(Model::class)->makePartial();
});

it('finds a record by id', function(): void {
    $this->repository->shouldReceive('createModel')->andReturn($this->model);
    $this->repository->shouldReceive('prepareQuery')->andReturn($this->model);
    $this->model->shouldReceive('find')->with(1, ['*'])->andReturn($this->model);

    $result = $this->repository->find(1);

    expect($result)->toBe($this->model);
});

it('finds a record by id and applies location aware scope', function(): void {
    $model = Mockery::mock(Order::class)->makePartial();
    $this->repository->shouldReceive('createModel')->andReturn($model);
    $this->repository->shouldReceive('prepareQuery')->andReturn($model);
    $model->shouldReceive('find')->with(1, ['*'])->andReturn($model);

    $result = $this->repository->find(1);

    expect($result)->toBe($model);
});

it('throws exception when record not found by id', function(): void {
    $this->repository->shouldReceive('createModel')->andReturn($this->model);
    $this->repository->shouldReceive('prepareQuery')->andReturn($this->model);
    $this->model->shouldReceive('find')->with(1, ['*'])->andReturn(null);

    $this->expectException(NotFoundHttpException::class);

    $this->repository->find(1);
});

it('finds a record by attribute', function(): void {
    $this->repository->shouldReceive('createModel')->andReturn($this->model);
    $this->repository->shouldReceive('prepareQuery')->andReturn($this->model);
    $this->model->shouldReceive('where')->with('name', 'test')->andReturnSelf();
    $this->model->shouldReceive('first')->with(['*'])->andReturn($this->model);

    $result = $this->repository->findBy('name', 'test');

    expect($result)->toBe($this->model);
});

it('returns paginated results when model does not have scopeListFrontEnd', function(): void {
    $noScopeListFrontEndModel = Mockery::mock(\Illuminate\Database\Eloquent\Model::class)->makePartial();
    $this->repository->shouldReceive('createModel')->andReturn($noScopeListFrontEndModel);
    $this->repository->shouldReceive('paginate')->with(5, null)->andReturn('paginated_result');

    $result = $this->repository->findAll();

    expect($result)->toBe('paginated_result');
});

it('returns frontend list results when model has scopeListFrontEnd', function(): void {
    $builder = Mockery::mock(Builder::class);
    $builder->shouldReceive('listFrontEnd')->with(['option' => 'value', 'pageLimit' => 10])->andReturn('frontend_list_result');
    $this->repository->shouldReceive('createModel')->andReturn($this->model);
    $this->repository->shouldReceive('prepareQuery')->andReturn($builder);

    $result = $this->repository->findAll(['option' => 'value', 'pageLimit' => 10]);

    expect($result)->toBe('frontend_list_result');
});

it('paginates results with default parameters', function(): void {
    $model = Mockery::mock(Model::class);
    $builder = Mockery::mock(Builder::class);
    $this->repository->shouldReceive('createModel')->andReturn($this->model);
    $this->repository->shouldReceive('prepareQuery')->andReturn($builder);
    $builder->shouldReceive('paginate')->with(null, ['*'], 'page', null);

    $result = $this->repository->paginate();

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
});

it('paginates results with custom parameters', function(): void {
    $model = Mockery::mock(Model::class);
    $query = Mockery::mock(Builder::class);
    $repository = Mockery::mock(AbstractRepository::class)->makePartial()->shouldAllowMockingProtectedMethods();

    $repository->shouldReceive('createModel')->andReturn($model);
    $repository->shouldReceive('prepareQuery')->with($model)->andReturn($query);
    $query->shouldReceive('paginate')->with(10, ['id', 'name'], 'custom_page', 2);

    $result = $repository->paginate(10, 2, 'custom_page', ['id', 'name']);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
});

it('creates a new record', function(): void {
    $attributes = ['name' => 'test'];
    $customer = Mockery::mock(Customer::class)->makePartial();
    $customer->shouldReceive('getKey')->andReturn(1);
    $this->repository->shouldReceive('createModel')->andReturn($this->model);
    $this->repository->shouldReceive('setModelAttributes')->with($this->model, $attributes);
    $this->repository->shouldReceive('getCustomerAwareColumn')->andReturn('customer_id');
    $this->repository->shouldReceive('getCustomerAwareUser')->andReturn($customer);
    $this->repository->shouldReceive('fireSystemEvent')->with('api.repository.beforeCreate', [$this->model, $attributes]);
    $this->repository->shouldReceive('fireSystemEvent')->with('api.repository.afterCreate', [$this->model, true]);
    $this->model->shouldReceive('reload');

    DB::shouldReceive('transaction')->andReturnUsing(function($callback): void {
        $callback();
    });

    $result = $this->repository->create($this->model, $attributes);

    expect($result)->toBe($this->model);
});

it('updates an existing record', function(): void {
    $attributes = ['name' => 'updated'];
    $this->repository->shouldReceive('find')->with(1)->andReturn($this->model);
    $this->repository->shouldReceive('setModelAttributes')->with($this->model, $attributes);
    $this->repository->shouldReceive('fireSystemEvent')->with('api.repository.beforeUpdate', [$this->model, $attributes]);
    $this->repository->shouldReceive('fireSystemEvent')->with('api.repository.afterUpdate', [$this->model, true]);

    DB::shouldReceive('transaction')->andReturnUsing(function($callback): void {
        $callback();
    });

    $result = $this->repository->update(1, $attributes);

    expect($result)->toBe($this->model);
});

it('returns null when model not found for update', function(): void {
    $attributes = ['name' => 'updated'];
    $this->repository->shouldReceive('find')->with(1)->andReturn(null);

    $result = $this->repository->update(1, $attributes);

    expect($result)->toBeNull();
});

it('deletes a record by id', function(): void {
    $this->repository->shouldReceive('find')->with(1)->andReturn($this->model);
    $this->model->shouldReceive('delete')->andReturn(true);
    $this->repository->shouldReceive('fireSystemEvent')->with('api.repository.afterDelete', [$this->model, true]);

    $result = $this->repository->delete(1);

    expect($result)->toBe($this->model);
});

it('returns null when model not found for deletion', function(): void {
    $this->repository->shouldReceive('find')->with(1)->andReturn(null);

    $result = $this->repository->delete(1);

    expect($result)->toBeNull();
});

it('throws exception when model class is missing', function(): void {
    expect(function(): void {
        $this->repository->getModelClass();
    })->toThrow(SystemException::class, 'Missing model on');
});

it('throws exception when model class does not exist', function(): void {
    $repository = new class extends AbstractRepository
    {
        public ?string $modelClass = 'NonExistentModel';
    };

    expect(function() use ($repository): void {
        $repository->createModel();
    })->toThrow(SystemException::class, 'Class NonExistentModel does NOT exist!');
});

it('creates model instance when model class exists', function(): void {
    $repository = new class extends AbstractRepository
    {
        public ?string $modelClass = TestModel::class;

        protected $fillable = ['id', 'name'];

        protected $guarded = ['guarded'];

        protected $hidden = ['hidden'];

        protected $visible = ['visible'];

        protected function afterCreate(): void {}
    };

    $result = $repository->createModel();

    expect($result)->toBeInstanceOf(Model::class)
        ->and($result->getFillable())->toBe(['id', 'name'])
        ->and($result->getGuarded())->toBe(['guarded'])
        ->and($result->getHidden())->toBe(['hidden'])
        ->and($result->getVisible())->toBe(['visible']);

    $result->fireEvent('model.afterCreate');
});

it('sets nested model attributes when attribute is nested', function(): void {
    $nestedModel = Mockery::mock(Model::class)->makePartial();
    $nestedModel->shouldReceive('isFillable')->andReturn(true);
    $nestedModel->shouldReceive('hasRelation')->andReturn(false);
    $nestedModel->shouldReceive('getKeyName')->andReturn('id');
    $nestedModel->shouldReceive('getRelationType')->andReturn('belongsTo');
    $nestedModel->shouldReceive('extendableGet')->andReturn(null);
    $nestedModel->shouldReceive('extendableSet')->with('name', 'Nested Name')->once();

    $this->model->shouldReceive('isFillable')->andReturn(true);
    $this->model->shouldReceive('hasRelation')->andReturn(true);
    $this->model->shouldReceive('getRelationType')->andReturn('hasOne');
    $this->model->shouldReceive('extendableGet')->andReturn($nestedModel);
    $this->model->shouldReceive('getKeyName')->andReturn('id');

    request()->setUserResolver(fn() => Mockery::mock(Customer::class));
    $this->repository->shouldReceive('getCustomerAwareColumn')->andReturn('customer_id');
    $this->repository->shouldReceive('setModelAttributes')->passthru();

    $saveData = [
        'customer_id' => 1,
        'nested' => ['name' => 'Nested Name'],
    ];
    callProtectedMethod($this->repository, 'setModelAttributes', [$this->model, $saveData]);
});

it('applies location aware scope with absense constraint', function(): void {
    $repository = new class extends AbstractRepository
    {
        protected ?string $modelClass = Order::class;

        protected static $locationAwareConfig = ['addAbsenceConstraint' => true];
    };
    $query = Mockery::mock(Builder::class);
    $user = Mockery::mock(Customer::class)->makePartial();
    $locations = collect([
        ['location_id' => 1, 'location_status' => true],
        ['location_id' => 2, 'location_status' => true],
    ]);
    $query->shouldReceive('getModel')->andReturn(new Order);
    $user->shouldReceive('extendableGet')->with('locations')->andReturn($locations);
    $query->shouldReceive('whereHasOrDoesntHaveLocation')->with([1, 2])->once();
    request()->setUserResolver(fn() => $user);

    callProtectedMethod($repository, 'applyLocationAwareScope', [$query]);
});

it('applies location aware scope without absense constraint', function(): void {
    $repository = new class extends AbstractRepository
    {
        protected ?string $modelClass = Order::class;

        protected static $locationAwareConfig = ['addAbsenceConstraint' => false];
    };
    $query = Mockery::mock(Builder::class);
    $user = Mockery::mock(Customer::class)->makePartial();
    $locations = collect([
        ['location_id' => 1, 'location_status' => true],
        ['location_id' => 2, 'location_status' => true],
    ]);
    $query->shouldReceive('getModel')->andReturn(new Order);
    $user->shouldReceive('extendableGet')->with('locations')->andReturn($locations);
    $query->shouldReceive('whereHasOrDoesntHaveLocation')->never();
    $query->shouldReceive('whereHasLocation')->with([1, 2])->once();
    request()->setUserResolver(fn() => $user);

    callProtectedMethod($repository, 'applyLocationAwareScope', [$query]);
});

it('does not apply location aware scope if config is not an array', function(): void {
    $repository = new class extends AbstractRepository
    {
        protected ?string $modelClass = Order::class;

        protected static $locationAwareConfig;
    };
    $query = Mockery::mock(Builder::class);
    $query->shouldReceive('whereHasOrDoesntHaveLocation')->never();
    $query->shouldReceive('whereHasLocation')->never();

    callProtectedMethod($repository, 'applyLocationAwareScope', [$query]);
});

it('does not apply location aware scope if model is not locationable', function(): void {
    $repository = new class extends AbstractRepository
    {
        protected ?string $modelClass = Order::class;

        protected static $locationAwareConfig = ['addAbsenceConstraint' => true];
    };
    $query = Mockery::mock(Builder::class);
    $model = Mockery::mock(\Illuminate\Database\Eloquent\Model::class);
    $query->shouldReceive('getModel')->andReturn($model);
    $query->shouldReceive('whereHasOrDoesntHaveLocation')->never();
    $query->shouldReceive('whereHasLocation')->never();

    callProtectedMethod($repository, 'applyLocationAwareScope', [$query]);
});

it('does not apply location aware scope if user has no active locations', function(): void {
    $repository = new class extends AbstractRepository
    {
        protected ?string $modelClass = Order::class;

        protected static $locationAwareConfig = ['addAbsenceConstraint' => true];
    };
    $query = Mockery::mock(Builder::class);
    $user = Mockery::mock(Customer::class);
    $locations = collect([
        ['location_id' => 1, 'location_status' => false],
        ['location_id' => 2, 'location_status' => false],
    ]);
    $query->shouldReceive('getModel')->andReturn(new Order);
    $user->shouldReceive('extendableGet')->with('locations')->andReturn($locations);
    $query->shouldReceive('whereHasOrDoesntHaveLocation')->never();
    $query->shouldReceive('whereHasLocation')->never();
    request()->setUserResolver(fn() => $user);

    callProtectedMethod($repository, 'applyLocationAwareScope', [$query]);
});

it('does not apply location aware scope if user has no locations', function(): void {
    $repository = new class extends AbstractRepository
    {
        protected ?string $modelClass = Order::class;

        protected static $locationAwareConfig = ['addAbsenceConstraint' => true];
    };
    $query = Mockery::mock(Builder::class);
    $user = Mockery::mock(Customer::class);
    $query->shouldReceive('getModel')->andReturn(new Order);
    $user->shouldReceive('extendableGet')->with('locations')->andReturnNull();
    $query->shouldReceive('whereHasOrDoesntHaveLocation')->never();
    $query->shouldReceive('whereHasLocation')->never();
    request()->setUserResolver(fn() => $user);

    callProtectedMethod($repository, 'applyLocationAwareScope', [$query]);
});

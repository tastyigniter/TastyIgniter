<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Traits;

use Igniter\Api\Traits\RestExtendable;
use Igniter\Flame\Database\Model;
use Igniter\Tests\Fixtures\Models\TestModel;
use Mockery;

it('returns the rest model instance', function(): void {
    $traitObject = new class
    {
        use RestExtendable;

        public $model = TestModel::class;
    };

    $result = $traitObject->getRestModel();

    expect($result)->toBe(TestModel::class);
});

it('executes restBeforeUpdate without errors', function(): void {
    $traitObject = new class
    {
        use RestExtendable;
    };
    $model = Mockery::mock(Model::class);

    $result = $traitObject->restBeforeUpdate($model);

    expect($result)->toBeNull();
});

it('executes restValidate without errors', function(): void {
    $traitObject = new class
    {
        use RestExtendable;
    };
    $postData = ['name' => 'John Doe'];

    $result = $traitObject->restValidate($postData);

    expect($result)->toBe($postData);
});

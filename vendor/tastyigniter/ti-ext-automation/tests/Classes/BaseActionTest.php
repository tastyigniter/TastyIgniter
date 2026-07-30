<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\Classes;

use Igniter\Automation\Classes\BaseAction;
use Igniter\System\Classes\ExtensionManager;
use Mockery;

it('defines a name and description', function(): void {
    $action = new class extends BaseAction {};

    expect($action->actionDetails())->toHaveKeys(['name', 'description']);
});

it('defines form fields', function(): void {
    $action = new class extends BaseAction {};

    expect($action->defineFormFields())->toBeArray();
});

it('defines validation rules', function(): void {
    $action = new class extends BaseAction {};

    expect($action->defineValidationRules())->toBeArray();
});

it('returns true when fieldConfig is not empty', function(): void {
    $action = new class extends BaseAction
    {
        public function defineFormFields(): array
        {
            return [
                'fields' => [
                    'field1' => [
                        'label' => 'Field 1',
                        'type' => 'text',
                    ],
                ],
            ];
        }
    };

    $result = $action->hasFieldConfig();

    expect($result)->toBeTrue();
});

it('returns fieldConfig when it is set', function(): void {
    $action = new class extends BaseAction
    {
        public function defineFormFields(): array
        {
            return [
                'fields' => [
                    'field1' => [
                        'label' => 'Field 1',
                        'type' => 'text',
                    ],
                ],
            ];
        }
    };

    $result = $action->getFieldConfig();

    expect($result['fields'])->toHaveKey('field1');
});

it('throws an exception if triggerAction method is not implemented', function(): void {
    $action = new BaseAction;

    $action->triggerAction([]);
})->throws('Method '.BaseAction::class.'::triggerAction() is not implemented.');

it('triggers an action', function(): void {
    $action = new class extends BaseAction
    {
        public $actionRan = false;

        public function triggerAction($params): void
        {
            $this->actionRan = true;
        }
    };

    $action->triggerAction([]);

    expect($action->actionRan)->toBeTrue();
});

it('skips invalid action classes and continues processing', function(): void {
    $extensionManager = Mockery::mock(ExtensionManager::class);
    $extensionManager->shouldReceive('getRegistrationMethodValues')->with('registerAutomationRules')->andReturn([
        [
            'actions' => [
                'NonExistent\Class\Name',
            ],
        ],
    ])->once();
    app()->instance(ExtensionManager::class, $extensionManager);

    BaseAction::findActions();
});

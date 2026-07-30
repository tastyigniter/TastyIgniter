<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Http\Actions;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Cart\Models\Menu;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\Http\Actions\LocationAwareController;
use Igniter\Local\Models\Location;
use Igniter\Local\Models\Review;
use Igniter\Local\Models\WorkingHour;
use Illuminate\Support\Facades\Event;

beforeEach(function(): void {
    Event::fakeExcept([
        'admin.list.extendQuery',
        'admin.filter.extendQuery',
    ]);

    $this->controller = new class extends AdminController
    {
        public array $implement = [
            ListController::class,
            FormController::class,
            LocationAwareController::class,
        ];

        public $locationConfig = [
            'applyScopeOnListQuery' => true,
            'applyScopeOnFormQuery' => true,
            'addAbsenceConstraint' => false,
        ];

        public $listConfig = [
            'list' => [
                'model' => Location::class,
                'configFile' => [
                    'list' => [
                        'filter' => [
                            'scopes' => [
                                'status' => [
                                    'label' => 'lang:admin::lang.list.filter_recent',
                                    'conditions' => 'created_at >= :recent',
                                    'modelClass' => Location::class,
                                    'value' => '-30 days',
                                    'locationAware' => true,
                                ],
                            ],
                        ],
                        'columns' => [
                            'location_id' => [
                                'label' => 'lang:admin::lang.locations.column_id',
                                'type' => 'number',
                                'searchable' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        public $formConfig = [
            'name' => 'lang:admin::lang.locations.text_form_name',
            'model' => Location::class,
            'configFile' => [
                'form' => [
                    'tabs' => [
                        'fields' => [
                            'location_id' => [
                                'label' => 'lang:admin::lang.locations.label_id',
                                'type' => 'text',
                                'span' => 'left',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    };

    $this->locationAwareController = $this->controller->asExtension(LocationAwareController::class);
});

it('initializes correctly', function(): void {
    expect($this->locationAwareController->locationConfig)->toBe($this->controller->locationConfig)
        ->and($this->controller->hiddenActions)->toContain('locationApplyScope');
});

it('binds location events', function(): void {
    $locationAwareControllerMock = $this->getMockBuilder(LocationAwareController::class)
        ->setConstructorArgs([$this->controller])
        ->onlyMethods(['locationBindEvents'])
        ->getMock();

    $locationAwareControllerMock->expects($this->once())->method('locationBindEvents');

    $this->controller->fireEvent('controller.beforeRemap');
});

it('applies location scope on events', function(): void {
    $this->controller->fireEvent('controller.beforeRemap');

    $listWidgets = $this->controller->asExtension(ListController::class)->makeLists();
    $listWidget = $listWidgets['list'];

    expect($listWidget->render())->toBeString();

    $filterWidget = $this->controller->widgets['list_filter'];
    expect($filterWidget->render())->toBeString();

    LocationFacade::shouldReceive('currentOrAssigned')->andReturn([1, 2]);
    $query = Menu::query();
    $this->controller->fireEvent('admin.controller.extendFormQuery', [$query]);
    expect($query->toSql())->toContain('`location_id` in (?, ?)');
});

it('applies location scope correctly', function($query, $expectedSql): void {
    LocationFacade::shouldReceive('currentOrAssigned')->andReturn([1, 2]);
    $this->locationAwareController->locationApplyScope($query);

    expect($query->toSql())->toContain($expectedSql);
})->with([
    fn(): array => [Review::query(), '`location_id` in (?, ?)'],
    fn(): array => [Menu::query(), 'and `locationables`.`location_id` in (?, ?)'],
]);

it('does not applies location scope when model does not use Locationable trait', function(): void {
    $query = WorkingHour::query();
    $this->locationAwareController->locationApplyScope($query);

    expect($query->toSql())->not->toContain('`location_id`');
});

it('does not applies location scope when user current or assigned location is missing', function(): void {
    $query = Review::query();

    LocationFacade::shouldReceive('currentOrAssigned')->andReturn([]);
    $this->locationAwareController->locationApplyScope($query);

    expect($query->toSql())->not->toContain('`location_id`');
});

it('applies absence location scope correctly', function($query, $expectedSql): void {
    $this->locationAwareController->setConfig([
        'addAbsenceConstraint' => true,
    ]);
    LocationFacade::shouldReceive('currentOrAssigned')->andReturn([1, 2]);

    $this->locationAwareController->locationApplyScope($query);

    expect($query->toSql())->toContain($expectedSql);
})->with([
    fn(): array => [Review::query(), 'or `location_id` is null'],
    fn(): array => [Menu::query(), ' or not exists (select * from `locations`'],
]);

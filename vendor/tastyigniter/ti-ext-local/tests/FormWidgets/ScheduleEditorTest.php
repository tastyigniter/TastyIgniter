<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\FormWidgets;

use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Local\FormWidgets\ScheduleEditor;
use Igniter\Local\Http\Controllers\Locations;
use Igniter\Local\Models\Location;
use Igniter\System\Facades\Assets;

beforeEach(function(): void {
    $this->location = Location::factory()->create();

    $this->controller = resolve(Locations::class);
    $this->controller->asExtension(FormController::class)->initForm($this->location);

    $formField = (new FormField('test_field', 'Schedule editor'))->displayAs('scheduleeditor');
    $this->scheduleEditorWidget = new ScheduleEditor($this->controller, $formField, [
        'model' => $this->location,
    ]);
});

it('initializes correctly', function(): void {
    $this->scheduleEditorWidget->initialize();

    expect($this->scheduleEditorWidget->popupSize)->toBe('modal-lg')
        ->and($this->scheduleEditorWidget->formTitle)->toBe('igniter.local::default.text_title_schedule');
});

it('prepares variables correctly', function(): void {
    $this->scheduleEditorWidget->prepareVars();

    expect($this->scheduleEditorWidget->vars['field'])->toBeInstanceOf(FormField::class)
        ->and($this->scheduleEditorWidget->vars['schedules'])->toBeArray();

    // test coverage for cached schedules

    $this->scheduleEditorWidget->prepareVars();
});

it('loads assets correctly', function(): void {
    Assets::shouldReceive('addJs')->once()->with('vendor/timesheet/timesheet.js', 'timesheet-js');
    Assets::shouldReceive('addJs')->once()->with('formwidgets/recordeditor.modal.js', 'recordeditor-modal-js');
    Assets::shouldReceive('addJs')->once()->with('scheduleeditor.js', 'scheduleeditor-js');

    Assets::shouldReceive('addCss')->once()->with('vendor/timesheet/timesheet.css', 'timesheet-css');
    Assets::shouldReceive('addCss')->once()->with('scheduleeditor.css', 'scheduleeditor-css');

    $this->scheduleEditorWidget->assetPath = [];

    $this->scheduleEditorWidget->loadAssets();
});

it('loads record correctly', function(): void {
    request()->merge(['recordId' => Location::OPENING]);
    expect($this->scheduleEditorWidget->onLoadRecord())->toBeString();
});

it('saves record correctly', function(): void {
    request()->merge(['recordId' => Location::OPENING]);
    expect($this->scheduleEditorWidget->onSaveRecord())->toBeArray();
});

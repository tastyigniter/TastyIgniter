<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\MainMenuWidgets;

use Igniter\Admin\Classes\MainMenuItem;
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\Http\Controllers\Locations;
use Igniter\Local\MainMenuWidgets\LocationPicker;
use Igniter\Local\Models\Location;
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Models\User;
use Illuminate\Http\RedirectResponse;

beforeEach(function(): void {
    $this->location = Location::factory()->create();
    $menuItem = (new MainMenuItem('test_field', 'Location picker'))->displayAs('locationpicker');
    $this->controller = resolve(Locations::class);
    $this->locationPickerWidget = new LocationPicker($this->controller, $menuItem);
});

it('initializes correctly', function(): void {
    $this->locationPickerWidget->initialize();

    expect($this->locationPickerWidget->popupSize)->toBe('modal-lg')
        ->and($this->locationPickerWidget->modelClass)->toBe(Location::class);
});

it('prepares variables correctly', function(): void {
    $user = User::factory()->create();
    $this->controller->setUser($user);
    $this->actingAs($user, 'igniter-admin');

    $this->locationPickerWidget->prepareVars();

    expect($this->locationPickerWidget->vars)->toBeArray()
        ->toHaveKey('locations')
        ->toHaveKey('activeLocation')
        ->toHaveKey('canCreateLocation')
        ->toHaveKey('isSingleMode');
});

it('loads form with new record correctly', function(): void {
    $user = User::factory()->create();
    AdminAuth::shouldReceive('user')->andReturn($user);

    expect($this->locationPickerWidget->onLoadForm())->toBeString();
});

it('loads form with existing correctly', function(): void {
    $this->actingAs(User::factory()->superUser()->create(), 'igniter-admin');
    $location = Location::factory()->create();
    request()->request->set('location', $location->getKey());

    expect($this->locationPickerWidget->onLoadForm())->toBeString();
});

it('chooses location correctly', function(): void {
    $user = User::factory()->superUser()->create();
    $this->controller->setUser($user);
    $this->actingAs($user, 'igniter-admin');
    request()->merge(['location' => $this->location->getKey()]);

    expect($this->locationPickerWidget->onChoose())->toBeInstanceOf(RedirectResponse::class);
});

it('chooses location and resets session', function(): void {
    $user = User::factory()->superUser()->create();
    $this->controller->setUser($user);
    $this->actingAs($user, 'igniter-admin');
    request()->merge(['location' => $this->location->getKey()]);
    LocationFacade::shouldReceive('current')->andReturn($this->location);
    LocationFacade::shouldReceive('resetSession')->once();

    expect($this->locationPickerWidget->onChoose())->toBeInstanceOf(RedirectResponse::class);
});

it('saves new record correctly', function(): void {
    $user = User::factory()->superUser()->create();
    $this->controller->setUser($user);
    $this->actingAs($user, 'igniter-admin');

    expect($this->locationPickerWidget->onSaveRecord())->toBeArray();
});

it('saves existing record correctly', function(): void {
    $user = User::factory()->superUser()->create();
    $this->controller->setUser($user);
    $this->actingAs($user, 'igniter-admin');
    $location = Location::factory()->create();
    request()->request->set('recordId', $location->getKey());

    expect($this->locationPickerWidget->onSaveRecord())->toBeArray();
});

it('flashes error when geocoder fails', function(): void {
    $user = User::factory()->superUser()->create();
    $this->controller->setUser($user);
    $this->actingAs($user, 'igniter-admin');
    $location = Location::factory()->create();
    request()->request->set('recordId', $location->getKey());
    Geocoder::shouldReceive('getLogs')->andReturn(['Failed to geocode']);

    $result = $this->locationPickerWidget->onSaveRecord();

    expect($result['#notification'])->toContain('Failed to geocode');
});

it('deletes record correctly', function(): void {
    $user = User::factory()->superUser()->create();
    $this->controller->setUser($user);
    $this->actingAs($user, 'igniter-admin');
    request()->merge(['recordId' => $this->location->getKey()]);

    expect($this->locationPickerWidget->onDeleteRecord())->toBeArray();
});

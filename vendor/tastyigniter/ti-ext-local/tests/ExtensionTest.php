<?php

declare(strict_types=1);

namespace Igniter\Local\Tests;

use Igniter\Admin\DashboardWidgets\Charts;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Cart\Http\Controllers\Menus;
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Model\Location as UserPosition;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Local\CartConditions\Delivery;
use Igniter\Local\Extension;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\Http\Middleware\CheckLocation;
use Igniter\Local\Models\Location;
use Igniter\Local\Models\LocationArea;
use Igniter\Local\Models\Review;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Reservation\Models\Reservation;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Customer;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Mockery;

beforeEach(function(): void {
    $this->extension = new Extension(app());
});

it('registers location middleware', function(): void {
    Route::shouldReceive('pushMiddlewareToGroup')
        ->with('igniter', CheckLocation::class)
        ->once();

    $this->extension->register();
});

it('binds remember location area events', function(): void {
    Event::shouldReceive('listen')
        ->with('location.position.updated', Mockery::type('callable'))
        ->once();

    Event::shouldReceive('listen')
        ->with('location.area.updated', Mockery::type('callable'))
        ->once();

    Event::shouldReceive('listen')
        ->with(['igniter.user.login', 'igniter.socialite.login'], Mockery::type('callable'))
        ->once();

    Event::shouldReceive('listen')
        ->with('admin.form.extendFieldsBefore', Mockery::type('callable'))
        ->once();

    $this->extension->boot();
});

it('adds reviews relationship to reservation', function(): void {
    $this->extension->boot();

    $model = new Reservation;
    $review = new Review;

    expect($model->relation['morphMany']['review'])->not->toBeNull()
        ->toBe([Review::class, 'name' => 'reviewable'])
        ->and($review->getMorphClass())->toBe('reviews');
});

it('updates customer last area on location position updated', function(): void {
    $customer = Customer::factory()->create();
    $location = Mockery::mock(Location::class);
    $position = Mockery::mock(UserPosition::class);
    $oldPosition = Mockery::mock(UserPosition::class);
    $position->shouldReceive('format')->andReturn('new-position');
    $oldPosition->shouldReceive('format')->andReturn('old-position');
    Auth::shouldReceive('customer')->andReturn($customer);

    $this->extension->boot();

    Event::dispatch('location.position.updated', [$location, $position, $oldPosition]);

    expect($customer->last_location_area)->toContain('new-position');
});

it('updates customer last area on location area updated', function(): void {
    $customer = Customer::factory()->create();
    $location = Mockery::mock(Location::class);
    $coveredArea = Mockery::mock(LocationArea::class);
    $coveredArea->shouldReceive('getKey')->andReturn(1);
    Auth::shouldReceive('customer')->andReturn($customer);

    $this->extension->boot();

    Event::dispatch('location.area.updated', [$location, $coveredArea]);

    expect($customer->last_location_area)->toContain(1);
});

it('updates user position and nearby area on user login', function(): void {
    $locationArea = LocationArea::factory()->create([
        'location_id' => 1,
    ]);
    $customer = Customer::factory()->create([
        'customer_id' => 1,
        'last_location_area' => json_encode(['query' => 'test-query', 'areaId' => $locationArea->getKey()]),
    ]);
    Auth::shouldReceive('customer')->andReturn($customer);
    $userLocation = Mockery::mock(UserPosition::class)->makePartial();
    Geocoder::shouldReceive('geocode')->with('test-query')->andReturn(collect([$userLocation]));

    LocationFacade::shouldReceive('updateUserPosition')->with($userLocation)->twice();
    LocationFacade::shouldReceive('updateNearbyArea')->twice();

    $this->extension->boot();

    Event::dispatch('igniter.user.login');
});

it('does not updates user position on user login when last_location_area is empty', function(): void {
    $customer = Customer::factory()->create([
        'customer_id' => 1,
        'last_location_area' => '',
    ]);
    Auth::shouldReceive('customer')->andReturn($customer);

    LocationFacade::shouldReceive('updateUserPosition')->never();
    LocationFacade::shouldReceive('updateNearbyArea')->never();

    $this->extension->boot();

    Event::dispatch('igniter.user.login');
});

it('returns delivery condition with correct attributes', function(): void {
    $extension = new Extension(app());

    $result = $extension->registerCartConditions();

    expect($result)->toEqual([
        Delivery::class => [
            'name' => 'delivery',
            'label' => 'lang:igniter.local::default.text_delivery',
            'description' => 'lang:igniter.local::default.help_delivery_condition',
        ],
    ]);
});

it('returns registered mail templates array', function(): void {
    $extension = new Extension(app());

    $result = $extension->registerMailTemplates();

    expect($result)->toEqual([
        'igniter.local::mail.review_chase' => 'lang:igniter.local::default.reviews.text_chase_email',
    ]);
});

it('returns registered permissions array', function(): void {
    $extension = new Extension(app());

    $result = $extension->registerPermissions();

    expect($result)->toEqual([
        'Admin.Locations' => [
            'label' => 'lang:igniter.local::default.locations_permissions',
            'group' => 'igniter::admin.permissions.name',
        ],
        'Admin.Reviews' => [
            'description' => 'lang:igniter.local::default.reviews.permissions',
            'group' => 'igniter.cart::default.text_permission_order_group',
        ],
    ]);
});

it('returns registered settings array', function(): void {
    $extension = new Extension(app());

    $settings = $extension->registerSettings();

    expect($settings)->toHaveKey('reviewsettings')
        ->and($settings['reviewsettings']['label'])->toBe('lang:igniter.local::default.reviews.text_settings')
        ->and($settings['reviewsettings']['model'])->toBe(ReviewSettings::class)
        ->and($settings['reviewsettings']['permissions'])->toBe(['Admin.Reviews']);
});

it('returns registered onboarding steps array', function(): void {
    $extension = new Extension(app());

    $result = $extension->registerOnboardingSteps();

    expect($result)->toEqual([
        'igniter.local::locations' => [
            'label' => 'igniter.local::default.onboarding_locations',
            'description' => 'igniter.local::default.help_onboarding_locations',
            'icon' => 'fa-store',
            'url' => admin_url('locations/settings/'.Location::getDefaultKey()),
            'priority' => 15,
            'complete' => Location::onboardingIsComplete(...),
        ],
    ]);
});

it('returns registered dashboard charts', function(): void {
    ReviewSettings::set('allow_reviews', true);
    $charts = new class(resolve(Menus::class)) extends Charts
    {
        public function testDatasets()
        {
            return $this->listSets();
        }
    };
    $datasets = $charts->testDatasets();

    expect($datasets['reports']['sets']['reviews']['model'])->toBe(Review::class);
});

it('registers locations picker admin menus when running in admin', function(): void {
    Igniter::partialMock()->shouldReceive('runningInAdmin')->andReturnTrue();
    $this->extension->boot();
    $menuItems = AdminMenu::getMainItems();

    expect($menuItems['locations'])->not->toBeNull();
});

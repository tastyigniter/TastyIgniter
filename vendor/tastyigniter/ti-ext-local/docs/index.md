---
title: "Local"
section: "extensions"
sortOrder: 60
---

## Installation

You can install the extension via composer using the following command:

```bash
composer require tastyigniter/ti-ext-local -W
```

Run the database migrations to create the required tables:
  
```bash
php artisan igniter:up
```

## Getting started

If you only have one restaurant location, you can switch to single location mode by setting the `IGNITER_LOCATION_MODE` environment variable to `single` in your `.env` file.

```bash
IGNITER_LOCATION_MODE=single
```

By default, the location mode is set to `multiple` which allows you to manage multiple locations.

### Managing locations

From your TastyIgniter Admin, navigate to _Manage > Settings > Locations_ to create, edit or delete locations. You can also set the default location by clicking on the **Set as Default** button next to the location.

### Geocoder

From your TastyIgniter Admin, you can configure the geocoder provider by setting the **Default Geocoder** field to the desired provider in the _Manage > Settings > General_ admin settings page.

#### Google Maps API Key

To use the Google Maps geocoder provider, you need to set the Google Maps API key in the _Manage > Settings > General_ admin settings page. Follow the instructions on the page to get your API key.

### Review Settings

You can enable or disable order and reservation reviews by navigating to the _Manage > Settings > Review settings_ admin settings page.

## Usage

This section covers how to integrate the Local extension API into your own extension if you need to manage locations, delivery areas, working hours, and reviews. The Local extension provides a simple API for managing locations, delivery areas, working hours, and reviews.

### Locations

#### Setting current location

To set the current location, use the `Location` facade's `setCurrent` method. Pass the location model instance as the argument. This will store the location in session and make it the current location for the user.

```php
use Igniter\Local\Facades\Location;

Location::setCurrent($location);

// Then check if the location is open
if (Location::isOpened()) {
    // Do something...
}
```

After setting the current location, you can retrieve the current location later using the `Location` facade's `current` method.

```php
$location = Location::current();
```

#### Setting user coordinates

To set the user's coordinates, use the `Location` facade's `updateUserPosition` method. Pass the `Igniter\Flame\Geolite\Model\Location` instance as the argument. This will store the user's coordinates in session.

```php
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Local\Facades\Location;

$userLocation = Geocoder::geocode($userAddress)->first();

Location::updateUserPosition($userLocation);
```

#### Searching nearby locations

To search for nearby locations, use the `Location` facade's `searchByCoordinates` method. Pass the `Igniter\Flame\Geolite\Model\Coordinates` object as the argument.

```php
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Local\Facades\Location;

$userLocation = Geocoder::geocode($userAddress)->first();

$locations = Location::searchByCoordinates($userLocation->getCoordinates());
```

#### Retrieving minimum order total

To retrieve the minimum order total for a location, use the `minimumOrderTotal` method on the `Location` facade. The method accepts the order type as an argument and returns the minimum order total for the current location.

```php
$minimumOrderTotal = Location::minimumOrderTotal($orderType);
```

#### Checking minimum order total

After retrieving the minimum order total of the current location, you can check if the order total meets the minimum order total using the `checkMinimumOrderTotal` method on the `Location` facade.

```php
if (Location::checkMinimumOrderTotal($orderTotal)) {
    // Do something...
}
```

#### Location-aware controller action

To make the admin [controller list and form action classes](https://tastyigniter.com/docs/extend/controllers#controller-action-classes) aware of the current location, use the `Igniter\Local\Http\Actions\LocationAwareController` action class in your controller.

```php
class MyController extends \Admin\Classes\AdminController
{
    public array $implement = ['Igniter\Local\Http\Actions\LocationAwareController'];

    public array $locationConfig = [
        'applyScopeOnListQuery' => true,
        'applyScopeOnFormQuery' => true,
        'addAbsenceConstraint' => true,
    ]
}
```

In the example above, the `applyScopeOnListQuery` and `applyScopeOnFormQuery` options will apply the location scope to the list and form queries respectively. This way you can filter records based on the current admin user's location. The `addAbsenceConstraint` option when set to `true` will add a constraint to the query to include records that are not associated with any location and when set to `false` will exclude records that are not associated with any location.

#### Location settings

To add custom fields to the location settings form, you must define a `registerLocationSettings` method on your extension class. This method should return an array of settings definition to be added to the location settings form.

```php
public function registerLocationSettings()
{
    return [
        'custom' => [
            'label' => 'Custom settings',
            'description' => 'Custom settings description',
            'icon' => 'fa fa-sliders',
            'priority' => 0,
            'form' => 'author.extension::/models/customsettings',
            'request' => \Author\Extension\Http\Requests\CustomRequest::class,
        ],
    ];
}
```

The settings definition array should contain the following keys:

- `label`: The label of the settings section.
- `description`: The description of the settings section.
- `icon`: The icon class of the settings section.
- `url`: The URL used to link to the settings section. Optional.
- `priority`: The priority of the settings section.
- `permissions`: The permissions required to access the settings section.
- `form`: An array of form fields or path to the form definition file to be used for the settings section.
- `request`: The form request class to be used for the settings section.

### Delivery areas

#### Adding delivery areas

To add a delivery area, navigate to _Restaurant > Settings > Delivery Areas_ in the admin area. Click on the **Add** button, fill in the required details such as name, boundary, and charges, and save your changes.

#### Defining delivery area boundary

To define a delivery area boundary, use the MapView form widget in your delivery area form. This widget allows you to draw the boundary on a map. You can also define area boundary using address components such as country, state, city, and postal code.

You can programmatically set the boundary using the `boundaries` attribute on the `Igniter\Local\Models\LocationArea` model instance.

```php
$locationArea->type = 'address'; // or 'circle' or 'polygon'

$locationArea->boundaries = [
    'polygon' => [
        [
            [0.0, 0.0],
            [0.0, 1.0],
            [1.0, 1.0],
            [1.0, 0.0],
            [0.0, 0.0],
        ],
    ],
    'circle' => [
        'center' => [0.0, 0.0],
        'radius' => 1000,
    ],
    'vertices' => [
        [0.0, 0.0],
        [0.0, 1.0],
        [1.0, 1.0],
        [1.0, 0.0],
    ],
    'components' => [
        ['type' => 'locality', 'value' => 'London', 'priority' => 0],
    ],
];

$locationArea->save();
```

#### Checking a point in boundary

After defining the boundary, you can check if a point is within the boundary using the `checkBoundary` method on the `Igniter\Local\Models\LocationArea` model instance.

```php
$userLocation = Geocoder::geocode($userAddress)->first();

$locationArea->checkBoundary($userLocation->getCoordinates());
```

You can search all delivery areas using the `searchDeliveryArea` method on the `Igniter\Local\Models\Location` model instance.

```php
use Igniter\Local\Models\Location;

$location = Location::find(1);

$locationArea = $location->searchDeliveryArea($userLocation->getCoordinates());
```

Using the `Location` facade's `checkDeliveryCoverage` method, you can check if a point is within the boundaries of the current location. The `$userLocation` argument can be an instance of `Igniter\Flame\Geolite\Model\Location` or null to use the user's coordinates stored in session.

```php
$locationArea = Location::checkDeliveryCoverage($userLocation);
```

#### Defining delivery area charges

To set delivery charges for a delivery area, use the delivery area form. You can set a fixed charge or a charge based on the order total.

You can programmatically set the delivery charges using the `conditions` attribute on the `Igniter\Local\Models\LocationArea` model instance.

```php
$locationArea->conditions = [
    [
        'priority' => 1,
        'amount' => 5.0,
        'type' => 'all', // or 'above' or 'below'
        'total' => 0,
    ],
    [
        'priority' => 2,
        'amount' => 5.0,
        'type' => 'below',
        'total' => 50.0,
    ],
];

$locationArea->save();
```

#### Retrieving delivery area charge

After setting the delivery charges, you can retrieve the matching delivery charge for an order based on the order total using the `deliveryAmount` method on the `Igniter\Local\Classes\CoveredArea` class.

```php
use Igniter\Local\Classes\CoveredArea;

$coveredArea = new CoveredArea($locationArea);

$deliveryAmount = $coveredArea->deliveryAmount($orderTotal);
```

Using the `Location` facade's `deliveryAmount` method, you can retrieve the matching delivery charge for the current location based on the order total.

```php
$deliveryAmount = Location::deliveryAmount($orderTotal);
```

#### Setting user delivery area

To set the user's delivery area, use the `Location` facade's `updateNearbyArea` method. Pass the `Igniter\Local\Models\LocationArea` instance as the argument. This will store the user's delivery area in session.

```php
use Igniter\Local\Facades\Location;

Location::updateNearbyArea($locationArea);
```

### Delivery cart condition

A delivery cart condition class that allows you to apply delivery charges to the cart based on the delivery area and order total. This condition is added to your cart automatically when the delivery order type is selected.

You can retrieve the delivery fee applied to the cart using the `getCondition` method on the `Cart` facade.

```php
use Igniter\Cart\Facades\Cart;

$deliveryCondition = Cart::getCondition('delivery');

$deliveryFee = $deliveryCondition->getValue();
```

### Working hours

#### Creating working hours

To create working hours, navigate to _Restaurant > Settings > Schedules_ in the admin panel. Click on the Add button, fill in the required details such as day, open time, and close time, and save your changes.

You can programmatically set the location's working hours using the `addOpeningHours` method on the `Igniter\Local\Models\Location` model instance. The first argument is an array of working hours where the key is the type of working hours (e.g., opening, delivery, collection) and the value is an array of working hours.

```php
$location->addOpeningHours([
    'opening' => [
        'type' => '24_7', // or 'daily' or 'timesheet' or 'flexible'
        'days' => [],
        'open' => null,
        'close' => null,
        'timesheet' => [],
        'flexible' => [],
    ],
    'delivery' => [
        'type' => 'daily',
        'days' => [0, 1, 2, 3, 4, 5, 6],
        'open' => '00:00',
        'close' => '23:59',
        'timesheet' => [],
        'flexible' => [],
    ],
    'collection' => [
        'type' => 'timesheet',
        'days' => [],
        'open' => null,
        'close' => null,
        'timesheet' => [
            0 => [
                'day' => 0,
                'hours' => [
                    ['open' => '09:00', 'close' => '12:00'],
                    ['open' => '13:00', 'close' => '17:00'],
                ],
                'status' => 1,
            ]
        ],
        'flexible' => [],
    ],
]);
```

#### Generating timeslots

To generate timeslots for a location, use the `Location` facade. This will generate timeslots for the location based on the working hours and location settings. The `getTimeslot` method returns a collection of timeslots where the key is the date string and value is an array of timeslots.

```php
use Igniter\Local\Facades\Location;

$openingTimeslots = Location::openingSchedule()->getTimeslot();

$deliveryTimeslots = Location::deliverySchedule()->getTimeslot();

$collectionTimeslots = Location::collectionSchedule()->getTimeslot();

// For custom types
$customTimeslots = Location::workingSchedule('custom')->getTimeslot();
```

To generate timeslots for a specific day, pass a `DateTime` instance as an argument to the `generateTimeslot` method. This will return a collection of timeslots for the specified day where the key is the timestamp and value is a `DateTime` instance.

```php
use Igniter\Local\Facades\Location;

$openingTimeslots = Location::openingSchedule()->generateTimeslot($dateTime);

$deliveryTimeslots = Location::deliverySchedule()->generateTimeslot($dateTime);

$collectionTimeslots = Location::collectionSchedule()->generateTimeslot($dateTime);

// For custom types
$customTimeslots = Location::workingSchedule('custom')->generateTimeslot($dateTime);
```

#### Checking availability

##### Checking a location is open

To check if the current location is open at the current time, use the `isOpen` method of the WorkingSchedule class. This method returns a boolean value indicating whether the location is open.

```php
if (Location::deliverySchedule()->isOpen()) {
    // Do something...
}
```

##### Checking a location is opening soon

To check if a location is opening soon, use the `isOpening` method of the WorkingSchedule class. This method returns a boolean value indicating whether the location is opening soon.

```php
if (Location::deliverySchedule()->isOpening()) {
    // Do something...
}
```

##### Checking a location is closed

To check if the current location is closed at the current time, use the `isClosed` method of the WorkingSchedule class. This method returns a boolean value indicating whether the location is closed.

```php
if (Location::deliverySchedule()->isClosed()) {
    // Do something...
}
```

##### Checking a location is opening at a specific time

To check if a location is open at a specific time, use the `isOpenAt` method of the WorkingSchedule class. Pass a `DateTime` object as the argument. This method returns a boolean value indicating whether the location is open at the specified time.

```php
if (Location::deliverySchedule()->isOpenAt($dateTime)) {
    // Do something...
}
```

##### Checking when next a location is open

To check when next a location is open, use the `nextOpenAt` method of the WorkingSchedule class. This method accepts a `DateTime` object as argument and returns a `DateTime` object indicating when the location will next open.

```php
$nextOpenAt = Location::deliverySchedule()->nextOpenAt($dateTime);
```

##### Checking a location is closed at a specific time

To check if a location is closed at a specific time, use the `isClosedAt` method of the WorkingSchedule class. Pass a `DateTime` object as the argument. This method returns a boolean value indicating whether the location is closed at the specified time.

```php
if (Location::deliverySchedule()->isClosedAt($dateTime)) {
    // Do something...
}
```

#### Setting exceptions

To set exceptions for the location's working hours, use the `setExceptions` method of the WorkingSchedule class. Pass an array of exceptions as the argument. The array should have the date string as the key and an array of times as the value.

```php
use Igniter\Local\Facades\Location;

Location::deliverySchedule()->setExceptions([
    '2022-01-01' => [
        ['01:00', '04:59'],
        ['18:00', '23:59'],
    ],
    '2022-12-25' => [],
]);
```

#### Setting user order schedule time

To set the user's order fulfilment time, use the `Location` facade's `updateScheduleTimeSlot` method. The first argument is a `DateTime` object, and the second argument is a boolean value indicating whether the user is ordering for ASAP. This will store the user's order time in session.

```php
use Igniter\Local\Facades\Location;

Location::updateScheduleTimeSlot($dateTime, $isAsap);
```

### Reviews

#### Reviewing orders and reservations

To enable users to review orders and reservations, navigate to _Manage > Settings > Review settings_ in the admin area and enable the **Allow Reviews** option.

Programmatically, you can create reviews for an order or reservation using the `Igniter\Local\Models\Review` model instance.

```php
use Igniter\Local\Models\Review;
use Igniter\Cart\Models\Order;
// use Igniter\Reservation\Models\Reservation;

$record = Order::find(1);
// $record = Reservation::find(1);

$review = $record->leaveReview([
    'quality' => 5,
    'delivery' => 5,
    'service' => 5,
    'review_text' => 'Great food and service!',
]);
```

#### Review chase automation rule

This extension provides a review chase automation rule that sends an email to customers to remind them to leave a review after an order. To enable this rule, navigate to _Tools > Automations_ in the admin area and enable the **Send a message to leave a review after 24 hours** rule.

#### Review count automation condition

A review count automation condition class that allows you to trigger automation rules based on the number of reviews an order or reservation has. This condition can be added to your automation rules to trigger actions based on the review count. The following attribute is available:

- `review_count`: The number of reviews an order or reservation has. Usually set to `0` or `1`.

### Form Widgets

#### Star Rating

The `starrating` form widget allows you to display a star rating input in your forms.

Add the following code to your [form definition file](https://tastyigniter.com/docs/extend/forms#form-definition-file):

```php
'my_field' => [
    'label' => 'Star Rating',
    'type' => 'starrating',
],
```

The following options are available for the `starrating` form widget type:

- `hints`: _(array)_ An array of hints to display below the star rating input. Optional.

#### Map Area

The `maparea` form widget allows you to manage your delivery areas.

Add the following code to your [form definition file](https://tastyigniter.com/docs/extend/forms#form-definition-file):

```php
'my_field' => [
    'label' => 'Map Area',
    'type' => 'maparea',
    'form' => 'locationarea',
    'request' => \Igniter\Local\Http\Requests\LocationAreaRequest::class,
 ],
```

The following options are available for the `maparea` form widget type:

- `form`: _(string)_ This is either an array or path to the form definition file to be used for the map area form. **Required.**
- `modelClass`: _(string)_ The model class to be used for the map area form. **Required.**
- `prompt`: _(string)_ The label for the add button. Optional.
- `sortable`: _(bool)_ Whether to enable sorting of the map area items. Optional.
- `formName`: _(string)_ The form name to be used for the map area form. Optional.
- `addLabel`: _(string)_ The prefix for the add map area form title
- `editLabel`: _(string)_ The prefix for the edit map area form title
- `deleteLabel`: _(string)_ The prefix for the delete map area form title

#### Map View

The `mapview` form widget allows you to draw a boundary on a map. You can use it in your delivery area form to define the delivery boundary.

Add the following code to your [form definition file](https://tastyigniter.com/docs/extend/forms#form-definition-file):

```php
'my_field' => [
    'label' => 'Map View',
    'type' => 'mapview',
    'zoom' => 14,
    'height' => 640,
],
```

The following options are available for the `mapview` form widget type:

- `zoom`: _(int)_ The initial zoom level of the map. Optional.
- `height`: _(int)_ The height of the map in pixels. Optional.
- `center`: _(array)_ The initial center of the map. An array of latitude and longitude. `['lat' => 0.0, 'lng' => 0.0]` Optional.

#### Working Schedule Editor

The `scheduleeditor` form widget allows you to manage your location's working hours.

Add the following code to your [form definition file](https://tastyigniter.com/docs/extend/forms#form-definition-file):

```php
'my_field' => [
    'label' => 'Working Schedule',
    'type' => 'scheduleeditor',
    'form' => 'workingschedule',
],
```

The following options are available for the `scheduleeditor` form widget type:

- `form`: _(string)_ This is either an array or path to the form definition file to be used for the working schedule form. **Required.**
- `formTitle`: _(string)_ The title of the schedule editor form. Optional.
- `popupSize`: _(string)_ The size of the modal dialog. Optional. Available options are `modal-sm`, `modal-md`, `modal-lg`, `modal-xl`.
- `request`: _(string)_ The form request class to be used for validating the schedule editor form. Optional.

#### Location Settings Editor

The `settingseditor` form widget allows you to add custom fields to the location settings form.

Add the following code to your [form definition file](https://tastyigniter.com/docs/extend/forms#form-definition-file):

```php
'my_field' => [
    'label' => 'Location Settings',
    'type' => 'settingseditor',
],
```

No options are available for the `settingseditor` form widget type.

### Mail templates

The Local extension registers the following mail templates:

- `igniter.local::mail.review_chase` - Review chase email template to remind customers to leave a review after an order.

You can send the above mail template using the `mailSend` method on the [SendsMailTemplate model trait](https://tastyigniter.com/docs/advanced/mail#the-sendsmailtemplate-model-trait) attached to `Igniter\Cart\Models\Order` model:

```php
use Igniter\Cart\Models\Order;

$order = Order::find(1);

$order->mailSend('igniter.local::mail.review_chase', 'customer');
```

### Permissions

The Local extension registers the following permissions:

- `Admin.Locations`: Control who can manage locations in the admin area.
- `Admin.Reviews`: Control who can manage reviews in the admin area.

For more on restricting access to the admin area, see the [TastyIgniter Permissions](https://tastyigniter.com/docs/customize/permissions) documentation.

### Events

The Local extension provides the following events:

| Event                                   | Description | Parameters |
|-----------------------------------------| ----------- | ---------- |
| `location.current.updated`              |    When the current location is updated.    |  The `Igniter\Local\Models\Location` model instance   |
| `location.position.updated`             |    When the user's coordinates are updated.    |  The `Igniter\Local\Models\Location` class instance, the `UserLocation` user position instance and previous `UserLocation` user position instance  |
| `location.orderType.updated`            |    When the location's order type is updated.    |  The `Igniter\Local\Models\Location` class instance, the order type string and previous order type string   |
| `location.timeslot.updated`             |    When the location's order fulfilment time is updated.    |  The `Igniter\Local\Models\Location` class instance   |
| `location.area.updated`                 |    When the location's delivery area is updated.    |  The `Igniter\Local\Models\Location` class instance and the `CoveredArea` class instance   |
| `igniter.workingSchedule.created`       |   When a working schedule is created.    |  The `Igniter\Local\Models\Location` model instance and the `WorkingSchedule` instance   |
| `igniter.workingSchedule.timeslotValid` |   When a working schedule timeslot is validated.    |  The `Igniter\Local\Classes\WorkingSchedule` instance and the `DateTime` instance  |

Here is an example of hooking an event in the `boot` method of an extension class:

```php
use Illuminate\Support\Facades\Event;

public function boot()
{
    Event::listen('location.current.updated', function ($location) {
        // Do something...
    });
}
```

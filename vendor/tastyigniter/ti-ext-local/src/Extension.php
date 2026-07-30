<?php

declare(strict_types=1);

namespace Igniter\Local;

use Igniter\Admin\Classes\MainMenuItem;
use Igniter\Admin\Classes\Navigation;
use Igniter\Admin\DashboardWidgets\Charts;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Widgets\Form;
use Igniter\Automation\AutomationRules\Actions\SendMailTemplate;
use Igniter\Automation\AutomationRules\Events\OrderSchedule;
use Igniter\Cart\AutomationRules\Conditions\OrderAttribute;
use Igniter\Cart\Classes\OrderTypes;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Local\AutomationRules\Conditions\ReviewCount;
use Igniter\Local\CartConditions\Delivery;
use Igniter\Local\Classes\Location;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\FormWidgets\MapArea;
use Igniter\Local\FormWidgets\MapView;
use Igniter\Local\FormWidgets\ScheduleEditor;
use Igniter\Local\FormWidgets\SettingsEditor;
use Igniter\Local\FormWidgets\StarRating;
use Igniter\Local\Http\Middleware\CheckLocation;
use Igniter\Local\Http\Requests\LocationRequest;
use Igniter\Local\MainMenuWidgets\LocationPicker;
use Igniter\Local\Models\Actions\ReviewAction;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Models\LocationArea;
use Igniter\Local\Models\Observers\LocationAreaObserver;
use Igniter\Local\Models\Review;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Local\Models\Scopes\LocationScope;
use Igniter\Local\Models\WorkingHour;
use Igniter\Reservation\Models\Reservation;
use Igniter\System\Classes\BaseExtension;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Override;

class Extension extends BaseExtension
{
    protected array $scopes = [
        LocationModel::class => LocationScope::class,
    ];

    protected $observers = [
        LocationArea::class => LocationAreaObserver::class,
    ];

    protected array $morphMap = [
        'location_areas' => LocationArea::class,
        'locations' => LocationModel::class,
        'working_hours' => WorkingHour::class,
    ];

    public array $singletons = [
        OrderTypes::class,
        'location' => Location::class,
    ];

    #[Override]
    public function register(): void
    {
        parent::register();

        $this->callAfterResolving('location', function(Location $location): void {
            $location->setSessionKey(Igniter::runningInAdmin() ? 'admin_location' : 'location');
        });

        Route::pushMiddlewareToGroup('igniter', CheckLocation::class);

        AliasLoader::getInstance()->alias('Location', LocationFacade::class);
    }

    #[Override]
    public function boot(): void
    {
        $this->bindRememberLocationAreaEvents();

        $this->addReviewsRelationship();
        $this->addAssetsToReviewsSettingsPage();
        $this->extendDashboardChartsDatasets();

        User::extend(function($model): void {
            $model->addDynamicMethod('getAvailableLocations', function() use ($model) {
                if ($model->isSuperUser()) {
                    return $model->locations()->getModel()->query()->get();
                }

                return $model->locations;
            });

            $model->addDynamicMethod('isAssignedLocation', function($location) use ($model) {
                if ($model->isSuperUser()) {
                    return true;
                }

                return $model->locations?->contains($location);
            });
        });

        Order::implement(ReviewAction::class);
        Reservation::implement(ReviewAction::class);

        $this->registerLocationsMainMenuItems();
    }

    public function registerAutomationRules(): array
    {
        return [
            'events' => [],
            'actions' => [],
            'conditions' => [
                ReviewCount::class,
            ],
            'presets' => [
                'chase_review_after_one_day' => [
                    'name' => 'Send a message to leave a review after 24 hours',
                    'event' => OrderSchedule::class,
                    'actions' => [
                        SendMailTemplate::class => [
                            'template' => 'igniter.local::mail.review_chase',
                            'send_to' => 'customer',
                        ],
                    ],
                    'conditions' => [
                        ReviewCount::class => [
                            [
                                'attribute' => 'review_count',
                                'value' => '0',
                                'operator' => 'is',
                            ],
                        ],
                        OrderAttribute::class => [
                            [
                                'attribute' => 'hours_since',
                                'value' => '24',
                                'operator' => 'is',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function registerCartConditions(): array
    {
        return [
            Delivery::class => [
                'name' => 'delivery',
                'label' => 'lang:igniter.local::default.text_delivery',
                'description' => 'lang:igniter.local::default.help_delivery_condition',
            ],
        ];
    }

    #[Override]
    public function registerMailTemplates(): array
    {
        return [
            'igniter.local::mail.review_chase' => 'lang:igniter.local::default.reviews.text_chase_email',
        ];
    }

    #[Override]
    public function registerNavigation(): array
    {
        return [
            'marketing' => [
                'child' => [
                    'reviews' => [
                        'priority' => 30,
                        'class' => 'reviews',
                        'href' => admin_url('igniter/local/reviews'),
                        'title' => lang('lang:igniter.local::default.reviews.side_menu'),
                        'permission' => 'Admin.Reviews',
                    ],
                ],
            ],
            'system' => [
                'child' => [
                    'locations' => [
                        'priority' => 10,
                        'class' => 'locations',
                        'href' => admin_url('locations'),
                        'title' => lang('igniter.local::default.text_title'),
                        'permission' => 'Admin.Locations',
                    ],
                ],
            ],
        ];
    }

    #[Override]
    public function registerPermissions(): array
    {
        return [
            'Admin.Locations' => [
                'label' => 'lang:igniter.local::default.locations_permissions',
                'group' => 'igniter::admin.permissions.name',
            ],
            'Admin.Reviews' => [
                'description' => 'lang:igniter.local::default.reviews.permissions',
                'group' => 'igniter.cart::default.text_permission_order_group',
            ],
        ];
    }

    #[Override]
    public function registerSettings(): array
    {
        return [
            'reviewsettings' => [
                'label' => 'lang:igniter.local::default.reviews.text_settings',
                'icon' => 'fa fa-comment-dots',
                'description' => 'lang:igniter.local::default.reviews.text_settings_description',
                'model' => ReviewSettings::class,
                'permissions' => ['Admin.Reviews'],
            ],
        ];
    }

    #[Override]
    public function registerFormWidgets(): array
    {
        return [
            StarRating::class => [
                'label' => 'Star Rating',
                'code' => 'starrating',
            ],
            MapArea::class => [
                'label' => 'Map Area',
                'code' => 'maparea',
            ],
            MapView::class => [
                'label' => 'Map View',
                'code' => 'mapview',
            ],
            ScheduleEditor::class => [
                'label' => 'Schedule Editor',
                'code' => 'scheduleeditor',
            ],
            SettingsEditor::class => [
                'label' => 'Settings Editor',
                'code' => 'settingseditor',
            ],
        ];
    }

    public function registerOnboardingSteps(): array
    {
        return [
            'igniter.local::locations' => [
                'label' => 'igniter.local::default.onboarding_locations',
                'description' => 'igniter.local::default.help_onboarding_locations',
                'icon' => 'fa-store',
                'url' => admin_url('locations/settings/'.LocationModel::getDefaultKey()),
                'priority' => 15,
                'complete' => LocationModel::onboardingIsComplete(...),
            ],
        ];
    }

    protected function extendDashboardChartsDatasets()
    {
        Charts::extend(function($charts): void {
            $charts->bindEvent('charts.extendDatasets', function() use ($charts): void {
                if (ReviewSettings::allowReviews()) {
                    $charts->mergeDataset('reports', 'sets', [
                        'reviews' => [
                            'label' => 'lang:igniter.local::default.reviews.text_title',
                            'color' => '#FFB74D',
                            'model' => Review::class,
                            'column' => 'created_at',
                            'priority' => 40,
                        ],
                    ]);
                }
            });
        });
    }

    protected function addAssetsToReviewsSettingsPage()
    {
        Event::listen('admin.form.extendFieldsBefore', function(Form $form): void {
            if (!$form->model instanceof ReviewSettings) {
                return;
            }

            $form->addJs('~/app/admin/formwidgets/repeater/assets/vendor/sortablejs/Sortable.min.js', 'sortable-js');
            $form->addJs('~/app/admin/formwidgets/repeater/assets/vendor/sortablejs/jquery-sortable.js', 'jquery-sortable-js');
            $form->addJs('~/app/admin/assets/js/ratings.js', 'ratings-js');
        });
    }

    protected function addReviewsRelationship(): void
    {
        Relation::morphMap([
            'reviews' => Review::class,
        ]);

        Reservation::extend(function($model): void {
            $model->relation['morphMany']['review'] = [Review::class];
        });
    }

    protected function bindRememberLocationAreaEvents(): void
    {
        Event::listen('location.position.updated', function($location, $position, $oldPosition): void {
            if ($position->format() !== $oldPosition?->format()) {
                $this->updateCustomerLastArea([
                    'query' => $position->format(),
                ]);
            }
        });

        Event::listen('location.area.updated', function($location, $coveredArea): void {
            $this->updateCustomerLastArea([
                'areaId' => $coveredArea->getKey(),
            ]);
        });

        Event::listen(['igniter.user.login', 'igniter.socialite.login'], function(): void {
            rescue(function(): void {
                if ((string)($lastArea = Auth::customer()->last_location_area) === '') {
                    return;
                }

                $lastArea = json_decode($lastArea, true);

                $searchQuery = array_get($lastArea, 'query');
                if ($searchQuery && $userPosition = Geocoder::geocode($searchQuery)->first()) {
                    LocationFacade::updateUserPosition($userPosition);
                }

                $areaId = array_get($lastArea, 'areaId');
                if ($areaId && $area = LocationArea::find($areaId)) {
                    /** @var LocationArea $area */
                    LocationFacade::updateNearbyArea($area);
                }
            });
        });
    }

    protected function updateCustomerLastArea($value)
    {
        if (!$customer = Auth::customer()) {
            return;
        }

        $lastArea = @json_decode($customer->last_location_area, true) ?: [];
        $lastArea = array_merge($lastArea, $value);

        $customer->updateQuietly([
            'last_location_area' => json_encode($lastArea),
        ]);
    }

    protected function registerLocationsMainMenuItems()
    {
        if (Igniter::runningInAdmin()) {
            AdminMenu::registerCallback(function(Navigation $manager): void {
                $manager->registerMainItems([
                    MainMenuItem::widget('locations', LocationPicker::class)
                        ->priority(0)
                        ->permission('Admin.Locations')
                        ->mergeConfig([
                            'form' => 'igniter.local::/models/location',
                            'request' => LocationRequest::class,
                        ]),
                ]);
            });
        }
    }
}

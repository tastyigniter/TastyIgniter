<?php

declare(strict_types=1);

namespace Igniter\Reservation;

use Igniter\Admin\DashboardWidgets\Charts;
use Igniter\Admin\DashboardWidgets\Statistics;
use Igniter\Admin\Models\StatusHistory;
use Igniter\Automation\AutomationRules\Actions\SendMailTemplate;
use Igniter\Automation\AutomationRules\Events\ReservationSchedule;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Reservation\AutomationRules\Conditions\ReservationAttribute;
use Igniter\Reservation\AutomationRules\Conditions\ReservationStatusAttribute;
use Igniter\Reservation\AutomationRules\Events\NewReservation;
use Igniter\Reservation\AutomationRules\Events\NewReservationStatus;
use Igniter\Reservation\AutomationRules\Events\ReservationAssigned;
use Igniter\Reservation\BulkActionWidgets\AssignTable;
use Igniter\Reservation\Classes\BookingManager;
use Igniter\Reservation\FormWidgets\FloorPlanner;
use Igniter\Reservation\Http\Requests\BookingSettingsRequest;
use Igniter\Reservation\Http\Requests\ReservationSettingsRequest;
use Igniter\Reservation\Listeners\AddsCustomerReservationsTabFields;
use Igniter\Reservation\Listeners\MaxGuestSizePerTimeslotReached;
use Igniter\Reservation\Listeners\RegistersDashboardCards;
use Igniter\Reservation\Listeners\SendReservationConfirmation;
use Igniter\Reservation\Models\Concerns\LocationAction;
use Igniter\Reservation\Models\DiningArea;
use Igniter\Reservation\Models\DiningSection;
use Igniter\Reservation\Models\DiningTable;
use Igniter\Reservation\Models\Observers\DiningTableObserver;
use Igniter\Reservation\Models\Observers\ReservationObserver;
use Igniter\Reservation\Models\Reservation;
use Igniter\Reservation\Models\Scopes\DiningTableScope;
use Igniter\Reservation\Models\Scopes\ReservationScope;
use Igniter\System\Classes\BaseExtension;
use Igniter\System\Models\Settings;
use Igniter\User\Http\Controllers\Customers;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Event;
use Override;

class Extension extends BaseExtension
{
    protected $listen = [
        'igniter.reservation.isFullyBookedOn' => [
            MaxGuestSizePerTimeslotReached::class,
        ],
        'igniter.reservation.confirmed' => [
            SendReservationConfirmation::class,
        ],
    ];

    protected $observers = [
        DiningTable::class => DiningTableObserver::class,
        Reservation::class => ReservationObserver::class,
    ];

    protected array $scopes = [
        DiningTable::class => DiningTableScope::class,
        Reservation::class => ReservationScope::class,
    ];

    #[Override]
    public function register(): void
    {
        parent::register();

        $this->app->singleton(BookingManager::class);

        $this->registerSystemSettings();
    }

    #[Override]
    public function boot(): void
    {
        $this->bindReservationEvent();

        Relation::enforceMorphMap([
            'reservations' => Reservation::class,
            'tables' => DiningTable::class,
            'dining_areas' => DiningArea::class,
            'dining_sections' => DiningSection::class,
        ]);

        Customers::extendFormFields(new AddsCustomerReservationsTabFields);

        LocationModel::implement(LocationAction::class);

        LocationModel::extend(function(LocationModel $model): void {
            $model->relation['hasMany']['dining_areas'] = [DiningArea::class, 'delete' => true];
            $model->relation['morphedByMany']['tables'] = [DiningTable::class, 'name' => 'locationable'];
        });

        $this->extendDashboardChartsDatasets();

        Statistics::registerCards(fn(): array => (new RegistersDashboardCards)());
    }

    #[Override]
    public function registerMailTemplates(): array
    {
        return [
            'igniter.reservation::mail.reservation' => 'lang:igniter.reservation::default.text_mail_reservation',
            'igniter.reservation::mail.reservation_alert' => 'lang:igniter.reservation::default.text_mail_reservation_alert',
            'igniter.reservation::mail.reservation_update' => 'lang:igniter.reservation::default.text_mail_reservation_update',
            'igniter.reservation::mail.reservation_reminder' => 'lang:igniter.reservation::default.text_mail_reservation_reminder',
        ];
    }

    public function registerAutomationRules(): array
    {
        return [
            'events' => [
                'igniter.reservation.confirmed' => NewReservation::class,
                'igniter.reservation.statusAdded' => NewReservationStatus::class,
                'igniter.reservation.assigned' => ReservationAssigned::class,
            ],
            'actions' => [],
            'conditions' => [
                ReservationAttribute::class,
                ReservationStatusAttribute::class,
            ],
            'presets' => [
                'remind_confirmed_reservation_3_days_before_date' => [
                    'name' => 'Send a reminder 3 days before the confirmed reservation date',
                    'event' => ReservationSchedule::class,
                    'conditions' => [
                        ReservationAttribute::class => [
                            [
                                'attribute' => 'days_until',
                                'operator' => 'is',
                                'value' => 3,
                            ],
                            [
                                'attribute' => 'status_id',
                                'operator' => 'is',
                                'value' => setting('confirmed_reservation_status'),
                            ],
                            [
                                'attribute' => 'hours_until',
                                'operator' => 'is',
                                'value' => 15,
                            ],
                        ],
                    ],
                    'actions' => [
                        SendMailTemplate::class => [
                            'template' => 'igniter.reservation::mail.reservation_reminder',
                            'send_to' => 'customer',
                        ],
                    ],
                ],
            ],
        ];
    }

    #[Override]
    public function registerPermissions(): array
    {
        return [
            'Admin.Tables' => [
                'label' => 'igniter.reservation::default.text_permission_dining_areas',
                'group' => 'igniter.reservation::default.text_permission_group',
            ],
            'Admin.Reservations' => [
                'label' => 'igniter.reservation::default.text_permission_reservations',
                'group' => 'igniter.reservation::default.text_permission_group',
            ],
            'Admin.DeleteReservations' => [
                'label' => 'igniter.reservation::default.text_permission_delete_reservations',
                'group' => 'igniter.reservation::default.text_permission_group',
            ],
            'Admin.AssignReservations' => [
                'label' => 'igniter.reservation::default.text_permission_assign_reservations',
                'group' => 'igniter.reservation::default.text_permission_group',
            ],
            'Admin.AssignReservationTables' => [
                'label' => 'igniter.reservation::default.text_permission_assign_reservation_tables',
                'group' => 'igniter.reservation::default.text_permission_group',
            ],
        ];
    }

    #[Override]
    public function registerNavigation(): array
    {
        return [
            'reservations' => [
                'priority' => 20,
                'class' => 'reservations',
                'icon' => 'fa-calendar-check',
                'href' => admin_url('reservations'),
                'title' => lang('igniter.reservation::default.text_side_menu_reservation'),
                'permission' => 'Admin.Reservations',
            ],
            'restaurant' => [
                'child' => [
                    'dining_areas' => [
                        'priority' => 50,
                        'class' => 'dining_areas',
                        'href' => admin_url('dining_areas'),
                        'title' => lang('igniter.reservation::default.text_side_menu_tables'),
                        'permission' => 'Admin.Tables',
                    ],
                ],
            ],
        ];
    }

    #[Override]
    public function registerFormWidgets(): array
    {
        return [
            FloorPlanner::class => [
                'label' => 'Floor planner',
                'code' => 'floorplanner',
            ],
        ];
    }

    public function registerListActionWidgets(): array
    {
        return [
            AssignTable::class => [
                'code' => 'assign_table',
            ],
        ];
    }

    public function registerLocationSettings(): array
    {
        return [
            'booking' => [
                'label' => 'igniter.reservation::default.settings.text_tab_booking',
                'description' => 'igniter.reservation::default.settings.text_tab_desc_booking',
                'icon' => 'fa fa-sliders',
                'priority' => 0,
                'form' => 'igniter.reservation::/models/bookingsettings',
                'request' => BookingSettingsRequest::class,
            ],
        ];
    }

    protected function bindReservationEvent()
    {
        Event::listen('igniter.reservation.statusAdded', function(Reservation $model, $statusHistory): void {
            if ($statusHistory->notify) {
                $model->reloadRelations();
                $model->mailSend('igniter.reservation::mail.reservation_update', 'customer');
            }
        });

        Event::listen('admin.statusHistory.beforeAddStatus', function($statusHistory, $reservation, $statusId, $previousStatus): void {
            if ($reservation instanceof Reservation && !StatusHistory::alreadyExists($reservation, $statusId)) {
                Event::dispatch('igniter.reservation.beforeAddStatus', [$statusHistory, $reservation, $statusId, $previousStatus], true);
            }
        });

        Event::listen('admin.statusHistory.added', function($reservation, $statusHistory): void {
            if ($reservation instanceof Reservation) {
                Event::dispatch('igniter.reservation.statusAdded', [$reservation, $statusHistory], true);
            }
        });

        Event::listen('admin.assignable.assigned', function($reservation, $assignableLog): void {
            if ($reservation instanceof Reservation) {
                Event::dispatch('igniter.reservation.assigned', [$reservation, $assignableLog], true);
            }
        });
    }

    protected function registerSystemSettings()
    {
        Settings::registerCallback(function(Settings $manager): void {
            $manager->registerSettingItems('core', [
                'reservation' => [
                    'label' => 'lang:igniter.reservation::default.text_setting_reservation',
                    'description' => 'lang:igniter.reservation::default.help_setting_reservation',
                    'icon' => 'fa fa-chair',
                    'priority' => 1,
                    'permission' => ['Site.Settings'],
                    'url' => admin_url('settings/edit/reservation'),
                    'form' => 'igniter.reservation::/models/reservationsettings',
                    'request' => ReservationSettingsRequest::class,
                ],
            ]);
        });
    }

    protected function extendDashboardChartsDatasets()
    {
        Charts::extend(function($charts): void {
            $charts->bindEvent('charts.extendDatasets', function() use ($charts): void {
                $charts->mergeDataset('reports', 'sets', [
                    'reservations' => [
                        'label' => 'lang:igniter.reservation::default.text_charts_reservations',
                        'color' => '#BA68C8',
                        'model' => Reservation::class,
                        'column' => 'reserve_date',
                        'priority' => 30,
                    ],
                ]);
            });
        });
    }
}

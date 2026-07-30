<?php

declare(strict_types=1);

namespace Igniter\User;

use Igniter\Admin\Classes\MainMenuItem;
use Igniter\Admin\Classes\Navigation;
use Igniter\Admin\DashboardWidgets\Charts;
use Igniter\Admin\DashboardWidgets\Statistics;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;
use Igniter\Automation\Classes\EventManager;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Local\Models\Location;
use Igniter\System\Classes\BaseExtension;
use Igniter\System\Contracts\StickyNotification;
use Igniter\System\Models\Settings;
use Igniter\User\Auth\AuthServiceProvider;
use Igniter\User\AutomationRules\Conditions\CustomerAttribute;
use Igniter\User\AutomationRules\Events\CustomerRegistered;
use Igniter\User\Classes\BladeExtension;
use Igniter\User\Classes\PermissionManager;
use Igniter\User\Classes\RouteRegistrar;
use Igniter\User\Console\Commands\AllocatorCommand;
use Igniter\User\Console\Commands\ClearUserStateCommand;
use Igniter\User\Facades\Auth;
use Igniter\User\FormWidgets\PermissionEditor;
use Igniter\User\Http\Middleware\Authenticate;
use Igniter\User\Http\Middleware\InjectImpersonateBanner;
use Igniter\User\Http\Middleware\LogUserLastSeen;
use Igniter\User\Http\Middleware\ThrottleRequests;
use Igniter\User\Http\Requests\UserSettingsRequest;
use Igniter\User\MainMenuWidgets\NotificationList;
use Igniter\User\MainMenuWidgets\UserPanel;
use Igniter\User\Models\Address;
use Igniter\User\Models\AssignableLog;
use Igniter\User\Models\Customer;
use Igniter\User\Models\CustomerGroup;
use Igniter\User\Models\Notification;
use Igniter\User\Models\Observers\CustomerObserver;
use Igniter\User\Models\Observers\UserObserver;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Igniter\User\Notifications\CustomerRegisteredNotification;
use Igniter\User\Subscribers\AssigneeUpdatedSubscriber;
use Igniter\User\Subscribers\ConsoleSubscriber;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Override;

class Extension extends BaseExtension
{
    protected $subscribe = [
        AssigneeUpdatedSubscriber::class,
        ConsoleSubscriber::class,
    ];

    protected $observers = [
        Customer::class => CustomerObserver::class,
        User::class => UserObserver::class,
    ];

    protected array $morphMap = [
        'addresses' => Address::class,
        'assignable_logs' => AssignableLog::class,
        'customer_groups' => CustomerGroup::class,
        'customers' => Customer::class,
        'notifications' => Notification::class,
        'user_groups' => UserGroup::class,
        'users' => User::class,
    ];

    public array $singletons = [
        PermissionManager::class,
    ];

    #[Override]
    public function register(): void
    {
        parent::register();

        $this->app->register(AuthServiceProvider::class);

        $this->registerConsoleCommand('igniter.assignable.allocator', AllocatorCommand::class);
        $this->registerConsoleCommand('igniter.user-state.clear', ClearUserStateCommand::class);

        $this->registerBladeDirectives();
        $this->registerSystemSettings();
        $this->registerEventGlobalParams();

        Route::pushMiddlewareToGroup('igniter:admin', Authenticate::class);
        Route::pushMiddlewareToGroup('igniter:admin', LogUserLastSeen::class);
        Route::pushMiddlewareToGroup('igniter', InjectImpersonateBanner::class);
    }

    #[Override]
    public function boot(): void
    {
        $this->defineRoutes();
        $this->configureRateLimiting();

        Event::listen('igniter.user.register', function(Customer $customer, array $data): void {
            CustomerRegisteredNotification::make()->subject($customer)->broadcast();
        });

        $this->registerUserPanelAndNotificationsAdminMenus();
        $this->extendDashboardChartsDatasets();

        Location::extend(function($model): void {
            $model->relation['morphedByMany']['users'] = [User::class, 'name' => 'locationable'];
        });

        Template::registerHook('endBody', fn(): View => view('igniter.user::_partials.admin_impersonate_banner'));

        Event::listen(NotificationSent::class, function(NotificationSent $event): void {
            if ($event->response instanceof Notification && is_subclass_of($event->notification, StickyNotification::class)) {
                $event->notifiable->notifications()
                    ->where('type', method_exists($event->notification, 'databaseType')
                        ? $event->notification->databaseType($event->notifiable)
                        : $event->notification::class)
                    ->where('id', '!=', $event->response->getKey())
                    ->delete();
            }
        });

        Igniter::prunableModel(Notification::class);
    }

    public function registerAutomationRules(): array
    {
        return [
            'events' => [
                'igniter.user.register' => CustomerRegistered::class,
            ],
            'actions' => [],
            'conditions' => [
                CustomerAttribute::class,
            ],
        ];
    }

    #[Override]
    public function registerMailTemplates(): array
    {
        return [
            'igniter.user::mail.admin_password_reset' => 'lang:igniter.user::default.text_mail_admin_password_reset',
            'igniter.user::mail.admin_password_reset_request' => 'lang:igniter.user::default.text_mail_admin_password_reset_request',
            'igniter.user::mail.password_reset' => 'lang:igniter.user::default.text_mail_password_reset',
            'igniter.user::mail.password_reset_request' => 'lang:igniter.user::default.text_mail_password_reset_request',
            'igniter.user::mail.registration' => 'lang:igniter.user::default.text_mail_registration',
            'igniter.user::mail.registration_alert' => 'lang:igniter.user::default.text_mail_registration_alert',
            'igniter.user::mail.activation' => 'lang:igniter.user::default.text_mail_activation',
            'igniter.user::mail.invite' => 'lang:igniter.user::default.text_mail_invite',
            'igniter.user::mail.invite_customer' => 'lang:igniter.user::default.text_mail_invite_customer',
        ];
    }

    #[Override]
    public function registerNavigation(): array
    {
        return [
            'customers' => [
                'priority' => 30,
                'class' => 'customers',
                'icon' => 'fa-user',
                'href' => admin_url('customers'),
                'title' => lang('igniter.user::default.text_side_menu_customer'),
                'permission' => 'Admin.Customers',
            ],
            'system' => [
                'child' => [
                    'users' => [
                        'priority' => 20,
                        'class' => 'users',
                        'href' => admin_url('users'),
                        'title' => lang('igniter.user::default.text_side_menu_user'),
                        'permission' => 'Admin.Staffs',
                    ],
                ],
            ],
        ];
    }

    public function registerSystemSettings(): void
    {
        Settings::registerCallback(function(Settings $manager): void {
            $manager->registerSettingItems('core', [
                'user' => [
                    'label' => 'lang:igniter.user::default.text_tab_user',
                    'description' => 'lang:igniter.user::default.text_tab_desc_user',
                    'icon' => 'fa fa-users-gear',
                    'priority' => 2,
                    'permission' => ['Site.Settings'],
                    'url' => admin_url('settings/edit/user'),
                    'form' => 'igniter.user::/models/usersettings',
                    'request' => UserSettingsRequest::class,
                ],
            ]);
        });
    }

    #[Override]
    public function registerPermissions(): array
    {
        return [
            'Admin.CustomerGroups' => [
                'label' => 'igniter.user::default.text_permission_customer_groups',
                'group' => 'igniter.user::default.text_permission_group',
            ],
            'Admin.Customers' => [
                'label' => 'igniter.user::default.text_permission_customers',
                'group' => 'igniter.user::default.text_permission_group',
            ],
            'Admin.DeleteCustomers' => [
                'label' => 'igniter.user::default.text_permission_delete_customers',
                'group' => 'igniter.user::default.text_permission_group',
            ],
            'Admin.Impersonate' => [
                'label' => 'igniter.user::default.text_permission_impersonate_staff',
                'group' => 'igniter.user::default.text_permission_group',
            ],
            'Admin.ImpersonateCustomers' => [
                'label' => 'igniter.user::default.text_permission_impersonate_customers',
                'group' => 'igniter.user::default.text_permission_group',
            ],
            'Admin.StaffGroups' => [
                'label' => 'igniter.user::default.text_permission_user_groups',
                'group' => 'igniter.user::default.text_permission_group',
            ],
            'Admin.Staffs' => [
                'label' => 'igniter.user::default.text_permission_staffs',
                'group' => 'igniter.user::default.text_permission_group',
            ],
            'Admin.DeleteStaffs' => [
                'label' => 'igniter.user::default.text_permission_delete_staffs',
                'group' => 'igniter.user::default.text_permission_group',
            ],
        ];
    }

    #[Override]
    public function registerFormWidgets(): array
    {
        return [
            PermissionEditor::class => [
                'label' => 'Permission Editor',
                'code' => 'permissioneditor',
            ],
        ];
    }

    protected function registerEventGlobalParams()
    {
        if (class_exists(EventManager::class)) {
            resolve(EventManager::class)->registerCallback(function(EventManager $manager): void {
                $manager->registerGlobalParams([
                    'customer' => Auth::customer(),
                ]);
            });
        }
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('web', fn(Request $request) => Limit::perMinute(60)->by($request->user()?->getKey() ?: $request->ip()));

        if (Igniter::runningInAdmin()) {
            return;
        }

        $this->app->afterResolving(Kernel::class, function(Kernel $kernel): void {
            $kernel->appendMiddlewareToGroup('web', ThrottleRequests::class);
        });

        Event::listen('igniter.user.beforeThrottleRequest', function($request, $params) {
            $handler = str_after($request->header('x-igniter-request-handler'), '::');
            if (in_array($handler, [
                'onLogin',
                'onRegister',
                'onActivate',
                'onForgotPassword',
                'onResetPassword',
            ])) {
                $params->maxAttempts = 6;
                $params->decayMinutes = 1;

                return true;
            }
        });
    }

    protected function registerBladeDirectives()
    {
        $this->callAfterResolving('blade.compiler', function($compiler, $app): void {
            (new BladeExtension)->register();
        });
    }

    protected function registerUserPanelAndNotificationsAdminMenus()
    {
        if (!Igniter::runningInAdmin()) {
            return;
        }

        AdminMenu::registerCallback(function(Navigation $manager): void {
            $manager->registerMainItems([
                MainMenuItem::widget('notifications', NotificationList::class)
                    ->priority(15)
                    ->permission('Admin.Notifications'),
                MainMenuItem::widget('user', UserPanel::class)
                    ->mergeConfig([
                        'links' => [
                            'account' => [
                                'label' => 'igniter::admin.text_edit_details',
                                'iconCssClass' => 'fa fa-user fa-fw',
                                'url' => admin_url('users/account'),
                                'priority' => 10,
                            ],
                            'logout' => [
                                'label' => 'igniter::admin.text_logout',
                                'cssClass' => 'text-danger',
                                'iconCssClass' => 'fa fa-power-off fa-fw',
                                'url' => admin_url('logout'),
                                'priority' => 999,
                            ],
                        ],
                    ])
                    ->priority(999),
            ]);
        });
    }

    protected function defineRoutes()
    {
        if (app()->routesAreCached()) {
            return;
        }

        Route::group([], function($router): void {
            (new RouteRegistrar($router))->all();
        });
    }

    protected function extendDashboardChartsDatasets()
    {
        Charts::extend(function($charts): void {
            $charts->bindEvent('charts.extendDatasets', function() use ($charts): void {
                $charts->mergeDataset('reports', 'sets', [
                    'customers' => [
                        'label' => 'lang:igniter.user::default.text_charts_customers',
                        'color' => '#4DB6AC',
                        'model' => Customer::class,
                        'column' => 'created_at',
                        'priority' => 10,
                    ],
                ]);
            });
        });

        Statistics::registerCards(fn(): array => [
            'customer' => [
                'label' => 'lang:igniter.user::default.text_total_customer',
                'icon' => ' text-info fa fa-4x fa-users',
                'valueFrom' => function(string $cardCode, $start, $end, $callback): int {
                    $query = Customer::query();

                    $callback($query);

                    return $query->count();
                },
            ],
        ]);
    }
}

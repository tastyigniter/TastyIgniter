<?php

namespace Admin;

use Admin\Classes\Navigation;
use Admin\Classes\OnboardingSteps;
use Admin\Classes\PermissionManager;
use Admin\Classes\Widgets;
use Admin\Facades\AdminAuth;
use Admin\Middleware\LogUserLastSeen;
use AdminLocation;
use AdminMenu;
use Igniter\Flame\ActivityLog\Models\Activity;
use Igniter\Flame\Foundation\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Event;
use System\Classes\MailManager;
use System\Libraries\Assets;
use System\Models\Settings_model;

class ServiceProvider extends AppServiceProvider
{
    /**
     * Bootstrap the service provider.
     * @return void
     */
    public function boot()
    {
        parent::boot('admin');

        $this->defineEloquentMorphMaps();

        if ($this->app->runningInAdmin()) {
            $this->resolveFlashSessionKey();
            $this->replaceNavMenuItem();

            $this->app['router']->pushMiddlewareToGroup('web', LogUserLastSeen::class);
        }
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        parent::register('admin');

        $this->registerActivityTypes();
        $this->registerMailTemplates();
        $this->registerAllocatorSchedule();

        if ($this->app->runningInAdmin()) {
            $this->registerAssets();
            $this->registerSettings();
            $this->registerPermissions();
            $this->registerDashboardWidgets();
            $this->registerFormWidgets();
            $this->registerMainMenuItems();
            $this->registerNavMenuItems();
            $this->registerOnboardingSteps();
        }
    }

    protected function registerMailTemplates()
    {
        MailManager::instance()->registerCallback(function (MailManager $manager) {
            $manager->registerMailTemplates([
                'admin::_mail.order_update' => 'lang:system::lang.mail_templates.text_order_update',
                'admin::_mail.reservation_update' => 'lang:system::lang.mail_templates.text_reservation_update',
                'admin::_mail.password_reset' => 'lang:system::lang.mail_templates.text_password_reset_alert',
                'admin::_mail.password_reset_request' => 'lang:system::lang.mail_templates.text_password_reset_request_alert',
            ]);
        });
    }

    protected function registerAssets()
    {
        Assets::registerCallback(function (Assets $manager) {
            $manager->registerSourcePath(app_path('admin/assets'));

            $manager->addFromManifest('~/app/admin/views/_meta/assets.json');
        });
    }

    /*
     * Register dashboard widgets
     */
    protected function registerDashboardWidgets()
    {
        Widgets::instance()->registerDashboardWidgets(function (Widgets $manager) {
            $manager->registerDashboardWidget(\System\DashboardWidgets\Activities::class, [
                'label' => 'Recent activities',
                'context' => 'dashboard',
            ]);

            $manager->registerDashboardWidget(\System\DashboardWidgets\Cache::class, [
                'label' => 'Cache Usage',
                'context' => 'dashboard',
            ]);

            $manager->registerDashboardWidget(\System\DashboardWidgets\News::class, [
                'label' => 'Latest News',
                'context' => 'dashboard',
            ]);

            $manager->registerDashboardWidget(\Admin\DashboardWidgets\Statistics::class, [
                'label' => 'Statistics widget',
                'context' => 'dashboard',
            ]);

            $manager->registerDashboardWidget(\Admin\DashboardWidgets\Onboarding::class, [
                'label' => 'Onboarding widget',
                'context' => 'dashboard',
            ]);

            $manager->registerDashboardWidget(\Admin\DashboardWidgets\Charts::class, [
                'label' => 'Charts widget',
                'context' => 'dashboard',
            ]);
        });
    }

    /**
     * Register widgets
     */
    protected function registerFormWidgets()
    {
        Widgets::instance()->registerFormWidgets(function (Widgets $manager) {
            $manager->registerFormWidget('Admin\FormWidgets\CodeEditor', [
                'label' => 'Code editor',
                'code' => 'codeeditor',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\ColorPicker', [
                'label' => 'Color picker',
                'code' => 'colorpicker',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\Connector', [
                'label' => 'Connector',
                'code' => 'connector',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\DataTable', [
                'label' => 'Data Table',
                'code' => 'datatable',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\DatePicker', [
                'label' => 'Date picker',
                'code' => 'datepicker',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\MapArea', [
                'label' => 'Map Area',
                'code' => 'maparea',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\MarkdownEditor', [
                'label' => 'Markdown Editor',
                'code' => 'markdowneditor',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\MediaFinder', [
                'label' => 'Media finder',
                'code' => 'mediafinder',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\PermissionEditor', [
                'label' => 'Permission Editor',
                'code' => 'permissioneditor',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\RecordEditor', [
                'label' => 'Record Editor',
                'code' => 'recordeditor',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\Relation', [
                'label' => 'Relationship',
                'code' => 'relation',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\Repeater', [
                'label' => 'Repeater',
                'code' => 'repeater',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\RichEditor', [
                'label' => 'Rich editor',
                'code' => 'richeditor',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\StatusEditor', [
                'label' => 'Status Editor',
                'code' => 'statuseditor',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\StarRating', [
                'label' => 'Star Rating',
                'code' => 'starrating',
            ]);
        });
    }

    /**
     * Register admin top menu navigation items
     */
    protected function registerMainMenuItems()
    {
        AdminMenu::registerCallback(function (Navigation $manager) {
            $manager->registerMainItems([
                'preview' => [
                    'icon' => 'fa-store',
                    'attributes' => [
                        'class' => 'nav-link front-end',
                        'title' => 'lang:admin::lang.side_menu.storefront',
                        'href' => root_url(),
                        'target' => '_blank',
                    ],
                ],
                'activity' => [
                    'label' => 'lang:admin::lang.text_activity_title',
                    'icon' => 'fa-bell',
                    'badge' => 'badge-danger',
                    'type' => 'dropdown',
                    'badgeCount' => ['System\Models\Activities_model', 'unreadCount'],
                    'markAsRead' => ['System\Models\Activities_model', 'markAllAsRead'],
                    'options' => ['System\Models\Activities_model', 'listMenuActivities'],
                    'partial' => '~/app/system/views/activities/latest',
                    'viewMoreUrl' => admin_url('activities'),
                    'permission' => 'Admin.Activities',
                    'attributes' => [
                        'class' => 'nav-link',
                        'href' => '',
                        'data-toggle' => 'dropdown',
                    ],
                ],
                'settings' => [
                    'type' => 'partial',
                    'path' => 'top_settings_menu',
                    'badgeCount' => ['System\Models\Settings_model', 'updatesCount'],
                    'options' => ['System\Models\Settings_model', 'listMenuSettingItems'],
                    'permission' => 'Site.Settings',
                ],
                'user' => [
                    'type' => 'partial',
                    'path' => 'top_nav_user_menu',
                    'markAsRead' => ['Admin\Classes\Location', 'setStaffCurrent'],
                ],
            ]);
        });
    }

    /**
     * Register admin menu navigation items
     */
    protected function registerNavMenuItems()
    {
        AdminMenu::registerCallback(function (Navigation $manager) {
            $manager->registerNavItems([
                'dashboard' => [
                    'priority' => 0,
                    'class' => 'dashboard admin',
                    'href' => admin_url('dashboard'),
                    'icon' => 'fa-tachometer-alt',
                    'title' => lang('admin::lang.side_menu.dashboard'),
                ],
                'restaurant' => [
                    'priority' => 10,
                    'class' => 'restaurant',
                    'icon' => 'fa-store',
                    'title' => lang('admin::lang.side_menu.restaurant'),
                    'child' => [
                        'locations' => [
                            'priority' => 10,
                            'class' => 'locations',
                            'href' => admin_url('locations'),
                            'title' => lang('admin::lang.side_menu.location'),
                            'permission' => 'Admin.Locations',
                        ],
                        'tables' => [
                            'priority' => 20,
                            'class' => 'tables',
                            'href' => admin_url('tables'),
                            'title' => lang('admin::lang.side_menu.table'),
                            'permission' => 'Admin.Tables',
                        ],
                    ],
                ],
                'kitchen' => [
                    'priority' => 20,
                    'class' => 'kitchen',
                    'icon' => 'fa-utensils',
                    'title' => lang('admin::lang.side_menu.kitchen'),
                    'child' => [
                        'menus' => [
                            'priority' => 10,
                            'class' => 'menus',
                            'href' => admin_url('menus'),
                            'title' => lang('admin::lang.side_menu.menu'),
                            'permission' => 'Admin.Menus',
                        ],
                        'categories' => [
                            'priority' => 20,
                            'class' => 'categories',
                            'href' => admin_url('categories'),
                            'title' => lang('admin::lang.side_menu.category'),
                            'permission' => 'Admin.Categories',
                        ],
                        'mealtimes' => [
                            'priority' => 30,
                            'class' => 'mealtimes',
                            'href' => admin_url('mealtimes'),
                            'title' => lang('admin::lang.side_menu.mealtimes'),
                            'permission' => 'Admin.Mealtimes',
                        ],
                    ],
                ],
                'sales' => [
                    'priority' => 30,
                    'class' => 'sales',
                    'icon' => 'fa-chart-bar',
                    'title' => lang('admin::lang.side_menu.sale'),
                    'child' => [
                        'orders' => [
                            'priority' => 10,
                            'class' => 'orders',
                            'href' => admin_url('orders'),
                            'title' => lang('admin::lang.side_menu.order'),
                            'permission' => 'Admin.Orders',
                        ],
                        'reservations' => [
                            'priority' => 20,
                            'class' => 'reservations',
                            'href' => admin_url('reservations'),
                            'title' => lang('admin::lang.side_menu.reservation'),
                            'permission' => 'Admin.Reservations',
                        ],
                        'statuses' => [
                            'priority' => 30,
                            'class' => 'statuses',
                            'href' => admin_url('statuses'),
                            'title' => lang('admin::lang.side_menu.status'),
                            'permission' => 'Admin.Statuses',
                        ],
                        'payments' => [
                            'priority' => 40,
                            'class' => 'payments',
                            'href' => admin_url('payments'),
                            'title' => lang('admin::lang.side_menu.payment'),
                            'permission' => 'Admin.Payments',
                        ],
                    ],
                ],
                'marketing' => [
                    'priority' => 40,
                    'class' => 'marketing',
                    'icon' => 'fa-chart-line',
                    'title' => lang('admin::lang.side_menu.marketing'),
                    'child' => [
                        'coupons' => [
                            'priority' => 10,
                            'class' => 'coupons',
                            'href' => admin_url('coupons'),
                            'title' => lang('admin::lang.side_menu.coupon'),
                            'permission' => 'Admin.Coupons',
                        ],
                        'reviews' => [
                            'priority' => 20,
                            'class' => 'reviews',
                            'href' => admin_url('reviews'),
                            'title' => lang('admin::lang.side_menu.review'),
                            'permission' => 'Admin.Reviews',
                        ],
                    ],
                ],
                'design' => [
                    'priority' => 200,
                    'class' => 'design',
                    'icon' => 'fa-paint-brush',
                    'title' => lang('admin::lang.side_menu.design'),
                    'child' => [
                        'themes' => [
                            'priority' => 10,
                            'class' => 'themes',
                            'href' => admin_url('themes'),
                            'title' => lang('admin::lang.side_menu.theme'),
                            'permission' => 'Site.Themes',
                        ],
                        'mail_templates' => [
                            'priority' => 20,
                            'class' => 'mail_templates',
                            'href' => admin_url('mail_templates'),
                            'title' => lang('admin::lang.side_menu.mail_template'),
                            'permission' => 'Admin.MailTemplates',
                        ],
                    ],
                ],
                'users' => [
                    'priority' => 100,
                    'class' => 'users',
                    'icon' => 'fa-user',
                    'title' => lang('admin::lang.side_menu.user'),
                    'child' => [
                        'customers' => [
                            'priority' => 10,
                            'class' => 'customers',
                            'href' => admin_url('customers'),
                            'title' => lang('admin::lang.side_menu.customer'),
                            'permission' => 'Admin.Customers',
                        ],
                        'staffs' => [
                            'priority' => 20,
                            'class' => 'staffs',
                            'href' => admin_url('staffs'),
                            'title' => lang('admin::lang.side_menu.staff'),
                            'permission' => 'Admin.Staffs',
                        ],
                    ],
                ],
                'localisation' => [
                    'priority' => 300,
                    'class' => 'localisation',
                    'icon' => 'fa-globe',
                    'title' => lang('admin::lang.side_menu.localisation'),
                    'child' => [
                        'languages' => [
                            'priority' => 10,
                            'class' => 'languages',
                            'href' => admin_url('languages'),
                            'title' => lang('admin::lang.side_menu.language'),
                            'permission' => 'Site.Languages',
                        ],
                        'currencies' => [
                            'priority' => 20,
                            'class' => 'currencies',
                            'href' => admin_url('currencies'),
                            'title' => lang('admin::lang.side_menu.currency'),
                            'permission' => 'Site.Currencies',
                        ],
                        'countries' => [
                            'priority' => 30,
                            'class' => 'countries',
                            'href' => admin_url('countries'),
                            'title' => lang('admin::lang.side_menu.country'),
                            'permission' => 'Site.Countries',
                        ],
                    ],
                ],
                'tools' => [
                    'priority' => 400,
                    'class' => 'tools',
                    'icon' => 'fa-wrench',
                    'title' => lang('admin::lang.side_menu.tool'),
                    'child' => [
                        'media_manager' => [
                            'priority' => 10,
                            'class' => 'media_manager',
                            'href' => admin_url('media_manager'),
                            'title' => lang('admin::lang.side_menu.media_manager'),
                            'permission' => 'Admin.MediaManager',
                        ],
                    ],
                ],
                'system' => [
                    'priority' => 999,
                    'class' => 'system',
                    'icon' => 'fa-cogs',
                    'title' => lang('admin::lang.side_menu.system'),
                    'child' => [
                        'settings' => [
                            'priority' => 0,
                            'class' => 'settings',
                            'href' => admin_url('settings'),
                            'title' => lang('admin::lang.side_menu.setting'),
                            'permission' => 'Site.Settings',
                        ],
                        'extensions' => [
                            'priority' => 20,
                            'class' => 'extensions',
                            'href' => admin_url('extensions'),
                            'title' => lang('admin::lang.side_menu.extension'),
                            'permission' => 'Admin.Extensions',
                        ],
                        'updates' => [
                            'priority' => 30,
                            'class' => 'updates',
                            'href' => admin_url('updates'),
                            'title' => lang('admin::lang.side_menu.updates'),
                            'permission' => 'Site.Updates',
                        ],
                        'error_logs' => [
                            'priority' => 50,
                            'class' => 'error_logs',
                            'href' => admin_url('error_logs'),
                            'title' => lang('admin::lang.side_menu.error_log'),
                            'permission' => 'Admin.ErrorLogs',
                        ],
                    ],
                ],
            ]);
        });
    }

    protected function replaceNavMenuItem()
    {
        AdminMenu::registerCallback(function (Navigation $manager) {
            // Change nav menu if single location mode is activated
            if (AdminLocation::check()) {
                $manager->mergeNavItem('locations', [
                    'href' => admin_url('locations/settings'),
                    'title' => lang('admin::lang.side_menu.setting'),
                ], 'restaurant');
            }

            if (AdminAuth::staff() AND !AdminAuth::staff()->hasGlobalAssignableScope()) {
                $manager->mergeNavItem('orders', [
                    'href' => admin_url('orders/assigned'),
                    'permission' => '',
                ], 'sales');

                $manager->mergeNavItem('reservations', [
                    'href' => admin_url('reservations/assigned'),
                    'permission' => '',
                ], 'sales');
            }
        });
    }

    protected function defineEloquentMorphMaps()
    {
        Relation::morphMap([
            'addresses' => 'Admin\Models\Addresses_model',
            'categories' => 'Admin\Models\Categories_model',
            'coupons_history' => 'Admin\Models\Coupons_history_model',
            'coupons' => 'Admin\Models\Coupons_model',
            'customer_groups' => 'Admin\Models\Customer_groups_model',
            'customers' => 'Admin\Models\Customers_model',
            'location_areas' => 'Admin\Models\Location_areas_model',
            'location_tables' => 'Admin\Models\Location_tables_model',
            'locations' => 'Admin\Models\Locations_model',
            'mealtimes' => 'Admin\Models\Mealtimes_model',
            'menu_categories' => 'Admin\Models\Menu_categories_model',
            'menu_item_option_values' => 'Admin\Models\Menu_item_option_values_model',
            'menu_item_options' => 'Admin\Models\Menu_item_options_model',
            'menu_option_values' => 'Admin\Models\Menu_option_values_model',
            'menu_options' => 'Admin\Models\Menu_options_model',
            'menus' => 'Admin\Models\Menus_model',
            'menus_specials' => 'Admin\Models\Menus_specials_model',
            'orders' => 'Admin\Models\Orders_model',
            'payment_logs' => 'Admin\Models\Payment_logs_model',
            'payments' => 'Admin\Models\Payments_model',
            'reservations' => 'Admin\Models\Reservations_model',
            'reviews' => 'Admin\Models\Reviews_model',
            'staff_groups' => 'Admin\Models\Staff_groups_model',
            'staffs' => 'Admin\Models\Staffs_model',
            'status_history' => 'Admin\Models\Status_history_model',
            'statuses' => 'Admin\Models\Statuses_model',
            'tables' => 'Admin\Models\Tables_model',
            'users' => 'Admin\Models\Users_model',
            'working_hours' => 'Admin\Models\Working_hours_model',
        ]);
    }

    protected function resolveFlashSessionKey()
    {
        $this->app->resolving('flash', function (\Igniter\Flame\Flash\FlashBag $flash) {
            $flash->setSessionKey('flash_data_admin');
        });
    }

    protected function registerOnboardingSteps()
    {
        OnboardingSteps::registerCallback(function (OnboardingSteps $manager) {
            $manager->registerSteps([
                'admin::settings' => [
                    'label' => 'admin::lang.dashboard.onboarding.label_settings',
                    'description' => 'admin::lang.dashboard.onboarding.help_settings',
                    'icon' => 'fa-gears',
                    'url' => admin_url('settings'),
                    'complete' => ['System\Models\Settings_model', 'onboardingIsComplete'],
                ],
                'admin::locations' => [
                    'label' => 'admin::lang.dashboard.onboarding.label_locations',
                    'description' => 'admin::lang.dashboard.onboarding.help_locations',
                    'icon' => 'fa-store',
                    'url' => admin_url('locations'),
                    'complete' => ['Admin\Models\Locations_model', 'onboardingIsComplete'],
                ],
                'admin::themes' => [
                    'label' => 'admin::lang.dashboard.onboarding.label_themes',
                    'description' => 'admin::lang.dashboard.onboarding.help_themes',
                    'icon' => 'fa-paint-brush',
                    'url' => admin_url('themes'),
                    'complete' => ['System\Models\Themes_model', 'onboardingIsComplete'],
                ],
                'admin::extensions' => [
                    'label' => 'admin::lang.dashboard.onboarding.label_extensions',
                    'description' => 'admin::lang.dashboard.onboarding.help_extensions',
                    'icon' => 'fa-plug',
                    'url' => admin_url('extensions'),
                    'complete' => ['System\Models\Extensions_model', 'onboardingIsComplete'],
                ],
                'admin::payments' => [
                    'label' => 'admin::lang.dashboard.onboarding.label_payments',
                    'description' => 'admin::lang.dashboard.onboarding.help_payments',
                    'icon' => 'fa-credit-card',
                    'url' => admin_url('payments'),
                    'complete' => ['Admin\Models\Payments_model', 'onboardingIsComplete'],
                ],
                'admin::menus' => [
                    'label' => 'admin::lang.dashboard.onboarding.label_menus',
                    'description' => 'admin::lang.dashboard.onboarding.help_menus',
                    'icon' => 'fa-cutlery',
                    'url' => admin_url('menus'),
                ],
                'admin::mail' => [
                    'label' => 'admin::lang.dashboard.onboarding.label_mail',
                    'description' => 'admin::lang.dashboard.onboarding.help_mail',
                    'icon' => 'fa-envelope',
                    'url' => admin_url('settings/edit/mail'),
                ],
            ]);
        });
    }

    protected function registerActivityTypes()
    {
        Activity::registerCallback(function (Activity $manager) {
            $manager->registerActivityTypes([
                ActivityTypes\OrderAssigned::class,
                ActivityTypes\OrderStatusUpdated::class,
                ActivityTypes\ReservationAssigned::class,
                ActivityTypes\ReservationStatusUpdated::class,
            ]);
        });
    }

    protected function registerPermissions()
    {
        PermissionManager::instance()->registerCallback(function ($manager) {
            $manager->registerPermissions('Admin', [
                'Admin.Dashboard' => [
                    'label' => 'admin::lang.permissions.dashboard', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.Categories' => [
                    'label' => 'admin::lang.permissions.categories', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.Menus' => [
                    'label' => 'admin::lang.permissions.menus', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.Mealtimes' => [
                    'label' => 'admin::lang.permissions.mealtimes', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.Coupons' => [
                    'label' => 'admin::lang.permissions.coupons', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.Locations' => [
                    'label' => 'admin::lang.permissions.locations', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.Tables' => [
                    'label' => 'admin::lang.permissions.tables', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.Orders' => [
                    'label' => 'admin::lang.permissions.orders', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.AssignOrders' => [
                    'label' => 'admin::lang.permissions.assign_orders', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.Reservations' => [
                    'label' => 'admin::lang.permissions.reservations', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.AssignReservations' => [
                    'label' => 'admin::lang.permissions.assign_reservations', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.Payments' => [
                    'label' => 'admin::lang.permissions.payments', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.Reviews' => [
                    'label' => 'admin::lang.permissions.reviews', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.CustomerGroups' => [
                    'label' => 'admin::lang.permissions.customer_groups', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.Customers' => [
                    'label' => 'admin::lang.permissions.customers', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.ImpersonateCustomers' => [
                    'label' => 'admin::lang.permissions.impersonate_customers', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.StaffGroups' => [
                    'label' => 'admin::lang.permissions.staff_groups', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.Staffs' => [
                    'label' => 'admin::lang.permissions.staffs', 'group' => 'admin::lang.permissions.name',
                ],
                'Admin.Statuses' => [
                    'label' => 'admin::lang.permissions.statuses', 'group' => 'admin::lang.permissions.name',
                ],
            ]);
        });
    }

    protected function registerAllocatorSchedule()
    {
        Event::listen('console.schedule', function ($schedule) {
            // Check for assignables to assign every minute
            $schedule->call(function () {
                Classes\Allocator::instance()->allocate();
            })->everyMinute();
        });
    }

    protected function registerSettings()
    {
        Settings_model::registerCallback(function (Settings_model $manager) {
            $manager->registerSettingItems('core', [
                'setup' => [
                    'label' => 'lang:admin::lang.settings.text_tab_setup',
                    'description' => 'lang:admin::lang.settings.text_tab_desc_setup',
                    'icon' => 'fa fa-toggle-on',
                    'priority' => 1,
                    'permission' => ['Site.Settings'],
                    'url' => admin_url('settings/edit/setup'),
                    'form' => '~/app/admin/models/config/setup_settings',
                ],
                'user' => [
                    'label' => 'lang:admin::lang.settings.text_tab_user',
                    'description' => 'lang:admin::lang.settings.text_tab_desc_user',
                    'icon' => 'fa fa-user',
                    'priority' => 3,
                    'permission' => ['Site.Settings'],
                    'url' => admin_url('settings/edit/user'),
                    'form' => '~/app/admin/models/config/user_settings',
                ],
            ]);
        });
    }
}
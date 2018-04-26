<?php

namespace Admin;

use Admin\Classes\Navigation;
use Admin\Classes\Widgets;
use AdminAuth;
use File;
use Igniter\Flame\Foundation\Providers\AppServiceProvider;
use System\Libraries\Assets;
use System\Models\Mail_templates_model;

class ServiceProvider extends AppServiceProvider
{
    /**
     * Bootstrap the service provider.
     * @return void
     */
    public function boot()
    {
        parent::boot('admin');

        $this->replaceNavMenuItem();
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        parent::register('admin');

        $this->registerMailTemplates();

        if ($this->app->runningInAdmin()) {
            $this->registerBaseTags();
            $this->registerFormWidgets();
            $this->registerMainMenuItems();
            $this->registerNavMenuItems();
        }
    }

    protected function registerMailTemplates()
    {
        Mail_templates_model::registerCallback(function ($template) {
            $template->registerTemplates([
                'admin::_mail.order_update'           => 'lang:system::mail_templates.text_order_update',
                'admin::_mail.reservation_update'     => 'lang:system::mail_templates.text_reservation_update',
                'admin::_mail.password_reset'         => 'lang:system::mail_templates.text_password_reset_alert',
                'admin::_mail.password_reset_request' => 'lang:system::mail_templates.text_password_reset_request_alert',
            ]);
        });
    }

    protected function registerBaseTags()
    {
        Assets::defaultPaths([
            app_path($this->app->appContext().'/views'),
        ]);

        Assets::registerAssets(function (Assets $manager) {
            $manager->collection('app')->addTags([
                'meta' => [
                    ['name' => 'description', 'content' => setting('meta_description')],
                    ['name' => 'keywords', 'content' => setting('meta_keywords')],
                ],
                'css'  => [
                    [assets_url('css/vendor/bootstrap.min.css'), 'bootstrap-css'],
                    [assets_url('css/vendor/font-awesome.min.css'), 'font-awesome-css'],
                    [assets_url('css/app/app.css'), 'app-css'],
                ],
                'js'   => [
                    [assets_url('js/app/vendor.js'), 'vendor-js'],
                    [assets_url('js/app/flashmessage.js'), 'flashmessage-js'],
                    [assets_url('js/app/app.js'), 'app-js'],
                ],
            ]);

            $assetsConfigPath = app_path('admin/views/_meta/assets.json');
            if (File::exists($assetsConfigPath)) {
                $manager->collection('theme')->addTags(
                    json_decode(File::get($assetsConfigPath), TRUE)
                );
            }
        });
    }

    /**
     * Register widgets
     */
    protected function registerFormWidgets()
    {
        Widgets::instance()->registerFormWidgets(function (Widgets $manager) {
            $manager->registerFormWidget('Admin\FormWidgets\StarRating', [
                'label' => 'Star Rating',
                'code'  => 'starrating',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\MapArea', [
                'label' => 'Map Area',
                'code'  => 'maparea',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\Connector', [
                'label' => 'Connector',
                'code'  => 'connector',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\StatusEditor', [
                'label' => 'Status Editor',
                'code'  => 'statuseditor',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\Components', [
                'label' => 'Components',
                'code'  => 'components',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\Relation', [
                'label' => 'Relationship',
                'code'  => 'relation',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\Repeater', [
                'label' => 'Repeater',
                'code'  => 'repeater',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\PermissionEditor', [
                'label' => 'Permission Editor',
                'code'  => 'permissioneditor',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\MediaFinder', [
                'label' => 'Media finder',
                'code'  => 'mediafinder',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\DataTable', [
                'label' => 'Data Table',
                'code'  => 'datatable',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\DatePicker', [
                'label' => 'Date picker',
                'code'  => 'datepicker',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\ColorPicker', [
                'label' => 'Color picker',
                'code'  => 'colorpicker',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\RichEditor', [
                'label' => 'Rich editor',
                'code'  => 'richeditor',
            ]);

            $manager->registerFormWidget('Admin\FormWidgets\CodeEditor', [
                'label' => 'Code editor',
                'code'  => 'codeeditor',
            ]);
        });
    }

    /**
     * Register admin top menu navigation items
     */
    protected function registerMainMenuItems()
    {
        Navigation::registerCallback(function (Navigation $manager) {
            $manager->registerMainItems([
                'preview'  => [
                    'icon'       => 'fa-home',
                    'attributes' => [
                        'class'  => 'front-end',
                        'title'  => 'lang:admin::default.menu_storefront',
                        'href'   => root_url(),
                        'target' => '_blank',
                    ],
                ],
                'message'  => [
                    'label'       => 'lang:admin::default.text_message_title',
                    'icon'        => 'fa-envelope',
                    'badge'       => 'label-danger',
                    'type'        => 'dropdown',
                    'options'     => ['System\Models\Messages_model', 'listMenuMessages'],
                    'partial'     => '~/app/system/views/messages/latest',
                    'viewMoreUrl' => admin_url('messages'),
                    'permission'  => 'Admin.Messages',
                    'attributes'  => [
                        'class'       => 'dropdown-toggle',
                        'data-toggle' => 'dropdown',
                    ],
                ],
                'activity' => [
                    'label'       => 'lang:admin::default.text_activity_title',
                    'icon'        => 'fa-bell',
                    'type'        => 'dropdown',
                    'options' => ['System\Models\Activities_model', 'listMenuActivities'],
                    'partial'     => '~/app/system/views/activities/latest',
                    'viewMoreUrl' => admin_url('activities'),
                    'permission'  => 'Admin.Activities',
                    'attributes'  => [
                        'class'       => 'dropdown-toggle',
                        'data-toggle' => 'dropdown',
                    ],
                ],
                'settings' => [
                    'label'      => 'lang:admin::default.text_settings_title',
                    'icon'       => 'fa-gear',
                    'type'       => 'dropdown',
                    'options'    => ['System\Models\Settings_model', 'listMenuSettingItems'],
                    'permission'  => 'Site.Settings',
                    'attributes' => [
                        'class'       => 'dropdown-toggle',
                        'data-toggle' => 'dropdown',
                    ],
                ],
                'user'     => [
                    'type' => 'partial',
                    'path' => 'top_nav_user_menu',
                ],
            ]);
        });
    }

    /**
     * Register admin menu navigation items
     */
    protected function registerNavMenuItems()
    {
        Navigation::registerCallback(function (Navigation $manager) {
            $manager->registerNavItems([
                'dashboard'    => [
                    'priority'   => 0,
                    'class'      => 'dashboard admin',
                    'href'       => admin_url('dashboard'),
                    'icon'       => 'fa-dashboard',
                    'title'      => lang('admin::default.menu_dashboard'),
                    'permission' => 'Admin.Dashboard',
                ],
                'restaurant'   => [
                    'priority' => 10,
                    'class'    => 'restaurant',
                    'icon'     => 'fa-bank',
                    'title'    => lang('admin::default.menu_restaurant'),
                    'child'    => [
                        'locations' => [
                            'priority'   => 10,
                            'class'      => 'locations',
                            'href'       => admin_url('locations'),
                            'title'      => lang('admin::default.menu_location'),
                            'permission' => 'Admin.Locations',
                        ],
                        'tables'    => [
                            'priority'   => 20,
                            'class'      => 'tables',
                            'href'       => admin_url('tables'),
                            'title'      => lang('admin::default.menu_table'),
                            'permission' => 'Admin.Tables',
                        ],
                    ],
                ],
                'kitchen'      => [
                    'priority' => 20,
                    'class'    => 'kitchen',
                    'icon'     => 'fa-cutlery',
                    'title'    => lang('admin::default.menu_kitchen'),
                    'child'    => [
                        'menus'        => [
                            'priority'   => 10,
                            'class'      => 'menus',
                            'href'       => admin_url('menus'),
                            'title'      => lang('admin::default.menu_menu'),
                            'permission' => 'Admin.Menus',
                        ],
                        'menu_options' => [
                            'priority'   => 20,
                            'class'      => 'menu_options',
                            'href'       => admin_url('menu_options'),
                            'title'      => lang('admin::default.menu_option'),
                            'permission' => 'Admin.MenuOptions',
                        ],
                        'categories'   => [
                            'priority'   => 30,
                            'class'      => 'categories',
                            'href'       => admin_url('categories'),
                            'title'      => lang('admin::default.menu_category'),
                            'permission' => 'Admin.Categories',
                        ],
                        'mealtimes'    => [
                            'priority'   => 40,
                            'class'      => 'mealtimes',
                            'href'       => admin_url('mealtimes'),
                            'title'      => lang('admin::default.menu_mealtimes'),
                            'permission' => 'Admin.Mealtimes',
                        ],
                    ],
                ],
                'sales'        => [
                    'priority' => 30,
                    'class'    => 'sales',
                    'icon'     => 'fa-bar-chart-o',
                    'title'    => lang('admin::default.menu_sale'),
                    'child'    => [
                        'orders'       => [
                            'priority'   => 10,
                            'class'      => 'orders',
                            'href'       => admin_url('orders'),
                            'title'      => lang('admin::default.menu_order'),
                            'permission' => 'Admin.Orders',
                        ],
                        'reservations' => [
                            'priority'   => 20,
                            'class'      => 'reservations',
                            'href'       => admin_url('reservations'),
                            'title'      => lang('admin::default.menu_reservation'),
                            'permission' => 'Admin.Reservations',
                        ],
                        'reviews'      => [
                            'priority'   => 30,
                            'class'      => 'reviews',
                            'href'       => admin_url('reviews'),
                            'title'      => lang('admin::default.menu_review'),
                            'permission' => 'Admin.Reviews',
                        ],
                        'statuses'     => [
                            'priority'   => 40,
                            'class'      => 'statuses',
                            'href'       => admin_url('statuses'),
                            'title'      => lang('admin::default.menu_status'),
                            'permission' => 'Admin.Statuses',
                        ],
                        'payments'     => [
                            'priority'   => 50,
                            'class'      => 'payments',
                            'href'       => admin_url('payments'),
                            'title'      => lang('admin::default.menu_payment'),
                            'permission' => 'Admin.Payments',
                        ],
                    ],
                ],
                'marketing'    => [
                    'priority' => 40,
                    'class'    => 'marketing',
                    'icon'     => 'fa-line-chart',
                    'title'    => lang('admin::default.menu_marketing'),
                    'child'    => [
                        'coupons'  => [
                            'priority'   => 10,
                            'class'      => 'coupons',
                            'href'       => admin_url('coupons'),
                            'title'      => lang('admin::default.menu_coupon'),
                            'permission' => 'Admin.Coupons',
                        ],
                        'messages' => [
                            'priority'   => 20,
                            'class'      => 'messages',
                            'href'       => admin_url('messages'),
                            'title'      => lang('admin::default.menu_messages'),
                            'permission' => 'Admin.Messages',
                        ],
                        'banners'  => [
                            'priority'   => 30,
                            'class'      => 'banners',
                            'href'       => admin_url('banners'),
                            'title'      => lang('admin::default.menu_banner'),
                            'permission' => 'Admin.Banners',
                        ],
                    ],
                ],
                'extensions'   => [
                    'priority'   => 50,
                    'class'      => 'extensions',
                    'href'       => admin_url('extensions'),
                    'icon'       => 'fa-puzzle-piece',
                    'title'      => lang('admin::default.menu_extension'),
                    'permission' => 'Admin.Extensions',
                ],
                'design'       => [
                    'priority' => 200,
                    'class'    => 'design',
                    'icon'     => 'fa-paint-brush',
                    'title'    => lang('admin::default.menu_design'),
                    'child'    => [
                        'themes'         => [
                            'priority'   => 10,
                            'class'      => 'themes',
                            'href'       => admin_url('themes'),
                            'title'      => lang('admin::default.menu_theme'),
                            'permission' => 'Site.Themes',
                        ],
                        'mail_templates' => [
                            'priority'   => 20,
                            'class'      => 'mail_templates',
                            'href'       => admin_url('mail_templates'),
                            'title'      => lang('admin::default.menu_mail_template'),
                            'permission' => 'Admin.MailTemplates',
                        ],
                    ],
                ],
                'users'        => [
                    'priority' => 100,
                    'class'    => 'users',
                    'icon'     => 'fa-user',
                    'title'    => lang('admin::default.menu_user'),
                    'child'    => [
                        'customers'       => [
                            'priority'   => 10,
                            'class'      => 'customers',
                            'href'       => admin_url('customers'),
                            'title'      => lang('admin::default.menu_customer'),
                            'permission' => 'Admin.Customers',
                        ],
                        'customer_groups' => [
                            'priority'   => 20,
                            'class'      => 'customer_groups',
                            'href'       => admin_url('customer_groups'),
                            'title'      => lang('admin::default.menu_customer_group'),
                            'permission' => 'Admin.CustomerGroups',
                        ],
                        'staffs'          => [
                            'priority'   => 40,
                            'class'      => 'staffs',
                            'href'       => admin_url('staffs'),
                            'title'      => lang('admin::default.menu_staff'),
                            'permission' => 'Admin.Staffs',
                        ],
                        'staff_groups'    => [
                            'priority'   => 50,
                            'class'      => 'staff_groups',
                            'href'       => admin_url('staff_groups'),
                            'title'      => lang('admin::default.menu_staff_group'),
                            'permission' => 'Admin.StaffGroups',
                        ],
                        'permissions'     => [
                            'priority'   => 60,
                            'class'      => 'permissions',
                            'href'       => admin_url('permissions'),
                            'title'      => lang('admin::default.menu_permission'),
                            'permission' => 'Admin.Permissions',
                        ],
                    ],
                ],
                'localisation' => [
                    'priority' => 300,
                    'class'    => 'localisation',
                    'icon'     => 'fa-globe',
                    'title'    => lang('admin::default.menu_localisation'),
                    'child'    => [
                        'languages'  => [
                            'priority'   => 10,
                            'class'      => 'languages',
                            'href'       => admin_url('languages'),
                            'title'      => lang('admin::default.menu_language'),
                            'permission' => 'Site.Languages',
                        ],
                        'currencies' => [
                            'priority'   => 20,
                            'class'      => 'currencies',
                            'href'       => admin_url('currencies'),
                            'title'      => lang('admin::default.menu_currency'),
                            'permission' => 'Site.Currencies',
                        ],
                        'countries'  => [
                            'priority'   => 30,
                            'class'      => 'countries',
                            'href'       => admin_url('countries'),
                            'title'      => lang('admin::default.menu_country'),
                            'permission' => 'Site.Countries',
                        ],
                        'ratings'    => [
                            'priority'   => 40,
                            'class'      => 'ratings',
                            'href'       => admin_url('ratings'),
                            'title'      => lang('admin::default.menu_rating'),
                            'permission' => 'Admin.Ratings',
                        ],
                    ],
                ],
                'tools'        => [
                    'priority' => 400,
                    'class'    => 'tools',
                    'icon'     => 'fa-wrench',
                    'title'    => lang('admin::default.menu_tool'),
                    'child'    => [
                        'media_manager' => [
                            'priority'   => 10,
                            'class'      => 'media_manager',
                            'href'       => admin_url('media_manager'),
                            'title'      => lang('admin::default.menu_media_manager'),
                            'permission' => 'Admin.MediaManager',
                        ],
                    ],
                ],
                'system'       => [
                    'priority' => 999,
                    'class'    => 'system',
                    'icon'     => 'fa-cog',
                    'title'    => lang('admin::default.menu_system'),
                    'child'    => [
                        'activities' => [
                            'priority'   => 10,
                            'class'      => 'activities',
                            'href'       => admin_url('activities'),
                            'title'      => lang('admin::default.menu_activities'),
                            'permission' => 'Admin.Activities',
                        ],
                        'updates'    => [
                            'priority'   => 20,
                            'class'      => 'updates',
                            'href'       => admin_url('updates'),
                            'title'      => lang('admin::default.menu_updates'),
                            'permission' => 'Site.Updates',
                        ],
                        'settings'   => [
                            'priority'   => 30,
                            'class'      => 'settings',
                            'href'       => admin_url('settings'),
                            'title'      => lang('admin::default.menu_setting'),
                            'permission' => 'Site.Settings',
                        ],
                        'error_logs' => [
                            'priority'   => 40,
                            'class'      => 'error_logs',
                            'href'       => admin_url('error_logs'),
                            'title'      => lang('admin::default.menu_error_log'),
                            'permission' => 'Admin.ErrorLogs',
                        ],
                    ],
                ],
            ]);
        });
    }

    protected function replaceNavMenuItem()
    {
        Navigation::registerCallback(function (Navigation $manager) {
            // Change nav menu if single location mode is activated
            if (!AdminAuth::isStrictLocation() OR !is_single_location())
                return;

            $manager->removeNavItem('locations', 'restaurant');

            $manager->addNavItem('locations', [
                'priority'   => '1',
                'class'      => 'locations',
                'href'       => admin_url('locations/settings'),
                'title'      => lang('admin::default.menu_setting'),
                'permission' => 'Admin.Locations',
            ], 'restaurant');
        });
    }
}
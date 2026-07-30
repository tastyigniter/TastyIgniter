<?php

declare(strict_types=1);

namespace Igniter\Cart;

use Igniter\Cart\AutomationRules\Conditions\OrderAttribute;
use Igniter\Cart\AutomationRules\Conditions\OrderStatusAttribute;
use Igniter\Cart\AutomationRules\Events\NewOrderStatus;
use Igniter\Cart\AutomationRules\Events\OrderAssigned;
use Igniter\Cart\AutomationRules\Events\OrderPlaced;
use Igniter\Cart\BulkActionWidgets\UpdateStock;
use Igniter\Cart\CartConditions\PaymentFee;
use Igniter\Cart\CartConditions\Tax;
use Igniter\Cart\CartConditions\Tip;
use Igniter\Cart\Classes\CartConditionManager;
use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Classes\CheckoutForm;
use Igniter\Cart\Classes\OrderManager;
use Igniter\Cart\Events\BroadcastOrderPlacedEvent;
use Igniter\Cart\FormWidgets\StockEditor;
use Igniter\Cart\Http\Middleware\CartMiddleware;
use Igniter\Cart\Http\Middleware\InjectStatusWorkflow;
use Igniter\Cart\Http\Requests\CheckoutSettingsRequest;
use Igniter\Cart\Http\Requests\CollectionSettingsRequest;
use Igniter\Cart\Http\Requests\DeliverySettingsRequest;
use Igniter\Cart\Http\Requests\OrderSettingsRequest;
use Igniter\Cart\Listeners\AddsCustomerOrdersTabFields;
use Igniter\Cart\Listeners\ExtendDashboardCards;
use Igniter\Cart\Listeners\ExtendDashboardCharts;
use Igniter\Cart\Listeners\OrderPerTimeslotLimitReached;
use Igniter\Cart\Models\CartSettings;
use Igniter\Cart\Models\Category;
use Igniter\Cart\Models\Concerns\LocationAction;
use Igniter\Cart\Models\Ingredient;
use Igniter\Cart\Models\Mealtime;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuCategory;
use Igniter\Cart\Models\MenuItemOption;
use Igniter\Cart\Models\MenuItemOptionValue;
use Igniter\Cart\Models\MenuOption;
use Igniter\Cart\Models\MenuOptionValue;
use Igniter\Cart\Models\MenuSpecial;
use Igniter\Cart\Models\Observers\MenuItemOptionObserver;
use Igniter\Cart\Models\Observers\MenuObserver;
use Igniter\Cart\Models\Observers\MenuOptionObserver;
use Igniter\Cart\Models\Observers\MenuOptionValueObserver;
use Igniter\Cart\Models\Observers\OrderObserver;
use Igniter\Cart\Models\Order;
use Igniter\Cart\Models\Scopes\CategoryScope;
use Igniter\Cart\Models\Scopes\MenuScope;
use Igniter\Cart\Models\Scopes\OrderScope;
use Igniter\Cart\Models\Stock;
use Igniter\Cart\Models\StockHistory;
use Igniter\Cart\Notifications\OrderCreatedNotification;
use Igniter\Cart\OrderTypes\Collection;
use Igniter\Cart\OrderTypes\Delivery;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\System\Classes\BaseExtension;
use Igniter\System\Models\Settings;
use Igniter\User\Facades\Auth;
use Igniter\User\Http\Controllers\Customers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Event;
use Override;

class Extension extends BaseExtension
{
    protected $observers = [
        MenuItemOption::class => MenuItemOptionObserver::class,
        MenuOption::class => MenuOptionObserver::class,
        MenuOptionValue::class => MenuOptionValueObserver::class,
        Menu::class => MenuObserver::class,
        Order::class => OrderObserver::class,
    ];

    protected array $scopes = [
        Category::class => CategoryScope::class,
        Menu::class => MenuScope::class,
        Order::class => OrderScope::class,
    ];

    protected array $morphMap = [
        'categories' => Category::class,
        'ingredients' => Ingredient::class,
        'mealtimes' => Mealtime::class,
        'menu_categories' => MenuCategory::class,
        'menu_item_option_values' => MenuItemOptionValue::class,
        'menu_option_values' => MenuOptionValue::class,
        'menu_options' => MenuOption::class,
        'menus' => Menu::class,
        'menus_specials' => MenuSpecial::class,
        'orders' => Order::class,
        'stocks' => Stock::class,
        'stock_history' => StockHistory::class,
    ];

    public array $singletons = [
        CartConditionManager::class,
        CartManager::class,
        OrderManager::class,
    ];

    protected $subscribe = [
        OrderPerTimeslotLimitReached::class,
    ];

    #[Override]
    public function register(): void
    {
        parent::register();

        $this->mergeConfigFrom(__DIR__.'/../config/cart.php', 'igniter-cart');

        $this->registerCart();
        $this->registerSystemSettings();
        $this->registerCheckoutForm();

        AliasLoader::getInstance()->alias('Cart', Facades\Cart::class);
    }

    #[Override]
    public function boot(): void
    {
        $this->registerMiddlewares();

        $this->bindCartEvents();
        $this->bindCheckoutEvents();
        $this->bindOrderStatusEvent();

        LocationModel::implement(LocationAction::class);

        Customers::extendFormFields(new AddsCustomerOrdersTabFields);

        resolve(ExtendDashboardCards::class)->registerCards();
        resolve(ExtendDashboardCharts::class)->registerCharts();

        Event::listen('admin.controller.beforeRemap', function($controller): void {
            $controller->addJs('igniter.cart::/js/status-workflow.js', 'status-workflow');
        });
    }

    public function registerCartConditions(): array
    {
        return [
            PaymentFee::class => [
                'name' => 'paymentFee',
                'label' => 'lang:igniter.cart::default.text_payment_fee',
                'description' => 'lang:igniter.cart::default.help_payment_fee',
            ],
            Tax::class => [
                'name' => 'tax',
                'label' => 'lang:igniter.cart::default.text_vat',
                'description' => 'lang:igniter.cart::default.help_tax_condition',
            ],
            Tip::class => [
                'name' => 'tip',
                'label' => 'lang:igniter.cart::default.text_tip',
                'description' => 'lang:igniter.cart::default.help_tip_condition',
            ],
        ];
    }

    public function registerAutomationRules(): array
    {
        return [
            'events' => [
                'admin.order.paymentProcessed' => OrderPlaced::class,
                'igniter.cart.orderStatusAdded' => NewOrderStatus::class,
                'igniter.cart.orderAssigned' => OrderAssigned::class,
            ],
            'actions' => [],
            'conditions' => [
                OrderAttribute::class,
                OrderStatusAttribute::class,
            ],
        ];
    }

    #[Override]
    public function registerPermissions(): array
    {
        return [
            'Admin.Allergens' => [
                'label' => 'igniter.cart::default.text_permission_ingredients',
                'group' => 'igniter.cart::default.text_permission_menu_group',
            ],
            'Admin.Categories' => [
                'label' => 'igniter.cart::default.text_permission_categories',
                'group' => 'igniter.cart::default.text_permission_menu_group',
            ],
            'Admin.Menus' => [
                'label' => 'igniter.cart::default.text_permission_menus',
                'group' => 'igniter.cart::default.text_permission_menu_group',
            ],
            'Admin.Mealtimes' => [
                'label' => 'igniter.cart::default.text_permission_mealtimes',
                'group' => 'igniter.cart::default.text_permission_menu_group',
            ],
            'Admin.Inventory' => [
                'label' => 'igniter.cart::default.text_permission_inventory',
                'group' => 'igniter.cart::default.text_permission_menu_group',
            ],
            'Admin.Orders' => [
                'label' => 'igniter.cart::default.text_permission_orders',
                'group' => 'igniter.cart::default.text_permission_order_group',
            ],
            'Admin.DeleteOrders' => [
                'label' => 'igniter.cart::default.text_permission_delete_orders',
                'group' => 'igniter.cart::default.text_permission_order_group',
            ],
            'Admin.AssignOrders' => [
                'label' => 'igniter.cart::default.text_permission_assign_orders',
                'group' => 'igniter.cart::default.text_permission_order_group',
            ],
            'Module.CartModule' => [
                'description' => 'Manage cart extension settings',
                'group' => 'igniter.cart::default.text_permission_order_group',
            ],
        ];
    }

    #[Override]
    public function registerSettings(): array
    {
        return [
            'settings' => [
                'priority' => 1,
                'label' => 'Cart Settings',
                'description' => 'Manage cart conditions and tipping settings.',
                'icon' => 'fa fa-cart-shopping',
                'model' => CartSettings::class,
                'permissions' => ['Module.CartModule'],
            ],
        ];
    }

    #[Override]
    public function registerMailTemplates(): array
    {
        return [
            'igniter.cart::mail.order' => 'lang:igniter.cart::default.text_mail_order',
            'igniter.cart::mail.order_alert' => 'lang:igniter.cart::default.text_mail_order_alert',
            'igniter.cart::mail.order_update' => 'lang:igniter.cart::default.text_mail_order_update',
            'igniter.cart::mail.low_stock_alert' => 'lang:igniter.cart::default.text_mail_low_stock_alert',
        ];
    }

    #[Override]
    public function registerNavigation(): array
    {
        return [
            'orders' => [
                'priority' => 10,
                'class' => 'orders',
                'icon' => 'fa-file-invoice-dollar',
                'href' => admin_url('orders'),
                'title' => lang('igniter.cart::default.text_side_menu_order'),
                'permission' => 'Admin.Orders',
            ],
            'restaurant' => [
                'child' => [
                    'menus' => [
                        'priority' => 20,
                        'class' => 'menus',
                        'href' => admin_url('menus'),
                        'title' => lang('igniter.cart::default.text_side_menu_menu'),
                        'permission' => 'Admin.Menus',
                    ],
                    'mealtimes' => [
                        'priority' => 40,
                        'class' => 'mealtimes',
                        'href' => admin_url('mealtimes'),
                        'title' => lang('igniter.cart::default.text_side_menu_mealtimes'),
                        'permission' => 'Admin.Mealtimes',
                    ],
                    'inventory' => [
                        'priority' => 45,
                        'class' => 'inventory',
                        'href' => admin_url('inventory'),
                        'title' => lang('igniter.cart::default.text_side_menu_inventory'),
                        'permission' => 'Admin.Inventory',
                    ],
                ],
            ],
        ];
    }

    #[Override]
    public function registerFormWidgets(): array
    {
        return [
            StockEditor::class => [
                'label' => 'Stock Editor',
                'code' => 'stockeditor',
            ],
        ];
    }

    public function registerOrderTypes(): array
    {
        return [
            Delivery::class => [
                'code' => LocationModel::DELIVERY,
                'name' => 'lang:igniter.local::default.text_delivery',
            ],
            Collection::class => [
                'code' => LocationModel::COLLECTION,
                'name' => 'lang:igniter.local::default.text_collection',
            ],
        ];
    }

    public function registerLocationSettings(): array
    {
        return [
            'checkout' => [
                'label' => 'igniter.cart::default.settings.text_tab_checkout',
                'description' => 'igniter.cart::default.settings.text_tab_desc_checkout',
                'icon' => 'fa fa-sliders',
                'priority' => 0,
                'form' => 'igniter.cart::/models/checkoutsettings',
                'request' => CheckoutSettingsRequest::class,
            ],
            'delivery' => [
                'label' => 'igniter.cart::default.settings.text_tab_delivery',
                'description' => 'igniter.cart::default.settings.text_tab_desc_delivery',
                'icon' => 'fa fa-sliders',
                'priority' => 0,
                'form' => 'igniter.cart::/models/deliverysettings',
                'request' => DeliverySettingsRequest::class,
            ],
            'collection' => [
                'label' => 'igniter.cart::default.settings.text_tab_collection',
                'description' => 'igniter.cart::default.settings.text_tab_desc_collection',
                'icon' => 'fa fa-sliders',
                'priority' => 0,
                'form' => 'igniter.cart::/models/collectionsettings',
                'request' => CollectionSettingsRequest::class,
            ],
        ];
    }

    public function registerEventBroadcasts(): array
    {
        return [
            'admin.order.paymentProcessed' => BroadcastOrderPlacedEvent::class,
        ];
    }

    public function registerListActionWidgets(): array
    {
        return [
            UpdateStock::class => ['code' => 'out_of_stock'],
        ];
    }

    #[Override]
    public function registerSchedule(Schedule $schedule): void
    {
        $schedule->call(function(): void {
            Stock::whereExpiredOverrides()->update([
                'out_of_stock_type' => null,
                'out_of_stock_until' => null,
            ]);
        })->name('cart-clear-expired-stock-overrides')
            ->withoutOverlapping(5)
            ->everyFiveMinutes();
    }

    protected function bindCartEvents()
    {
        Event::listen('igniter.user.login', function(): void {
            if (CartSettings::instance()->get('abandoned_cart') && Facades\Cart::content()->isEmpty()) {
                Facades\Cart::restore(Auth::getId());
            }
        });

        Event::listen('igniter.user.logout', function(): void {
            if (CartSettings::instance()->get('destroy_on_logout')) {
                Facades\Cart::destroy();
            }
        });
    }

    protected function bindCheckoutEvents()
    {
        Event::listen('payregister.paypalexpress.extendFields', function($payment, array &$fields, $order, $data): void {
            if ($tax = $order->getOrderTotals()->firstWhere('code', 'tax')) {
                $fields['purchase_units'][0]['amount']['breakdown']['tax_total'] = [
                    'currency_code' => $fields['purchase_units'][0]['amount']['currency_code'],
                    'value' => number_format($tax->value, 2, '.', ''),
                ];
            }
        });

        Event::listen('admin.order.paymentProcessed', function(Order $model): void {
            OrderCreatedNotification::make()->subject($model)->broadcast();

            $model->mailSend('igniter.cart::mail.order', 'customer');
            $model->mailSend('igniter.cart::mail.order_alert', 'location');
            $model->mailSend('igniter.cart::mail.order_alert', 'admin');
        });

        Event::listen('admin.order.beforePaymentProcessed', function(Order $model): void {
            $model->subtractStock();
        });

        Event::listen('igniter.cart.orderStatusAdded', function(Order $model, $statusHistory): void {
            if ($statusHistory->notify) {
                $model->reloadRelations();
                $model->mailSend('igniter.cart::mail.order_update', 'customer');
            }
        });
    }

    protected function bindOrderStatusEvent()
    {
        Event::listen('admin.statusHistory.beforeAddStatus', function($statusHistory, $order, $statusId, $previousStatus): void {
            if ($order instanceof Order) {
                Event::dispatch('igniter.cart.beforeAddOrderStatus', [$statusHistory, $order, $statusId, $previousStatus], true);
            }
        });

        Event::listen('admin.statusHistory.added', function($order, $statusHistory): void {
            if ($order instanceof Order) {
                Event::dispatch('igniter.cart.orderStatusAdded', [$order, $statusHistory], true);
            }
        });

        Event::listen('admin.assignable.assigned', function($order, $assignableLog): void {
            if ($order instanceof Order) {
                Event::dispatch('igniter.cart.orderAssigned', [$order, $assignableLog], true);
            }
        });
    }

    protected function registerCart(): void
    {
        $this->app->singleton('cart', function(Application $app): Cart {
            $this->app['config']->set('igniter-cart.model', Models\Cart::class);
            $this->app['config']->set('igniter-cart.abandonedCart', CartSettings::get('abandoned_cart'));
            $this->app['config']->set('igniter-cart.destroyOnLogout', CartSettings::get('destroy_on_logout'));

            $this->app['events']->dispatch('cart.beforeRegister', [$this]);

            $instance = new Cart($app['session'], $app['events']);

            $this->app['events']->dispatch('cart.afterRegister', [$instance, $this]);

            return $instance;
        });
    }

    protected function registerSystemSettings()
    {
        Settings::registerCallback(function(Settings $manager): void {
            $manager->registerSettingItems('core', [
                'order' => [
                    'label' => 'lang:igniter.cart::default.text_tab_order',
                    'description' => 'lang:igniter.cart::default.text_tab_desc_order',
                    'icon' => 'fa fa-file-invoice',
                    'priority' => 1,
                    'permission' => ['Site.Settings'],
                    'url' => admin_url('settings/edit/order'),
                    'form' => 'igniter.cart::/models/ordersettings',
                    'request' => OrderSettingsRequest::class,
                ],
            ]);
        });
    }

    protected function registerCheckoutForm(): void
    {
        $this->app->singleton(CheckoutForm::class);
    }

    protected function registerMiddlewares(): void
    {
        if (Igniter::runningInAdmin()) {
            $this->app['router']->pushMiddlewareToGroup('igniter', InjectStatusWorkflow::class);
        } else {
            $this->app['router']->pushMiddlewareToGroup('igniter', CartMiddleware::class);
        }
    }

    public function registerOnboardingSteps(): array
    {
        return [
            'igniter.cart::menus' => [
                'label' => 'igniter.cart::default.dashboard.text_onboarding_menus',
                'description' => 'igniter.cart::default.dashboard.help_onboarding_menus',
                'icon' => 'fa-cutlery',
                'url' => admin_url('menus'),
                'priority' => 30,
                'complete' => Menu::onboardingIsComplete(...),
            ],
        ];
    }
}

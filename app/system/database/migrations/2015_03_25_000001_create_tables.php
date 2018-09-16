<?php namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * Create the initial tables:
 *    activities, addresses, banners, categories, countries, coupons, coupons_history,
 *  currencies, customers, customers_activity, customer_groups, extensions,
 *  languages, layouts, layout_modules, layout_routes, locations, location_tables,
 *  mail_templates, mail_templates_data, menus, menus_specials,
 *  menu_options, options, options_values, menu_options, messages, message_recipients, orders,
 *  orders, order_menus, order_options, order_totals, pages, permalinks,
 *  pp_payments, permissions, reservations, reviews, security_questions, settings,
 *  staffs, staff_groups, statuses, status_history, tables, uri_routes,
 *  users, working_hours
 */
class CreateTables extends Migration
{
    public function up()
    {
        foreach (get_class_methods(__CLASS__) as $method) {
            if (!starts_with($method, ['_create_']))
                continue;

            $table = substr($method, 8);
            if (Schema::hasTable($table))
                continue;

            Schema::create($table, $this->$method());
        }
    }

    public function down()
    {
        foreach (get_class_methods(__CLASS__) as $method) {
            if (!starts_with($method, ['_create_']))
                continue;

            $table = substr($method, 8);
            Schema::dropIfExists($table);
        }
    }

    protected function _create_activities()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('activity_id', TRUE);
            $table->string('domain', 10);
            $table->string('context', 128);
            $table->string('user', 10);
            $table->integer('user_id');
            $table->string('action', 32);
            $table->text('message');
            $table->boolean('status');
            $table->dateTime('date_added');
        };
    }

    protected function _create_addresses()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('address_id');
            $table->integer('customer_id');
            $table->string('address_1', 128);
            $table->string('address_2', 128);
            $table->string('city', 128);
            $table->string('state', 128);
            $table->string('postcode', 10);
            $table->integer('country_id');
        };
    }

    protected function _create_banners()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('banner_id');
            $table->string('name');
            $table->char('type', 8);
            $table->string('click_url');
            $table->integer('language_id');
            $table->string('alt_text');
            $table->text('image_code');
            $table->text('custom_code');
            $table->boolean('status');
        };
    }

    protected function _create_categories()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('category_id');
            $table->string('name', 32);
            $table->text('description');
            $table->integer('parent_id');
            $table->integer('priority');
            $table->string('image');
            $table->boolean('status')->default(1);
        };
    }

    protected function _create_countries()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('country_id');
            $table->string('country_name', 128);
            $table->string('iso_code_2', 2);
            $table->string('iso_code_3', 3);
            $table->text('format');
            $table->boolean('status');
            $table->string('flag');
        };
    }

    protected function _create_coupons()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('coupon_id');
            $table->string('name');
            $table->string('code', 15)->unique('code');
            $table->char('type', 1);
            $table->decimal('discount', 15, 4)->nullable();
            $table->decimal('min_total', 15, 4)->nullable();
            $table->integer('redemptions')->default(0);
            $table->integer('customer_redemptions')->default(0);
            $table->text('description');
            $table->boolean('status');
            $table->date('date_added');
            $table->char('validity', 15);
            $table->date('fixed_date')->nullable();
            $table->time('fixed_from_time')->nullable();
            $table->time('fixed_to_time')->nullable();
            $table->date('period_start_date')->nullable();
            $table->date('period_end_date')->nullable();
            $table->string('recurring_every', 35);
            $table->time('recurring_from_time')->nullable();
            $table->time('recurring_to_time')->nullable();
            $table->boolean('order_restriction');
        };
    }

    protected function _create_coupons_history()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('coupon_history_id');
            $table->integer('coupon_id');
            $table->integer('order_id');
            $table->integer('customer_id');
            $table->string('code', 15);
            $table->decimal('min_total', 15, 4)->nullable();
            $table->decimal('amount', 15, 4)->nullable();
            $table->dateTime('date_used');
            $table->boolean('status');
        };
    }

    protected function _create_currencies()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('currency_id');
            $table->integer('country_id');
            $table->string('currency_name', 32);
            $table->string('currency_code', 3);
            $table->string('currency_symbol', 3);
            $table->decimal('currency_rate', 15, 8);
            $table->boolean('symbol_position');
            $table->char('thousand_sign', 1);
            $table->char('decimal_sign', 1);
            $table->char('decimal_position', 1);
            $table->string('iso_alpha2', 2);
            $table->string('iso_alpha3', 3);
            $table->integer('iso_numeric');
            $table->string('flag', 6);
            $table->integer('currency_status');
            $table->dateTime('date_modified');
        };
    }

    protected function _create_customer_groups()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('customer_group_id');
            $table->string('group_name', 32);
            $table->text('description');
            $table->boolean('approval');
        };
    }

    protected function _create_customers()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('customer_id');
            $table->string('first_name', 32);
            $table->string('last_name', 32);
            $table->string('email', 96)->unique();
            $table->string('password', 40);
            $table->string('salt', 9);
            $table->string('telephone', 32);
            $table->integer('address_id');
            $table->integer('security_question_id');
            $table->string('security_answer', 32);
            $table->boolean('newsletter');
            $table->integer('customer_group_id');
            $table->string('ip_address', 40);
            $table->dateTime('date_added');
            $table->boolean('status');
            $table->text('cart');
        };
    }

    protected function _create_customers_online()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('activity_id', TRUE);
            $table->integer('customer_id');
            $table->string('access_type', 128);
            $table->string('browser', 128);
            $table->string('ip_address', 40);
            $table->string('country_code', 2);
            $table->text('request_uri');
            $table->text('referrer_uri');
            $table->dateTime('date_added');
            $table->boolean('status');
            $table->text('user_agent');
        };
    }

    protected function _create_extensions()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('extension_id');
            $table->string('type', 32);
            $table->string('name', 128);
            $table->text('data');
            $table->boolean('serialized');
            $table->boolean('status');
            $table->string('title');
            $table->string('version', 11)->default('1.0.0');
            $table->unique(['type', 'name'], 'type');
        };
    }

    protected function _create_languages()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('language_id', TRUE);
            $table->string('code', 7);
            $table->string('name', 32);
            $table->string('image', 32);
            $table->string('idiom', 32);
            $table->boolean('status');
            $table->boolean('can_delete');
        };
    }

    protected function _create_layout_routes()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('layout_route_id');
            $table->integer('layout_id');
            $table->string('uri_route', 128);
        };
    }

    protected function _create_layout_modules()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('layout_module_id', TRUE);
            $table->integer('layout_id');
            $table->string('module_code', 128);
            $table->string('partial', 32);
            $table->integer('priority');
            $table->text('options');
            $table->boolean('status');
        };
    }

    protected function _create_layouts()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('layout_id');
            $table->string('name', 45);
        };
    }

    protected function _create_location_tables()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('location_id');
            $table->integer('table_id');
            $table->primary(['location_id', 'table_id']);
        };
    }

    protected function _create_locations()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('location_id');
            $table->string('location_name', 32);
            $table->string('location_email', 96);
            $table->text('description');
            $table->string('location_address_1', 128);
            $table->string('location_address_2', 128);
            $table->string('location_city', 128);
            $table->string('location_state', 128);
            $table->string('location_postcode', 10);
            $table->integer('location_country_id');
            $table->string('location_telephone', 32);
            $table->float('location_lat', 10, 6);
            $table->float('location_lng', 10, 6);
            $table->integer('location_radius');
            $table->boolean('offer_delivery');
            $table->boolean('offer_collection');
            $table->integer('delivery_time');
            $table->integer('last_order_time');
            $table->integer('reservation_time_interval');
            $table->integer('reservation_stay_time');
            $table->boolean('location_status');
            $table->integer('collection_time');
            $table->text('options');
            $table->string('location_image');
        };
    }

    protected function _create_mail_templates()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('template_id', TRUE);
            $table->string('name', 32);
            $table->integer('language_id');
            $table->dateTime('date_added');
            $table->dateTime('date_updated');
            $table->boolean('status');
        };
    }

    protected function _create_mail_templates_data()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('template_data_id', TRUE);
            $table->integer('template_id');
            $table->string('code', 32);
            $table->string('subject', 128);
            $table->text('body');
            $table->dateTime('date_added');
            $table->dateTime('date_updated');
            $table->unique(['template_id', 'code']);
        };
    }

    protected function _create_mealtimes()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('mealtime_id', TRUE);
            $table->string('mealtime_name', 128);
            $table->time('start_time')->default('00:00:00');
            $table->time('end_time')->default('23:59:59');
            $table->boolean('mealtime_status');
        };
    }

    protected function _create_menus()
    {
        return function (Blueprint $table) {
            $table->integer('menu_id', TRUE);
            $table->string('menu_name');
            $table->text('menu_description');
            $table->decimal('menu_price', 15, 4);
            $table->string('menu_photo');
            $table->integer('menu_category_id');
            $table->integer('stock_qty');
            $table->integer('minimum_qty');
            $table->boolean('subtract_stock');
            $table->integer('mealtime_id');
            $table->boolean('menu_status');
            $table->integer('menu_priority');
        };
    }

    public function _create_options()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('option_id', TRUE);
            $table->string('option_name', 32);
            $table->string('display_type', 15);
            $table->integer('priority');
        };
    }

    public function _create_option_values()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('option_value_id', TRUE);
            $table->integer('option_id');
            $table->string('value', 128);
            $table->decimal('price', 15, 4)->nullable();
            $table->integer('priority');
        };
    }

    protected function _create_menu_options()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('menu_option_id', TRUE);
            $table->integer('option_id');
            $table->integer('menu_id');
            $table->boolean('required');
            $table->boolean('default_value_id');
            $table->text('option_values');
        };
    }

    public function _create_menu_option_values()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('menu_option_value_id', TRUE);
            $table->integer('menu_option_id');
            $table->integer('menu_id');
            $table->integer('option_id');
            $table->integer('option_value_id');
            $table->decimal('new_price', 15, 4)->nullable();
            $table->integer('quantity');
            $table->boolean('subtract_stock');
        };
    }

    protected function _create_menus_specials()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('special_id', TRUE);
            $table->integer('menu_id')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('special_price', 15, 4)->nullable();
            $table->boolean('special_status');
            $table->unique(['special_id', 'menu_id']);
        };
    }

    protected function _create_messages()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('message_id', TRUE);
            $table->integer('sender_id');
            $table->dateTime('date_added');
            $table->string('send_type', 32);
            $table->string('recipient', 32);
            $table->text('subject');
            $table->text('body');
            $table->boolean('status');
        };
    }

    protected function _create_message_meta()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('message_meta_id', TRUE);
            $table->integer('message_id');
            $table->boolean('state');
            $table->boolean('status');
            $table->boolean('deleted');
            $table->string('item', 32);
            $table->text('value');
        };
    }

    protected function _create_orders()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('order_id', TRUE);
            $table->integer('customer_id');
            $table->string('first_name', 32);
            $table->string('last_name', 32);
            $table->string('email', 96);
            $table->string('telephone', 32);
            $table->integer('location_id');
            $table->integer('address_id');
            $table->text('cart');
            $table->integer('total_items');
            $table->text('comment');
            $table->string('payment', 35);
            $table->string('order_type', 32);
            $table->dateTime('date_added');
            $table->date('date_modified');
            $table->time('order_time');
            $table->date('order_date');
            $table->decimal('order_total', 15, 4)->nullable();
            $table->integer('status_id');
            $table->string('ip_address', 40);
            $table->string('user_agent');
            $table->boolean('notify');
            $table->integer('assignee_id');
            $table->integer('invoice_no');
            $table->string('invoice_prefix', 32);
            $table->dateTime('invoice_date');
        };
    }

    protected function _create_order_menus()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('order_menu_id', TRUE);
            $table->integer('order_id');
            $table->integer('menu_id');
            $table->string('name');
            $table->integer('quantity');
            $table->decimal('price', 15, 4)->nullable();
            $table->decimal('subtotal', 15, 4)->nullable();
            $table->text('option_values');
            $table->text('comment');
        };
    }

    protected function _create_order_options()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('order_option_id', TRUE);
            $table->integer('order_id');
            $table->integer('menu_id');
            $table->string('order_option_name', 128);
            $table->decimal('order_option_price', 15, 4)->nullable();
            $table->integer('order_menu_id');
            $table->integer('order_menu_option_id');
            $table->integer('menu_option_value_id');
        };
    }

    protected function _create_order_totals()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('order_total_id', TRUE);
            $table->integer('order_id');
            $table->string('code', 30);
            $table->string('title');
            $table->decimal('value', 15);
            $table->boolean('priority');
//            $table->primary(['order_total_id', 'order_id']); will be dropped later, added here for reference only
        };
    }

    protected function _create_pages()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('page_id', TRUE);
            $table->integer('language_id');
            $table->string('name', 32);
            $table->string('title');
            $table->string('heading');
            $table->text('content');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->integer('layout_id');
            $table->text('navigation');
            $table->dateTime('date_added');
            $table->dateTime('date_updated');
            $table->boolean('status');
        };
    }

    protected function _create_permalinks()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('permalink_id', TRUE);
            $table->string('slug');
            $table->string('controller');
            $table->string('query');
            $table->index('slug', 'controller'); // was unique
        };
    }

    protected function _create_pp_payments()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('transaction_id', 19)->primary();
            $table->integer('order_id');
            $table->integer('customer_id');
            $table->text('serialized');
        };
    }

    protected function _create_permissions()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('permission_id', TRUE);
            $table->string('name', 128);
            $table->string('description');
            $table->text('action');
            $table->boolean('status');
        };
    }

    protected function _create_reservations()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('reservation_id', TRUE);
            $table->integer('location_id');
            $table->integer('table_id');
            $table->integer('guest_num');
            $table->integer('occasion_id');
            $table->integer('customer_id');
            $table->string('first_name', 45);
            $table->string('last_name', 45);
            $table->string('email', 96);
            $table->string('telephone', 45);
            $table->text('comment');
            $table->time('reserve_time');
            $table->date('reserve_date');
            $table->date('date_added');
            $table->date('date_modified');
            $table->integer('assignee_id');
            $table->boolean('notify');
            $table->string('ip_address', 40);
            $table->string('user_agent');
            $table->boolean('status');
            $table->index(['location_id', 'table_id']);  // was unique
        };
    }

    protected function _create_reviews()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('review_id', TRUE);
            $table->integer('customer_id');
            $table->integer('sale_id');
            $table->string('sale_type', 32)->default('');
            $table->string('author', 32);
            $table->integer('location_id');
            $table->integer('quality');
            $table->integer('delivery');
            $table->integer('service');
            $table->text('review_text');
            $table->dateTime('date_added');
            $table->boolean('review_status');
            $table->index(['review_id', 'sale_type', 'sale_id']);  // was unique
        };
    }

    protected function _create_security_questions()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('question_id', TRUE);
            $table->text('text');
            $table->boolean('priority');
        };
    }

    protected function _create_settings()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('setting_id', TRUE);
            $table->string('sort', 45);
            $table->string('item', 128);
            $table->text('value');
            $table->boolean('serialized');
            $table->unique(['sort', 'item']);
        };
    }

    protected function _create_staff_groups()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('staff_group_id', TRUE);
            $table->string('staff_group_name', 32);
            $table->boolean('customer_account_access');
            $table->boolean('location_access');
            $table->text('permissions');
        };
    }

    protected function _create_staffs()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('staff_id', TRUE);
            $table->string('staff_name', 32);
            $table->string('staff_email', 96)->unique('staff_email');
            $table->integer('staff_group_id');
            $table->integer('staff_location_id');
            $table->string('timezone', 32);
            $table->integer('language_id');
            $table->date('date_added');
            $table->boolean('staff_status');
        };
    }

    protected function _create_status_history()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('status_history_id', TRUE);
            $table->integer('object_id');
            $table->integer('staff_id');
            $table->integer('assignee_id');
            $table->integer('status_id');
            $table->boolean('notify');
            $table->string('status_for', 32);
            $table->text('comment');
            $table->dateTime('date_added');
        };
    }

    protected function _create_statuses()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('status_id', TRUE);
            $table->string('status_name', 45);
            $table->text('status_comment');
            $table->boolean('notify_customer');
            $table->string('status_for', 10);
            $table->string('status_color', 32);
        };
    }

    protected function _create_tables()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('table_id', TRUE);
            $table->string('table_name', 32);
            $table->integer('min_capacity');
            $table->integer('max_capacity');
            $table->boolean('table_status');
        };
    }

    protected function _create_uri_routes()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('uri_route_id', TRUE);
            $table->string('uri_route');
            $table->string('controller', 128);
            $table->boolean('priority');
            $table->index('uri_route_id', 'uri_route');  // was unique
        };
    }

    protected function _create_users()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('user_id', TRUE);
            $table->integer('staff_id')->unique();
            $table->string('username', 32)->unique();
            $table->string('password', 40);
            $table->string('salt', 9);
        };
    }

    protected function _create_working_hours()
    {
        return function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('location_id');
            $table->integer('weekday');
            $table->time('opening_time')->default('00:00:00');
            $table->time('closing_time')->default('00:00:00');
            $table->boolean('status');
            $table->string('type', 32);
            $table->index(['location_id', 'weekday', 'type']);  // was unique
        };
    }
}
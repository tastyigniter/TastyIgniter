<?php namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * Fix nullable and other constraints on columns
 * VARCHAR(32/128) => VARCHAR(255)
 */
class OptimizeTablesColumns extends Migration
{
    public function up()
    {
        foreach (get_class_methods(__CLASS__) as $method) {
            if (!starts_with($method, ['_optimize_']))
                continue;

            $table = substr($method, 10);
            Schema::table($table, $this->$method());
        }
    }

    public function down()
    {
        //
    }

    protected function _optimize_activities()
    {
        return function (Blueprint $table) {
            $table->string('domain', 10)->nullable()->change();
            $table->string('context', 128)->nullable()->change();
            $table->string('user', 10)->nullable()->change();
            $table->integer('user_id')->nullable()->change();
            $table->string('action', 32)->nullable()->change();
            $table->boolean('status')->nullable()->change();
        };
    }

    protected function _optimize_addresses()
    {
        return function (Blueprint $table) {
            $table->string('address_1')->change();
            $table->string('address_2')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('postcode')->nullable()->change();
        };
    }

    protected function _optimize_banners()
    {
        return function (Blueprint $table) {
            $table->string('click_url')->nullable()->change();
            $table->string('alt_text')->nullable()->change();
            $table->text('image_code')->nullable()->change();
            $table->text('custom_code')->nullable()->change();
        };
    }

    protected function _optimize_categories()
    {
        return function (Blueprint $table) {
            $table->string('name')->change();
            $table->text('description')->nullable()->change();
            $table->integer('parent_id')->nullable()->change();
            $table->integer('priority')->default(0)->change();
            $table->string('image')->nullable()->change();
        };
    }

    protected function _optimize_coupons()
    {
        return function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->boolean('status')->nullable()->change();
            $table->string('validity', 15)->nullable()->change();
            $table->string('recurring_every', 35)->nullable()->change();
        };
    }

    protected function _optimize_countries()
    {
        return function (Blueprint $table) {
            $table->string('country_name')->change();
            $table->string('iso_code_2', 2)->nullable()->change();
            $table->string('iso_code_3', 3)->nullable()->change();
            $table->text('format')->nullable()->change();
            $table->boolean('status')->default(0)->change();
        };
    }

    protected function _optimize_currencies()
    {
        return function (Blueprint $table) {
            $table->string('currency_name')->change();
            $table->boolean('symbol_position')->nullable()->change();
            $table->string('iso_alpha2', 2)->nullable()->change();
            $table->string('iso_alpha3', 3)->nullable()->change();
            $table->integer('iso_numeric')->nullable()->change();
            $table->string('flag')->nullable()->change();
            $table->integer('currency_status')->nullable()->change();
            $table->dateTime('date_modified')->nullable()->change();
        };
    }

    protected function _optimize_customers()
    {
        return function (Blueprint $table) {
            $table->string('first_name')->change();
            $table->string('last_name')->change();
            $table->string('telephone', 32)->nullable()->change();
            $table->integer('address_id')->nullable()->change();
            $table->integer('security_question_id')->nullable()->change();
            $table->string('security_answer', 32)->nullable()->change();
            $table->boolean('newsletter')->nullable()->change();
            $table->string('ip_address', 40)->nullable()->change();
            $table->text('cart')->nullable()->change();
        };
    }

    protected function _optimize_customer_groups()
    {
        return function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        };
    }

    protected function _optimize_customers_online()
    {
        return function (Blueprint $table) {
            $table->string('access_type')->nullable()->change();
            $table->string('browser')->nullable()->change();
            $table->string('ip_address', 40)->nullable()->change();
            $table->string('country_code')->nullable()->change();
            $table->text('request_uri')->nullable()->change();
            $table->text('referrer_uri')->nullable()->change();
            $table->boolean('status')->default(0)->change();
            $table->text('user_agent')->nullable()->change();
        };
    }

    protected function _optimize_extensions()
    {
        return function (Blueprint $table) {
            $table->text('data')->nullable()->change();
            $table->boolean('serialized')->default(1)->change();
            $table->boolean('status')->default(0)->change();
        };
    }

    protected function _optimize_languages()
    {
        return function (Blueprint $table) {
            $table->string('code', 32)->change();
            $table->string('name')->change();
            $table->string('image')->nullable()->change();
            $table->string('idiom')->change();
        };
    }

    protected function _optimize_layouts()
    {
        return function (Blueprint $table) {
            $table->string('name')->change();
        };
    }

    protected function _optimize_layout_modules()
    {
        return function (Blueprint $table) {
            $table->string('module_code')->change();
            $table->string('partial')->nullable()->change();
            $table->integer('priority')->default(0)->change();
            $table->text('options')->nullable()->change();
        };
    }

    protected function _optimize_locations()
    {
        return function (Blueprint $table) {
            $table->string('location_name')->change();
            $table->text('description')->nullable()->change();
            $table->text('location_telephone')->nullable()->change();
            $table->string('location_address_1')->nullable()->change();
            $table->string('location_address_2')->nullable()->change();
            $table->string('location_city')->nullable()->change();
            $table->string('location_state')->nullable()->change();
            $table->string('location_postcode', 10)->nullable()->change();
            $table->integer('location_country_id')->nullable()->change();
            $table->integer('location_radius')->nullable()->change();
            $table->string('location_image')->nullable()->change();
            $table->float('location_lat', 10, 6)->nullable()->change();
            $table->float('location_lng', 10, 6)->nullable()->change();
            $table->boolean('offer_delivery')->nullable()->change();
            $table->boolean('offer_collection')->nullable()->change();
            $table->integer('delivery_time')->nullable()->change();
            $table->integer('last_order_time')->nullable()->change();
            $table->integer('reservation_time_interval')->nullable()->change();
            $table->integer('reservation_stay_time')->nullable()->change();
            $table->boolean('location_status')->nullable()->change();
            $table->integer('collection_time')->nullable()->change();
            $table->text('options')->nullable()->change();
            $table->string('location_image')->nullable()->change();
        };
    }

    protected function _optimize_mail_templates()
    {
        return function (Blueprint $table) {
            $table->string('name')->change();
        };
    }

    protected function _optimize_mail_templates_data()
    {
        return function (Blueprint $table) {
            $table->string('code', 128)->change();
            $table->string('subject')->change();
        };
    }

    protected function _optimize_mealtimes()
    {
        return function (Blueprint $table) {
            $table->string('mealtime_name')->change();
        };
    }

    protected function _optimize_menus()
    {
        return function (Blueprint $table) {
            $table->string('menu_photo')->nullable()->change();
            $table->integer('stock_qty')->default(0)->change();
            $table->integer('minimum_qty')->default(0)->change();
            $table->boolean('subtract_stock')->nullable()->change();
            $table->integer('mealtime_id')->nullable()->change();
            $table->integer('menu_priority')->default(0)->change();
        };
    }

    protected function _optimize_options()
    {
        return function (Blueprint $table) {
            $table->string('option_name')->change();
            $table->string('display_type')->change();
            $table->integer('priority')->default(0)->change();
        };
    }

    protected function _optimize_option_values()
    {
        return function (Blueprint $table) {
            $table->string('value')->change();
            $table->integer('priority')->default(0)->change();
        };
    }

    protected function _optimize_menu_option_values()
    {
        return function (Blueprint $table) {
            $table->integer('quantity')->default(0)->change();
            $table->boolean('subtract_stock')->nullable()->change();
        };
    }

    protected function _optimize_menus_specials()
    {
        return function (Blueprint $table) {
            $table->date('start_date')->nullable()->change();
            $table->date('end_date')->nullable()->change();
        };
    }

    protected function _optimize_messages()
    {
        return function (Blueprint $table) {
            $table->string('send_type')->change();
            $table->string('recipient')->change();
        };
    }

    protected function _optimize_orders()
    {
        return function (Blueprint $table) {
            $table->integer('customer_id')->nullable()->change();
            $table->string('first_name')->change();
            $table->string('last_name')->change();
            $table->string('telephone')->change();
            $table->integer('address_id')->nullable()->change();
            $table->text('comment')->nullable()->change();
            $table->string('payment')->change();
            $table->string('order_type')->change();
            $table->boolean('notify')->nullable()->change();
            $table->integer('assignee_id')->nullable()->change();
            $table->integer('invoice_no')->nullable()->change();
            $table->string('invoice_prefix')->nullable()->change();
            $table->dateTime('invoice_date')->nullable()->change();
            $table->dateTime('date_modified')->change();
        };
    }

    protected function _optimize_order_menus()
    {
        return function (Blueprint $table) {
            $table->text('option_values')->nullable()->change();
            $table->text('comment')->nullable()->change();
        };
    }

    protected function _optimize_order_options()
    {
        return function (Blueprint $table) {
            $table->string('order_option_name')->change();
        };
    }

    protected function _optimize_order_totals()
    {
        return function (Blueprint $table) {
            $table->string('code')->change();
            $table->decimal('value', 15, 4)->change();
            $table->boolean('priority')->default(0)->change();
        };
    }

    protected function _optimize_pages()
    {
        return function (Blueprint $table) {
            $table->string('name')->change();
            $table->string('heading')->nullable()->change();
            $table->string('meta_description')->nullable()->change();
            $table->string('meta_keywords')->nullable()->change();
            $table->integer('layout_id')->nullable()->change();
            $table->text('navigation')->nullable()->change();
        };
    }

    protected function _optimize_permissions()
    {
        return function (Blueprint $table) {
            $table->string('name')->change();
        };
    }

    protected function _optimize_reservations()
    {
        return function (Blueprint $table) {
            $table->integer('occasion_id')->nullable()->change();
            $table->integer('customer_id')->nullable()->change();
            $table->string('first_name')->change();
            $table->string('last_name')->change();
            $table->string('telephone')->change();
            $table->text('comment')->nullable()->change();
            $table->integer('assignee_id')->nullable()->change();
            $table->boolean('notify')->nullable()->change();
        };
    }

    protected function _optimize_reviews()
    {
        return function (Blueprint $table) {
            $table->integer('customer_id')->nullable()->change();
//            $table->integer('sale_id')->nullable()->change(); @todo remove index before change
//            $table->string('sale_type')->nullable()->change();
            $table->string('author')->nullable()->change();
            $table->text('review_text')->nullable()->change();
        };
    }

    protected function _optimize_settings()
    {
        return function (Blueprint $table) {
            $table->text('value')->nullable()->change();
            $table->boolean('serialized')->nullable()->change();
        };
    }

    protected function _optimize_staffs()
    {
        return function (Blueprint $table) {
            $table->string('staff_name')->change();
            $table->string('timezone')->nullable()->change();
            $table->integer('language_id')->nullable()->change();
        };
    }

    protected function _optimize_status_history()
    {
        return function (Blueprint $table) {
            $table->string('status_for')->change();
            $table->integer('staff_id')->nullable()->change();
            $table->integer('assignee_id')->nullable()->change();
            $table->boolean('notify')->nullable()->change();
            $table->text('comment')->nullable()->change();
        };
    }

    protected function _optimize_statuses()
    {
        return function (Blueprint $table) {
            $table->string('status_name')->change();
            $table->text('status_comment')->nullable()->change();
            $table->boolean('notify_customer')->nullable()->change();
            $table->string('status_for')->change();
            $table->string('status_color')->change();
        };
    }

    protected function _optimize_tables()
    {
        return function (Blueprint $table) {
            $table->string('table_name')->change();
        };
    }
}
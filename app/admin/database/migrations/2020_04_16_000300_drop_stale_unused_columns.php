<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropStaleUnusedColumns extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('invoice_no');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('menu_category_id');
        });

        Schema::rename('menu_options', 'menu_item_options');
        Schema::rename('menu_option_values', 'menu_item_option_values');
        Schema::rename('options', 'menu_options');
        Schema::rename('option_values', 'menu_option_values');
        Schema::rename('order_options', 'order_menu_options');

        Schema::table('payment_logs', function (Blueprint $table) {
            $table->renameColumn('status', 'is_success');
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_item_options');
        Schema::dropIfExists('menu_item_option_values');
        Schema::dropIfExists('order_menu_options');
    }
}

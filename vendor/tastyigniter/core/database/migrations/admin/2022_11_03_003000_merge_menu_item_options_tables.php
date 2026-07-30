<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('menu_option_values', function(Blueprint $table) {
            $table->renameColumn('value', 'name');
        });

        Schema::table('menu_item_options', function(Blueprint $table) {
            $table->renameColumn('required', 'is_required');
        });

        Schema::table('menu_item_option_values', function(Blueprint $table) {
            $table->renameColumn('new_price', 'override_price');
        });

        Schema::table('menu_options', function(Blueprint $table) {
            $table->dropColumn('update_related_menu_item');
        });

        Schema::table('order_menu_options', function(Blueprint $table) {
            $table->dropColumn('menu_id');
            $table->renameColumn('order_menu_option_id', 'menu_option_id');
        });
    }

    public function down() {}
};

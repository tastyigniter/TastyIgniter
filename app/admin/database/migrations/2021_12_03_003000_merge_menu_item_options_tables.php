<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MergeMenuItemOptionsTables extends Migration
{
    protected static $menuItemOptionsCache = [];

    public function up()
    {
        Schema::table('menu_options', function (Blueprint $table) {
            $table->integer('max_selected')->default(0)->after('display_type');
            $table->integer('min_selected')->default(0)->after('display_type');
            $table->boolean('is_required')->default(0)->after('display_type');
        });

        $this->copyFieldsFromMenuItemOptionsToMenuOptions();

        Schema::table('menu_item_option_values', function (Blueprint $table) {
            $table->unsignedBigInteger('option_id')->nullable()->after('menu_option_value_id');
            $table->unsignedBigInteger('menu_id')->nullable()->after('menu_option_value_id');
        });

        $this->updateMenuIdAndOptionIdInMenuItemOptionValues();

        Schema::table('order_menu_options', function (Blueprint $table) {
            $table->unsignedBigInteger('option_id')->nullable()->after('menu_id');
        });

        $this->updateOrderMenuOptionsOptionIdColumn();

        Schema::table('menu_item_option_values', function (Blueprint $table) {
            $table->dropColumn('menu_option_id');
        });

        Schema::table('order_menu_options', function (Blueprint $table) {
            $table->dropColumn('order_menu_option_id');
        });

        Schema::dropIfExists('menu_item_options');
    }

    public function down()
    {
        Schema::table('menu_options', function (Blueprint $table) {
            $table->dropColumn('is_required');
            $table->dropColumn('min_selected');
            $table->dropColumn('max_selected');
        });

        Schema::table('menu_item_option_values', function (Blueprint $table) {
            $table->dropColumn('option_id');
            $table->dropColumn('menu_id');
        });
    }

    protected function copyFieldsFromMenuItemOptionsToMenuOptions(): void
    {
        $updatedOptions = [];
        DB::table('menu_item_options')->get()->each(function ($model) use (&$updatedOptions) {
            if (in_array($model->option_id, $updatedOptions))
                return TRUE;

            DB::table('menu_options')
                ->where('option_id', $model->option_id)
                ->update([
                    'is_required' => $model->required,
                    'min_selected' => $model->min_selected,
                    'max_selected' => $model->max_selected,
                ]);

            $updatedOptions[] = $model->option_id;
        });
    }

    protected function updateMenuIdAndOptionIdInMenuItemOptionValues(): void
    {
        DB::table('menu_item_option_values')->get()->each(function ($model) {
            $menuItemOption = $this->findMenuItemOption($model->menu_option_id);

            DB::table('menu_item_option_values')
                ->where('menu_option_value_id', $model->menu_option_value_id)
                ->update([
                    'menu_id' => $menuItemOption->menu_id,
                    'option_id' => $menuItemOption->option_id,
                ]);
        });
    }

    protected function updateOrderMenuOptionsOptionIdColumn(): void
    {
        DB::table('order_menu_options')->get()->each(function ($model) {
            $menuItemOption = $this->findMenuItemOption($model->order_menu_option_id);

            DB::table('order_menu_options')
                ->where('order_option_id', $model->order_option_id)
                ->update([
                    'option_id' => $menuItemOption->option_id,
                ]);
        });
    }

    protected function findMenuItemOption($menuOptionId)
    {
        if (array_key_exists($menuOptionId, self::$menuItemOptionsCache))
            return self::$menuItemOptionsCache[$menuOptionId];

        $result = DB::table('menu_item_options')
            ->where('menu_option_id', $menuOptionId)
            ->first();

        return self::$menuItemOptionsCache[$menuOptionId] = $result;
    }
}

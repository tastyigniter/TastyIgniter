<?php

namespace Admin\Database\Migrations;

use Admin\Models\Stocks_model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('stockable_id');
            $table->string('stockable_type');
            $table->bigInteger('quantity')->nullable();
            $table->boolean('low_stock_alert')->default(0);
            $table->integer('low_stock_threshold')->default(0);
            $table->boolean('is_tracked')->default(0);
            $table->timestamps();
        });

        Schema::create('stock_history', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('stock_id');
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('state');
            $table->bigInteger('quantity');
            $table->timestamps();

            $table->foreign('stock_id')->references('id')->on('stocks')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('order_id')->references('order_id')->on('orders')->cascadeOnDelete()->cascadeOnUpdate();
        });

        $this->copyStockQtyFromMenus();

        $this->copyStockQtyFromMenuOptions();

        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('stock_qty');
            $table->dropColumn('subtract_stock');
        });

        Schema::table('menu_item_option_values', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropColumn('subtract_stock');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_history');
        Schema::dropIfExists('stocks');
    }

    protected function copyStockQtyFromMenus()
    {
        DB::table('menus')->get()->each(function ($menuItem) {
            if ($menuItem->stock_qty == 0)
                return true;

            $locationIds = DB::table('locationables')
                ->where('locationable_type', 'menus')
                ->where('locationable_id', $menuItem->menu_id)
                ->pluck('location_id')->all() ?: [params('default_location_id')];

            foreach ($locationIds as $locationId) {
                $stockId = DB::table('stocks')->insertGetId([
                    'location_id' => $locationId,
                    'stockable_id' => $menuItem->menu_id,
                    'stockable_type' => 'menus',
                    'quantity' => $menuItem->stock_qty,
                    'is_tracked' => (bool)$menuItem->subtract_stock,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ]);

                DB::table('stock_history')->insert([
                    'stock_id' => $stockId,
                    'state' => Stocks_model::STATE_IN_STOCK,
                    'quantity' => $menuItem->stock_qty,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ]);
            }
        });
    }

    protected function copyStockQtyFromMenuOptions()
    {
        DB::table('menu_item_option_values')->get()->each(function ($optionValue) {
            if ($optionValue->quantity == 0)
                return true;

            $menuOption = DB::table('menu_item_options')
                ->where('menu_option_id', $optionValue->menu_option_id)
                ->first();

            $locationIds = DB::table('locationables')
                ->where('locationable_type', 'menu_options')
                ->where('locationable_id', $menuOption->option_id)
                ->pluck('location_id')->all() ?: [params('default_location_id')];

            foreach ($locationIds as $locationId) {
                DB::table('stocks')->insert([
                    'location_id' => $locationId,
                    'stockable_id' => $optionValue->option_value_id,
                    'stockable_type' => 'menu_option_values',
                    'quantity' => $optionValue->quantity,
                    'is_tracked' => (bool)$optionValue->subtract_stock,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ]);
            }
        });
    }
}

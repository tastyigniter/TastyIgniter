<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterOrderTypeColumns extends Migration
{
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->text('order_restriction')->nullable()->change();
        });

        $this->updateOrderRestrictionColumn();
    }

    public function down()
    {
    }

    protected function updateOrderRestrictionColumn()
    {
        DB::table('menus')->get()->each(function ($model) {
            $restriction = null;
            if ($model->order_restriction) {
                $restriction[] = array_get([
                    1 => 'delivery',
                    2 => 'collection',
                ], $model->order_restriction);

                $restriction = json_encode($restriction);
            }

            DB::table('menus')
                ->where('menu_id', $model->menu_id)
                ->update(['order_restriction' => $restriction]);
        });
    }
}

<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponRelationsTable extends Migration
{
    public function up()
    {
        Schema::create('coupon_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('coupon_id')->unsigned()->index();
            $table->integer('category_id')->unsigned()->index();
            $table->unique(['coupon_id', 'category_id']);
        });

        Schema::create('coupon_menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('coupon_id')->unsigned()->index();
            $table->integer('menu_id')->unsigned()->index();
            $table->unique(['coupon_id', 'menu_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupon_categories');
        Schema::dropIfExists('coupon_menus');
    }
}

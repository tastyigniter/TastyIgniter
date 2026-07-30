<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('igniter_coupon_categories')) {
            return;
        }

        Schema::create('igniter_coupon_categories', function(Blueprint $table): void {
            $table->engine = 'InnoDB';
            $table->integer('coupon_id')->unsigned()->index('coupon_id_index');
            $table->integer('category_id')->unsigned()->index('category_id_index');
            $table->unique(['coupon_id', 'category_id'], 'coupon_category_unique');
        });

        Schema::create('igniter_coupon_menus', function(Blueprint $table): void {
            $table->engine = 'InnoDB';
            $table->integer('coupon_id')->unsigned()->index('coupon_id_index');
            $table->integer('menu_id')->unsigned()->index('menu_id_index');
            $table->unique(['coupon_id', 'menu_id'], 'coupon_menu_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('igniter_coupon_categories');
        Schema::dropIfExists('igniter_coupon_menus');
    }
};

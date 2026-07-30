<?php

declare(strict_types=1);

namespace Igniter\Coupons\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('igniter_coupons', function(Blueprint $table): void {
            $table->integer('min_menu_quantity')->default(0)->after('apply_coupon_on');
        });
    }
};

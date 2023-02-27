<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryCommentOrdersTable extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('orders', 'delivery_comment'))
            return;

        Schema::table('orders', function (Blueprint $table) {
            $table->text('delivery_comment')->nullable();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('delivery_comment');
        });
    }
}

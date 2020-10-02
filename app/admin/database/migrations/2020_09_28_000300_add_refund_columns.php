<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefundColumns extends Migration
{
    public function up()
    {
        Schema::table('payment_logs', function (Blueprint $table) {
            $table->boolean('is_refundable')->default(false);
            $table->dateTime('refunded_at');
        });
    }
}

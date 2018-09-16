<?php namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * Create payments and payment_logs table and fill with records from extension data
 */
class CreatePaymentsAndPaymentLogsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('payment_id', TRUE);
            $table->string('name');
            $table->string('code', 128)->unique();
            $table->text('class_name');
            $table->text('description')->nullable();
            $table->text('data')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('is_default')->default(0);
            $table->integer('priority')->default(0);
            $table->dateTime('date_added')->nullable();
            $table->dateTime('date_updated')->nullable();
        });

        Schema::create('payment_logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('payment_log_id', TRUE);
            $table->integer('order_id');
            $table->string('payment_name', 128);
            $table->string('message');
            $table->text('request')->nullable();
            $table->text('response')->nullable();
            $table->boolean('status')->default(0);
            $table->dateTime('date_added')->nullable();
            $table->dateTime('date_updated')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('payment_logs');
    }
}
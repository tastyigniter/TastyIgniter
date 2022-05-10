<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('payment_profiles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('payment_profile_id');
            $table->integer('customer_id')->unsigned()->nullable()->index();
            $table->integer('payment_id')->unsigned()->nullable()->index();
            $table->string('card_brand')->nullable();
            $table->string('card_last4')->nullable();
            $table->text('profile_data')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_profiles');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * customer_id can be NULL on addresses table
 */
return new class extends Migration
{
    public function up()
    {
        Schema::table('addresses', function(Blueprint $table) {
            $table->integer('customer_id')->nullable()->change();
        });
    }

    public function down()
    {
        //
    }
};

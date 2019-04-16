<?php namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * customer_id can be NULL on addresses table
 */
class NullifyCustomerIdOnAddressesTable extends Migration
{
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->integer('customer_id')->nullable()->change();
        });
    }

    public function down()
    {
        //
    }
}
<?php namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * customer_id can be NULL on addresses table
 */
class deleteUnusedColumnsFromActivitiesTable extends Migration
{
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('domain');
            $table->dropColumn('context');
            $table->dropColumn('user');
            $table->dropColumn('action');
            $table->dropColumn('message');
            $table->dropColumn('status');

            $table->string('type')->nullable();
            $table->dateTime('read_at')->nullable();
            $table->softDeletes();
        });

        \System\Models\Activities_model::truncate();
    }

    public function down()
    {
        //
    }
}
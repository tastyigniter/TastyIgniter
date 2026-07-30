<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create copy of working_hours table
        Schema::create('working_hours_new', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id');
            $table->string('type', 32);
            $table->integer('weekday');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        // Copy data from old table to new table
        DB::table('working_hours_new')->insert(
            DB::table('working_hours')->get()->toArray(),
        );

        // Drop the old table
        Schema::dropIfExists('working_hours');

        // Rename the new table to the original table's name
        Schema::rename('working_hours_new', 'working_hours');
    }

    public function down() {}
};

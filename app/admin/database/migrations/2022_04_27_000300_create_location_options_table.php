<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLocationOptionsTable extends Migration
{
    public function up()
    {
        Schema::create('location_options', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id');
            $table->string('item');
            $table->json('value')->nullable();
        });

        $this->copyOptionsToLocationOptionsTable();

        Schema::dropColumns('locations', ['options']);
    }

    public function down()
    {
        Schema::dropIfExists('location_options');
    }

    protected function copyOptionsToLocationOptionsTable()
    {
        DB::table('locations')->get()->each(function ($location) {
            if (empty($location->options))
                return true;

            $options = json_decode($location->options, true);

            foreach ($options as $item => $value) {
                DB::table('location_options')->insert([
                    'location_id' => $location->location_id,
                    'item' => $item,
                    'value' => json_encode($value),
                ]);
            }
        });
    }
}

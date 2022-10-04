<?php

namespace Admin\Database\Migrations;

use Admin\Models\DiningTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDiningAreasSectionsTablesAddColumnsTable extends Migration
{
    public static $diningTables;

    public function up()
    {
        Schema::create('dining_areas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->longText('floor_plan')->nullable();
            $table->timestamps();
        });

        Schema::create('dining_sections', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id')->index();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('color')->nullable();
            $table->integer('priority')->default(0);
            $table->boolean('is_enabled')->default(0);
            $table->timestamps();
        });

        $this->createLocationDiningAreas();

        Schema::create('dining_tables', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dining_area_id')->index();
            $table->unsignedBigInteger('dining_section_id')->nullable()->index();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->string('name');
            $table->string('shape')->nullable();
            $table->integer('min_capacity')->default(0);
            $table->integer('max_capacity')->default(0);
            $table->integer('extra_capacity')->default(0);
            $table->boolean('is_combo')->default(0);
            $table->boolean('is_enabled')->default(0);
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('priority')->default(0);
            $table->timestamps();
        });

        $this->copyTablesIntoDiningTables();

        if (!Schema::hasColumn('reservation_tables', 'dining_table_id')) {
            Schema::table('reservation_tables', function (Blueprint $table) {
                $table->unsignedBigInteger('dining_section_id')->nullable()->after('reservation_id');
                $table->unsignedBigInteger('dining_area_id')->nullable()->after('reservation_id');
                $table->unsignedBigInteger('dining_table_id')->after('reservation_id');
            });
        }

        $this->setDiningTableIdOnReservationTables();

        DiningTable::fixTree();
    }

    public function down()
    {
        Schema::dropIfExists('dining_sections');
        Schema::dropIfExists('dining_tables');
        Schema::dropIfExists('dining_areas');
    }

    protected function createLocationDiningAreas()
    {
        if (!DB::table('tables')->count())
            return;

        DB::table('locations')->get()->each(function ($location) {
            DB::table('dining_areas')->insertGetId([
                'name' => 'Default',
                'location_id' => $location->location_id,
                'created_at' => $location->created_at,
                'updated_at' => $location->updated_at,
            ]);
        });
    }

    protected function copyTablesIntoDiningTables()
    {
        if (!DB::table('tables')->count())
            return;

        $diningAreas = DB::table('dining_areas')->pluck('id', 'location_id');

        DB::table('tables')->get()->each(function ($table) use ($diningAreas) {
            DB::table('locationables')
                ->where('locationable_type', 'tables')
                ->where('locationable_id', $table->table_id)
                ->get()->each(function ($locationable) use ($diningAreas, $table) {
                    $diningTableId = DB::table('dining_tables')->insertGetId([
                        'dining_area_id' => $diningAreaId = array_get($diningAreas, $locationable->location_id),
                        'name' => $table->table_name,
                        'shape' => 'rectangle',
                        'min_capacity' => $table->min_capacity,
                        'max_capacity' => $table->max_capacity,
                        'extra_capacity' => $table->extra_capacity,
                        'is_enabled' => $table->table_status,
                        'priority' => (int)$table->priority,
                        'created_at' => $table->created_at,
                        'updated_at' => $table->updated_at,
                    ]);

                    self::$diningTables[$diningTableId] = [
                        'table_id' => $table->table_id,
                        'location_id' => $locationable->location_id,
                        'dining_table_id' => $diningTableId,
                        'dining_area_id' => $diningAreaId,
                    ];
                });
        });
    }

    protected function setDiningTableIdOnReservationTables()
    {
        DB::table('reservation_tables')
            ->join('reservations', 'reservation_tables.reservation_id', '=', 'reservations.reservation_id')
            ->select('reservation_tables.reservation_id', 'reservation_tables.table_id', 'reservations.location_id')
            ->get()->each(function ($reservationTable) {
                if (!$diningTable = $this->findDiningTable($reservationTable))
                    return;

                DB::table('reservation_tables')
                    ->where('reservation_id', $reservationTable->reservation_id)
                    ->where('table_id', $reservationTable->table_id)
                    ->update([
                        'dining_table_id' => array_get($diningTable, 'dining_table_id'),
                        'dining_area_id' => array_get($diningTable, 'dining_area_id'),
                    ]);
            });
    }

    protected function findDiningTable($reservationTable)
    {
        return collect(self::$diningTables)->first(function ($diningTable) use ($reservationTable) {
            return $diningTable['table_id'] == $reservationTable->table_id
                && $diningTable['location_id'] == $reservationTable->location_id;
        });
    }
}

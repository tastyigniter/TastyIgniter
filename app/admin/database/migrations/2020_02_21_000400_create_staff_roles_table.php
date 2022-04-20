<?php

namespace Admin\Database\Migrations;

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStaffRolesTable extends Migration
{
    public function up()
    {
        Schema::create('staff_roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('staff_role_id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->text('permissions')->nullable();
            $table->timestamps();
        });

        DB::table('staff_groups')->get()->each(function ($model) {
            if (!empty($model->permissions)) {
                DB::table('staff_roles')->insert([
                    'name' => $model->staff_group_name,
                    'permissions' => $model->permissions,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }
        });

        Schema::table('staffs', function (Blueprint $table) {
            $table->tinyInteger('sale_permission')->default(1)->nullable();
            $table->renameColumn('staff_group_id', 'staff_role_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('staff_roles');
    }
}

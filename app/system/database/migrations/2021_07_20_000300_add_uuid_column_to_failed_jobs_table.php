<?php

namespace System\Database\Migrations;

use Igniter\Flame\Support\Str;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddUuidColumnToFailedJobsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('failed_jobs'))
            return;

        Schema::table('failed_jobs', function (Blueprint $table) {
            $table->string('uuid')->after('id')->nullable()->unique();
        });

        DB::table('failed_jobs')->whereNull('uuid')->cursor()->each(function ($job) {
            DB::table('failed_jobs')
                ->where('id', $job->id)
                ->update(['uuid' => (string)Str::uuid()]);
        });
    }

    public function down()
    {
        //
    }
}

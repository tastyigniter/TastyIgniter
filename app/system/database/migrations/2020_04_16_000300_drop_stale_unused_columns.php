<?php namespace System\Database\Migrations;

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Schema;

class DropStaleUnusedColumns extends Migration
{
    public function up()
    {
        Schema::rename('mail_templates', 'mail_layouts');
        Schema::rename('mail_templates_data', 'mail_templates');

        Schema::table('mail_layouts', function (Blueprint $table) {
            $table->renameColumn('template_id', 'layout_id');
        });

        Schema::table('mail_templates', function (Blueprint $table) {
            $table->renameColumn('template_id', 'layout_id');
            $table->renameColumn('template_data_id', 'template_id');
        });

        $this->copyRecordsFromExtensionsToThemes();

        $this->copyRecordsFromExtensionsToPayments();

        DB::table('extensions')->where('type', '!=', 'module')->delete();

        Schema::table('extensions', function (Blueprint $table) {
            $table->dropUnique('type');
            $table->unique('name');
            $table->dropColumn(['type', 'data', 'serialized', 'status', 'title']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('mail_templates');
        Schema::dropIfExists('mail_layouts');
    }

    protected function copyRecordsFromExtensionsToThemes()
    {
        if (DB::table('themes')->count())
            return;

        DB::table('extensions')->where('type', 'theme')->get()->each(function ($model) {
            DB::table('themes')->insert([
                'name' => $model->title,
                'code' => $model->name,
                'version' => $model->version,
                'data' => $model->data,
                'status' => $model->status,
                'is_default' => FALSE,
            ]);
        });
    }

    protected function copyRecordsFromExtensionsToPayments()
    {
        if (DB::table('payments')->count())
            return;

        DB::table('extensions')->where('type', 'payment')->get()->each(function ($model) {
            $code = str_replace(['-', '_'], '', $model->name);
            DB::table('payments')->insert([
                'name' => $model->title,
                'code' => $code,
                'class_name' => 'Igniter\\PayRegister\\Payments\\'.studly_case($model->name),
                'data' => $model->data,
                'status' => $model->status,
                'is_default' => FALSE,
                'date_added' => Carbon::now(),
                'date_updated' => Carbon::now(),
            ]);
        });
    }
}

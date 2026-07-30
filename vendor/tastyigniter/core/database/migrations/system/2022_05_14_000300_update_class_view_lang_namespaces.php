<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        foreach (['templates', 'layouts', 'partials'] as $table) {
            DB::table('mail_'.$table)
                ->where('code', 'like', 'admin::%')
                ->orWhere('code', 'like', 'main::%')
                ->orWhere('code', 'like', 'system::%')
                ->get()->each(function($record) use ($table) {
                    $key = str_singular($table).'_id';
                    DB::table('mail_'.$table)
                        ->where($key, $record->$key)
                        ->update(['code' => 'igniter.'.$record->code]);
                });
        }

        foreach (['admin', 'system', 'main'] as $module) {
            DB::table('language_translations')
                ->where('namespace', $module)
                ->get()
                ->each(function($record) use ($module) {
                    DB::table('language_translations')
                        ->where('translation_id', $record->translation_id)
                        ->update([
                            'namespace' => 'igniter',
                            'group' => $module,
                        ]);
                });
        }
    }

    public function down()
    {
        //
    }
};

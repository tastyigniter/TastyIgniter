<?php

namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakePrimaryKeyBigintAllTables extends Migration
{
    public function up()
    {
        foreach ([
            'activities' => 'activity_id',
            'countries' => 'country_id',
            'currencies' => 'currency_id',
            'extension_settings' => 'id',
            'extensions' => 'extension_id',
            'language_translations' => 'translation_id',
            'languages' => 'language_id',
            'mail_layouts' => 'layout_id',
            'mail_partials' => 'partial_id',
            'mail_templates' => 'template_id',
            'media_attachments' => 'id',
            'request_logs' => 'id',
            'settings' => 'setting_id',
            'themes' => 'theme_id',
        ] as $table => $key) {
            Schema::table($table, function (Blueprint $table) use ($key) {
                $table->unsignedBigInteger($key, TRUE)->change();
            });
        }
    }

    public function down()
    {
    }
}

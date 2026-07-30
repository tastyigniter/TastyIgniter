<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected const TABLES = [
        'locations', 'countries', 'currencies', 'customer_groups', 'languages',
    ];

    public function up()
    {
        foreach (self::TABLES as $table) {
            if (!Schema::hasColumn($table, 'is_default')) {
                Schema::table($table, function(Blueprint $table) {
                    $table->boolean('is_default')->default(0);
                });
            }
        }
    }
};

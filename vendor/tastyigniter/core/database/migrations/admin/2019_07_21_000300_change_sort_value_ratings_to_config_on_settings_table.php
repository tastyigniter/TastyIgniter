<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::table('settings')
            ->where('sort', 'ratings')
            ->update(['sort' => 'config']);

        DB::table('menus_specials')
            ->update([
                'type' => 'F',
                'validity' => 'period',
            ]);
    }

    public function down() {}
};

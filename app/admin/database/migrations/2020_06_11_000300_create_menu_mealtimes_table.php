<?php namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use DB;

/**
 *
 */
class CreateMenuMealtimesTable extends Migration
{
    public function up()
    {
        Schema::create('menu_mealtimes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('menu_id')->unsigned()->index();
            $table->integer('mealtime_id')->unsigned()->index();
            $table->unique(['menu_id', 'mealtime_id']);
        });
        
        $menus = DB::table('menus')->select('menu_id', 'mealtime_id')->get();
        $migrate = [];
        foreach ($menus as $menu) {
            if (!is_null($menu->mealtime_id)) {
		        $migrate[] = [
			        'mealtime_id' => $menu->mealtime_id,
			        'menu_id' => $menu->menu_id
		        ];
            }
        }
        
        if (count($migrate) > 0)
            DB::table('menu_mealtimes')->insert($migrate);      
        	  
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('mealtime_id');
        });           
    }

    public function down()
    {
        Schema::dropIfExists('menu_mealtimes');
    }
}
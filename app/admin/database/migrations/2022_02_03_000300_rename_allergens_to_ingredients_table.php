<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RenameAllergensToIngredientsTable extends Migration
{
    public function up()
    {
        Schema::rename('allergens', 'ingredients');
        Schema::rename('allergenables', 'ingredientables');

        Schema::table('ingredients', function (Blueprint $table) {
            $table->renameColumn('allergen_id', 'ingredient_id');
            $table->boolean('is_allergen')->default(0);
        });

        Schema::table('ingredientables', function (Blueprint $table) {
            $table->dropUnique('allergenable_unique');

            $table->renameColumn('allergen_id', 'ingredient_id');
            $table->renameColumn('allergenable_type', 'ingredientable_type');
            $table->renameColumn('allergenable_id', 'ingredientable_id');
            $table->unique(['ingredient_id', 'ingredientable_id', 'ingredientable_type'], 'ingredientable_unique');
        });

        DB::table('ingredients')->update(['is_allergen' => TRUE]);
    }

    public function down()
    {
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('ingredientables');
    }
}

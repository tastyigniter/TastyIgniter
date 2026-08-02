<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Recovery for the documented MySQL partial-DDL failure: CREATE TABLE may
        // commit before an implicitly named ALTER INDEX fails. Never accept a
        // different shape and never replace migration history with hasTable().
        if (Schema::hasTable('naxas_restaurant_ops_staff_preferences')) {
            foreach (['id', 'staff_id', 'default_location_id', 'created_at', 'updated_at'] as $column) {
                if (! Schema::hasColumn('naxas_restaurant_ops_staff_preferences', $column)) {
                    throw new RuntimeException('Unsafe partial RestaurantOps staff preferences table: missing '.$column);
                }
            }

            Schema::table('naxas_restaurant_ops_staff_preferences', function (Blueprint $table): void {
                if (! Schema::hasIndex('naxas_restaurant_ops_staff_preferences', ['staff_id'], 'unique')) {
                    $table->unique('staff_id', 'rops_staff_pref_staff_uq');
                }
                if (! Schema::hasIndex('naxas_restaurant_ops_staff_preferences', ['default_location_id'])) {
                    $table->index('default_location_id', 'rops_staff_pref_loc_idx');
                }
            });

            return;
        }

        Schema::create('naxas_restaurant_ops_staff_preferences', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id')->unique('rops_staff_pref_staff_uq');
            $table->unsignedBigInteger('default_location_id')->nullable();
            $table->timestamps();
            $table->index('default_location_id', 'rops_staff_pref_loc_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('naxas_restaurant_ops_staff_preferences');
    }
};

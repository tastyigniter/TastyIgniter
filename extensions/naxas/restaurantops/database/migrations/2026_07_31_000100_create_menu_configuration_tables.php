<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('naxas_restaurant_ops_menu_item_metadata', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('menu_id');
            $table->string('kitchen_name')->nullable();
            $table->unsignedSmallInteger('preparation_minutes')->nullable();
            $table->unsignedBigInteger('kitchen_station_id')->nullable();
            $table->boolean('storefront_visible')->default(true);
            $table->boolean('pos_visible')->default(true);
            $table->boolean('waiter_visible')->default(true);
            $table->boolean('show_on_kitchen')->default(true);
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();
            $table->unique('menu_id', 'naxas_ops_item_meta_menu_unique');
            $table->index(['menu_id', 'kitchen_station_id']);
        });

        Schema::create('naxas_restaurant_ops_item_variants', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('menu_id');
            $table->string('code', 64);
            $table->string('name');
            $table->string('kitchen_name')->nullable();
            $table->string('sku', 128)->nullable();
            $table->string('barcode', 128)->nullable();
            $table->string('price_mode', 16)->default('adjustment');
            $table->decimal('price_value', 15, 4)->default(0);
            $table->decimal('cost', 15, 4)->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('display_order')->default(0);
            $table->unsignedSmallInteger('preparation_minutes')->nullable();
            $table->unsignedBigInteger('tax_class_id')->nullable();
            $table->string('stock_status', 32)->nullable();
            $table->unsignedBigInteger('kitchen_station_id')->nullable();
            $table->boolean('storefront_visible')->default(true);
            $table->boolean('pos_visible')->default(true);
            $table->boolean('online_visible')->default(true);
            $table->boolean('delivery_visible')->default(true);
            $table->boolean('collection_visible')->default(true);
            $table->boolean('dine_in_visible')->default(true);
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();
            $table->softDeletes('archived_at');
            $table->unique(['menu_id', 'code'], 'naxas_ops_variant_code_unique');
            $table->index(['menu_id', 'is_active', 'display_order']);
        });
        Schema::create('naxas_restaurant_ops_modifier_groups', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('option_id')->nullable();
            $table->string('code', 64)->unique();
            $table->string('name');
            $table->string('kitchen_name')->nullable();
            $table->text('description')->nullable();
            $table->string('selection_type', 16)->default('multiple');
            $table->boolean('is_required')->default(false);
            $table->unsignedSmallInteger('min_selections')->default(0);
            $table->unsignedSmallInteger('max_selections')->nullable();
            $table->unsignedSmallInteger('free_quantity')->default(0);
            $table->boolean('allow_quantity')->default(false);
            $table->unsignedSmallInteger('max_quantity_per_modifier')->default(1);
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('auto_open')->default(false);
            $table->boolean('show_on_receipt')->default(true);
            $table->boolean('show_on_kitchen')->default(true);
            $table->boolean('storefront_visible')->default(true);
            $table->boolean('pos_visible')->default(true);
            $table->boolean('delivery_visible')->default(true);
            $table->boolean('collection_visible')->default(true);
            $table->boolean('dine_in_visible')->default(true);
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();
            $table->softDeletes('archived_at');
            $table->unique('option_id', 'naxas_ops_group_option_unique');
            $table->index(['is_active', 'display_order']);
        });
        Schema::create('naxas_restaurant_ops_modifier_metadata', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('option_value_id');
            $table->string('code', 64);
            $table->string('kitchen_name')->nullable();
            $table->decimal('price_adjustment', 15, 4)->nullable();
            $table->unsignedSmallInteger('min_quantity')->default(0);
            $table->unsignedSmallInteger('max_quantity')->default(1);
            $table->boolean('allow_quantity')->default(false);
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_sold_out')->default(false);
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('storefront_visible')->default(true);
            $table->boolean('pos_visible')->default(true);
            $table->boolean('kitchen_visible')->default(true);
            $table->boolean('receipt_visible')->default(true);
            $table->unsignedBigInteger('kitchen_station_id')->nullable();
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();
            $table->softDeletes('archived_at');
            $table->unique('option_value_id', 'naxas_ops_modifier_value_unique');
            $table->unique('code', 'naxas_ops_modifier_code_unique');
            $table->index(['is_active', 'is_sold_out']);
        });
        Schema::create('naxas_restaurant_ops_menu_modifier_groups', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->unsignedBigInteger('modifier_group_id');
            $table->boolean('required_override')->nullable();
            $table->unsignedSmallInteger('min_override')->nullable();
            $table->unsignedSmallInteger('max_override')->nullable();
            $table->unsignedSmallInteger('free_quantity_override')->nullable();
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('variant_id', 'naxas_ops_attach_variant_fk')->references('id')->on('naxas_restaurant_ops_item_variants')->restrictOnDelete();
            $table->foreign('modifier_group_id', 'naxas_ops_attach_group_fk')->references('id')->on('naxas_restaurant_ops_modifier_groups')->restrictOnDelete();
            $table->unique(['menu_id', 'variant_id', 'modifier_group_id'], 'naxas_ops_menu_variant_group_unique');
            $table->index(['menu_id', 'variant_id', 'display_order'], 'naxas_ops_menu_group_lookup');
        });
        Schema::create('naxas_restaurant_ops_availability_overrides', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->unsignedBigInteger('modifier_group_id')->nullable();
            $table->unsignedBigInteger('modifier_id')->nullable();
            $table->string('service_type', 16)->nullable();
            $table->string('channel', 16)->nullable();
            $table->boolean('is_available')->nullable();
            $table->boolean('is_visible')->nullable();
            $table->boolean('is_sellable')->nullable();
            $table->decimal('price_override', 15, 4)->nullable();
            $table->unsignedSmallInteger('preparation_minutes')->nullable();
            $table->unsignedBigInteger('kitchen_station_id')->nullable();
            $table->timestamp('available_from')->nullable();
            $table->timestamp('available_until')->nullable();
            $table->timestamps();
            $table->index(['location_id', 'menu_id', 'service_type', 'channel'], 'naxas_ops_override_resolution');
            $table->index(['variant_id', 'modifier_group_id', 'modifier_id'], 'naxas_ops_override_targets');
        });
        Schema::create('naxas_restaurant_ops_modifier_conditions', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_modifier_id');
            $table->unsignedBigInteger('child_group_id');
            $table->string('condition_type', 24);
            $table->boolean('expected_selected')->default(true);
            $table->timestamps();
            $table->foreign('parent_modifier_id', 'naxas_ops_condition_parent_fk')->references('id')->on('naxas_restaurant_ops_modifier_metadata')->restrictOnDelete();
            $table->foreign('child_group_id', 'naxas_ops_condition_child_fk')->references('id')->on('naxas_restaurant_ops_modifier_groups')->restrictOnDelete();
            $table->unique(['parent_modifier_id', 'child_group_id', 'condition_type'], 'naxas_ops_modifier_condition_unique');
        });
        Schema::create('naxas_restaurant_ops_combos', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('menu_id');
            $table->string('code', 64);
            $table->string('price_allocation', 24)->default('parent');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();
            $table->softDeletes('archived_at');
            $table->unique('menu_id', 'naxas_ops_combo_menu_unique');
            $table->unique('code', 'naxas_ops_combo_code_unique');
        });
        Schema::create('naxas_restaurant_ops_combo_groups', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('combo_id');
            $table->string('code', 64);
            $table->string('name');
            $table->boolean('is_required')->default(true);
            $table->unsignedSmallInteger('min_selections')->default(1);
            $table->unsignedSmallInteger('max_selections')->default(1);
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();
            $table->foreign('combo_id', 'naxas_ops_combo_group_combo_fk')->references('id')->on('naxas_restaurant_ops_combos')->restrictOnDelete();
            $table->unique(['combo_id', 'code'], 'naxas_ops_combo_group_code_unique');
        });
        Schema::create('naxas_restaurant_ops_combo_choices', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('combo_group_id');
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->boolean('is_fixed')->default(false);
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->decimal('upgrade_surcharge', 15, 4)->default(0);
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('combo_group_id', 'naxas_ops_combo_choice_group_fk')->references('id')->on('naxas_restaurant_ops_combo_groups')->restrictOnDelete();
            $table->foreign('variant_id', 'naxas_ops_combo_choice_variant_fk')->references('id')->on('naxas_restaurant_ops_item_variants')->restrictOnDelete();
            $table->unique(['combo_group_id', 'menu_id', 'variant_id'], 'naxas_ops_combo_choice_unique');
        });
        Schema::create('naxas_restaurant_ops_order_item_snapshots', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('order_menu_id');
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('service_type', 16)->nullable();
            $table->unsignedSmallInteger('schema_version')->default(1);
            $table->string('configuration_hash', 64);
            $table->json('snapshot');
            $table->decimal('total_price', 15, 4);
            $table->timestamp('created_at')->useCurrent();
            $table->unique('order_menu_id', 'naxas_ops_snapshot_order_menu_unique');
            $table->index(['order_id', 'order_menu_id']);
            $table->index(['location_id', 'created_at']);
        });
    }

    public function down(): void
    {
        foreach (['order_item_snapshots', 'combo_choices', 'combo_groups', 'combos', 'modifier_conditions', 'availability_overrides', 'menu_modifier_groups', 'modifier_metadata', 'modifier_groups', 'item_variants', 'menu_item_metadata'] as $table) {
            Schema::dropIfExists('naxas_restaurant_ops_'.$table);
        }
    }
};

<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('naxas_restaurant_ops_floors', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id');
            $table->string('name');
            $table->string('code', 64);
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unique(['location_id', 'code'], 'rops_floors_location_code_unique');
            $table->index(['location_id', 'is_active', 'sort_order'], 'rops_floors_map');
        });

        Schema::create('naxas_restaurant_ops_tables', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('floor_id');
            $table->string('name');
            $table->string('code', 64);
            $table->string('table_number', 32);
            $table->unsignedSmallInteger('capacity')->default(1);
            $table->string('shape', 24)->default('rectangle');
            $table->integer('position_x')->default(0);
            $table->integer('position_y')->default(0);
            $table->unsignedInteger('width')->default(120);
            $table->unsignedInteger('height')->default(90);
            $table->integer('rotation')->default(0);
            $table->string('status', 24)->default('available');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('floor_id', 'rops_tables_floor_fk')->references('id')->on('naxas_restaurant_ops_floors')->restrictOnDelete();
            $table->unique(['location_id', 'code'], 'rops_tables_location_code_unique');
            $table->index(['location_id', 'floor_id', 'status'], 'rops_tables_map');
            $table->index(['location_id', 'is_active'], 'rops_tables_active');
        });

        Schema::create('naxas_restaurant_ops_table_sessions', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('table_id');
            $table->unsignedBigInteger('active_table_id')->nullable();
            $table->unsignedBigInteger('pos_order_id');
            $table->unsignedBigInteger('official_order_id')->nullable();
            $table->unsignedSmallInteger('guest_count');
            $table->unsignedBigInteger('opened_by');
            $table->timestamp('opened_at');
            $table->unsignedBigInteger('closed_by')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->string('status', 24)->default('open');
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();
            $table->foreign('table_id', 'rops_sessions_table_fk')->references('id')->on('naxas_restaurant_ops_tables')->restrictOnDelete();
            $table->foreign('pos_order_id', 'rops_sessions_pos_order_fk')->references('id')->on('naxas_restaurant_ops_pos_orders')->restrictOnDelete();
            $table->unique('active_table_id', 'rops_sessions_one_active_table_unique');
            $table->index(['location_id', 'status'], 'rops_sessions_location_status');
            $table->index(['pos_order_id', 'status'], 'rops_sessions_order_status');
        });

        Schema::create('naxas_restaurant_ops_table_session_events', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('table_session_id')->nullable();
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('floor_id')->nullable();
            $table->unsignedBigInteger('table_id')->nullable();
            $table->unsignedBigInteger('pos_order_id')->nullable();
            $table->string('event_type', 64);
            $table->unsignedBigInteger('actor_id')->nullable();
            $table->json('payload')->nullable();
            $table->string('correlation_id', 100)->nullable();
            $table->timestamp('occurred_at');
            $table->timestamps();
            $table->index(['table_session_id', 'occurred_at'], 'rops_table_events_timeline');
            $table->index(['location_id', 'event_type'], 'rops_table_events_location_type');
        });

        Schema::create('naxas_restaurant_ops_table_transfers', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('table_session_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('from_table_id');
            $table->unsignedBigInteger('to_table_id');
            $table->unsignedBigInteger('pos_order_id');
            $table->unsignedBigInteger('transferred_by');
            $table->text('reason')->nullable();
            $table->timestamp('transferred_at');
            $table->timestamps();
            $table->index(['location_id', 'transferred_at'], 'rops_transfers_location_time');
        });

        Schema::create('naxas_restaurant_ops_table_merges', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('primary_table_session_id');
            $table->unsignedBigInteger('merged_table_session_id');
            $table->unsignedBigInteger('primary_table_id');
            $table->unsignedBigInteger('merged_table_id');
            $table->string('status', 24)->default('active');
            $table->unsignedBigInteger('merged_by');
            $table->timestamp('merged_at');
            $table->timestamps();
            $table->unique(['primary_table_session_id', 'merged_table_session_id'], 'rops_merges_pair_unique');
            $table->index(['location_id', 'status'], 'rops_merges_location_status');
        });

        Schema::create('naxas_restaurant_ops_bill_requests', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('table_session_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('table_id');
            $table->unsignedBigInteger('pos_order_id');
            $table->decimal('outstanding_total', 15, 4)->default(0);
            $table->string('status', 24)->default('requested');
            $table->unsignedBigInteger('requested_by');
            $table->timestamp('requested_at');
            $table->timestamps();
            $table->index(['table_session_id', 'status'], 'rops_bill_requests_session_status');
        });

        Schema::create('naxas_restaurant_ops_bill_splits', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('table_session_id');
            $table->unsignedBigInteger('pos_order_id');
            $table->string('split_number', 40);
            $table->string('allocation_type', 24);
            $table->string('status', 24)->default('open');
            $table->decimal('total', 15, 4)->default(0);
            $table->decimal('paid_total', 15, 4)->default(0);
            $table->decimal('outstanding', 15, 4)->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('closed_by')->nullable();
            $table->timestamps();
            $table->unique(['table_session_id', 'split_number'], 'rops_splits_number_unique');
            $table->index(['table_session_id', 'status'], 'rops_splits_session_status');
        });

        Schema::create('naxas_restaurant_ops_bill_split_items', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bill_split_id');
            $table->unsignedBigInteger('pos_order_item_id')->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->decimal('amount', 15, 4);
            $table->json('allocation_payload')->nullable();
            $table->timestamps();
            $table->foreign('bill_split_id', 'rops_split_items_split_fk')->references('id')->on('naxas_restaurant_ops_bill_splits')->cascadeOnDelete();
            $table->unique(['bill_split_id', 'pos_order_item_id'], 'rops_split_items_no_duplicate');
            $table->index('pos_order_item_id', 'rops_split_items_pos_item');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('naxas_restaurant_ops_bill_split_items');
        Schema::dropIfExists('naxas_restaurant_ops_bill_splits');
        Schema::dropIfExists('naxas_restaurant_ops_bill_requests');
        Schema::dropIfExists('naxas_restaurant_ops_table_merges');
        Schema::dropIfExists('naxas_restaurant_ops_table_transfers');
        Schema::dropIfExists('naxas_restaurant_ops_table_session_events');
        Schema::dropIfExists('naxas_restaurant_ops_table_sessions');
        Schema::dropIfExists('naxas_restaurant_ops_tables');
        Schema::dropIfExists('naxas_restaurant_ops_floors');
    }
};

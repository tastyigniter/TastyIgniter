<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('naxas_restaurant_ops_pos_orders', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->nullable()->unique('rops_pos_official_unique');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('cashier_id');
            $table->unsignedBigInteger('waiter_id')->nullable();
            $table->unsignedBigInteger('table_session_id')->nullable();
            $table->string('service_type', 24);
            $table->string('source', 32)->default('pos');
            $table->string('status', 24)->default('draft');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('guest_name')->nullable();
            $table->string('guest_phone', 32)->nullable();
            $table->string('guest_email')->nullable();
            $table->json('delivery_address_snapshot')->nullable();
            $table->timestamp('requested_time')->nullable();
            $table->unsignedSmallInteger('guest_count')->nullable();
            $table->text('order_note')->nullable();
            $table->text('hold_reason')->nullable();
            $table->timestamp('held_at')->nullable();
            $table->timestamp('recalled_at')->nullable();
            $table->timestamp('kitchen_ready_at')->nullable();
            $table->timestamp('payment_locked_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->decimal('subtotal', 15, 4)->default(0);
            $table->decimal('discount_total', 15, 4)->default(0);
            $table->decimal('tax_total', 15, 4)->default(0);
            $table->decimal('delivery_total', 15, 4)->default(0);
            $table->decimal('order_total', 15, 4)->default(0);
            $table->decimal('outstanding_total', 15, 4)->default(0);
            $table->string('configuration_hash', 64)->nullable();
            $table->string('pricing_hash', 64)->nullable();
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();
            $table->foreign('shift_id', 'rops_pos_shift_fk')->references('id')->on('naxas_restaurant_ops_cashier_shifts')->restrictOnDelete();
            $table->index(['location_id', 'status'], 'rops_pos_location_status');
            $table->index(['shift_id', 'status'], 'rops_pos_shift_status');
            $table->index(['cashier_id', 'status'], 'rops_pos_cashier_status');
            $table->index('created_at', 'rops_pos_created');
        });

        Schema::create('naxas_restaurant_ops_pos_order_items', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pos_order_id');
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->unsignedInteger('quantity');
            $table->text('item_note')->nullable();
            $table->json('configuration_payload');
            $table->json('pricing_payload');
            $table->string('configuration_hash', 64);
            $table->decimal('unit_total', 15, 4);
            $table->decimal('line_total', 15, 4);
            $table->string('status', 24)->default('unsent');
            $table->unsignedInteger('kitchen_sent_quantity')->default(0);
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();
            $table->foreign('pos_order_id', 'rops_pos_item_order_fk')->references('id')->on('naxas_restaurant_ops_pos_orders')->cascadeOnDelete();
            $table->index(['pos_order_id', 'status'], 'rops_pos_item_status');
            $table->index(['menu_id', 'variant_id'], 'rops_pos_item_menu_variant');
        });

        Schema::create('naxas_restaurant_ops_pos_order_events', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pos_order_id');
            $table->string('event_type', 64);
            $table->unsignedBigInteger('actor_id');
            $table->unsignedBigInteger('location_id');
            $table->json('payload')->nullable();
            $table->timestamp('occurred_at');
            $table->timestamps();
            $table->foreign('pos_order_id', 'rops_pos_event_order_fk')->references('id')->on('naxas_restaurant_ops_pos_orders')->cascadeOnDelete();
            $table->index(['pos_order_id', 'occurred_at'], 'rops_pos_event_timeline');
        });

        Schema::create('naxas_restaurant_ops_pos_approval_requests', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pos_order_id');
            $table->unsignedBigInteger('order_item_id')->nullable();
            $table->string('type', 24);
            $table->string('scope', 16)->nullable();
            $table->string('value_type', 16)->nullable();
            $table->decimal('requested_value', 15, 4)->nullable();
            $table->decimal('before_amount', 15, 4)->nullable();
            $table->decimal('discount_amount', 15, 4)->nullable();
            $table->decimal('after_amount', 15, 4)->nullable();
            $table->unsignedBigInteger('requested_by');
            $table->text('reason');
            $table->string('status', 16)->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->text('decision_reason')->nullable();
            $table->timestamp('requested_at');
            $table->timestamp('decided_at')->nullable();
            $table->timestamps();
            $table->foreign('pos_order_id', 'rops_pos_approval_order_fk')->references('id')->on('naxas_restaurant_ops_pos_orders')->cascadeOnDelete();
            $table->foreign('order_item_id', 'rops_pos_approval_item_fk')->references('id')->on('naxas_restaurant_ops_pos_order_items')->nullOnDelete();
            $table->index(['pos_order_id', 'type', 'status'], 'rops_pos_approval_state');
        });

        Schema::create('naxas_restaurant_ops_pos_idempotency_keys', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cashier_id');
            $table->string('operation', 64);
            $table->string('idempotency_key', 100);
            $table->string('request_hash', 64);
            $table->unsignedBigInteger('pos_order_id')->nullable();
            $table->json('response_payload')->nullable();
            $table->timestamps();
            $table->unique(['cashier_id', 'operation', 'idempotency_key'], 'rops_pos_idempotency_unique');
            $table->index('pos_order_id', 'rops_pos_idempotency_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('naxas_restaurant_ops_pos_idempotency_keys');
        Schema::dropIfExists('naxas_restaurant_ops_pos_approval_requests');
        Schema::dropIfExists('naxas_restaurant_ops_pos_order_events');
        Schema::dropIfExists('naxas_restaurant_ops_pos_order_items');
        Schema::dropIfExists('naxas_restaurant_ops_pos_orders');
    }
};

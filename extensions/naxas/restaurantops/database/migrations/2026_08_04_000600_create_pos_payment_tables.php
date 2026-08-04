<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('naxas_restaurant_ops_receipt_sequences', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id');
            $table->date('sequence_date');
            $table->unsignedBigInteger('next_value')->default(1);
            $table->timestamps();
            $table->unique(['location_id', 'sequence_date'], 'rops_receipt_sequence_unique');
        });
        Schema::create('naxas_restaurant_ops_pos_payments', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pos_order_id');
            $table->unsignedBigInteger('official_order_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('cashier_shift_id');
            $table->unsignedBigInteger('cashier_staff_id');
            $table->string('status', 24);
            $table->string('currency_code', 3);
            foreach (['subtotal', 'discount_total', 'tax_total', 'delivery_total', 'payable_total', 'paid_total', 'change_total', 'outstanding_before', 'outstanding_after'] as $column) {
                $table->decimal($column, 15, 4)->default(0);
            }
            $table->string('idempotency_key', 100);
            $table->string('request_hash', 64);
            $table->string('official_payment_reference')->nullable();
            $table->string('receipt_number', 64)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('reversed_at')->nullable();
            $table->text('reversal_reason')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();
            $table->foreign('pos_order_id', 'rops_payment_order_fk')->references('id')->on('naxas_restaurant_ops_pos_orders')->restrictOnDelete();
            $table->foreign('cashier_shift_id', 'rops_payment_shift_fk')->references('id')->on('naxas_restaurant_ops_cashier_shifts')->restrictOnDelete();
            $table->unique(['cashier_staff_id', 'idempotency_key'], 'rops_payment_idempotency_unique');
            $table->index(['pos_order_id', 'status'], 'rops_payment_order_status');
            $table->index(['cashier_shift_id', 'status'], 'rops_payment_shift_status');
        });
        Schema::create('naxas_restaurant_ops_pos_payment_tenders', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pos_payment_id');
            $table->string('method', 16);
            $table->string('provider_code', 64)->nullable();
            $table->string('reference', 191)->nullable();
            $table->text('note')->nullable();
            $table->decimal('amount_received', 15, 4);
            $table->decimal('amount_applied', 15, 4);
            $table->decimal('change_amount', 15, 4)->default(0);
            $table->string('status', 24);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->foreign('pos_payment_id', 'rops_tender_payment_fk')->references('id')->on('naxas_restaurant_ops_pos_payments')->restrictOnDelete();
            $table->index(['pos_payment_id', 'method'], 'rops_tender_payment_method');
        });
        Schema::create('naxas_restaurant_ops_pos_payment_events', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pos_payment_id');
            $table->string('event_type', 64);
            $table->unsignedBigInteger('actor_id');
            $table->json('payload')->nullable();
            $table->string('correlation_id', 64)->nullable();
            $table->timestamp('occurred_at');
            $table->timestamps();
            $table->foreign('pos_payment_id', 'rops_payment_event_fk')->references('id')->on('naxas_restaurant_ops_pos_payments')->restrictOnDelete();
            $table->index(['pos_payment_id', 'occurred_at'], 'rops_payment_event_timeline');
        });
        Schema::create('naxas_restaurant_ops_pos_receipts', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pos_payment_id')->unique('rops_receipt_payment_unique');
            $table->unsignedBigInteger('official_order_id');
            $table->string('receipt_number', 64)->unique('rops_receipt_number_unique');
            foreach (['location_snapshot', 'cashier_snapshot', 'customer_snapshot', 'item_snapshot', 'totals_snapshot', 'tender_snapshot', 'tax_snapshot', 'footer_snapshot'] as $column) {
                $table->json($column);
            } $table->timestamp('issued_at');
            $table->unsignedInteger('print_count')->default(0);
            $table->timestamp('last_printed_at')->nullable();
            $table->boolean('is_reversed')->default(false);
            $table->timestamps();
            $table->foreign('pos_payment_id', 'rops_receipt_payment_fk')->references('id')->on('naxas_restaurant_ops_pos_payments')->restrictOnDelete();
        });
        Schema::create('naxas_restaurant_ops_pos_payment_reversals', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pos_payment_id');
            $table->unsignedBigInteger('requested_by');
            $table->text('reason');
            $table->string('status', 24)->default('pending');
            $table->unsignedBigInteger('decided_by')->nullable();
            $table->text('decision_reason')->nullable();
            $table->timestamp('requested_at');
            $table->timestamp('decided_at')->nullable();
            $table->timestamps();
            $table->foreign('pos_payment_id', 'rops_reversal_payment_fk')->references('id')->on('naxas_restaurant_ops_pos_payments')->restrictOnDelete();
            $table->index(['pos_payment_id', 'status'], 'rops_reversal_payment_status');
        });
    }

    public function down(): void
    {
        foreach (['naxas_restaurant_ops_pos_payment_reversals', 'naxas_restaurant_ops_pos_receipts', 'naxas_restaurant_ops_pos_payment_events', 'naxas_restaurant_ops_pos_payment_tenders', 'naxas_restaurant_ops_pos_payments', 'naxas_restaurant_ops_receipt_sequences'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};

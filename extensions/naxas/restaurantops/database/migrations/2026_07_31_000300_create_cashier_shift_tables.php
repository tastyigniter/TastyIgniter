<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('naxas_restaurant_ops_cashier_shifts', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('active_staff_id')->nullable()->unique('rops_shift_active_staff_unique');
            $table->string('terminal_code', 64)->nullable();
            $table->string('status', 24);
            $table->timestamp('opened_at');
            $table->decimal('opening_cash', 15, 4);
            $table->text('opening_note')->nullable();
            $table->timestamp('closing_requested_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->unsignedBigInteger('submitted_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->timestamp('force_closed_at')->nullable();
            $table->unsignedBigInteger('force_closed_by')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->decimal('expected_cash', 15, 4)->nullable();
            $table->decimal('counted_cash', 15, 4)->nullable();
            $table->decimal('variance', 15, 4)->nullable();
            $table->unsignedInteger('submission_revision')->default(0);
            $table->string('reconciliation_hash', 64)->nullable();
            $table->text('closing_note')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('force_close_reason')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();
            $table->index(['location_id', 'status'], 'rops_shift_location_status');
            $table->index(['staff_id', 'status'], 'rops_shift_staff_status');
            $table->index('opened_at', 'rops_shift_opened');
            $table->index('submitted_at', 'rops_shift_submitted');
            $table->index('approved_at', 'rops_shift_approved');
        });

        Schema::create('naxas_restaurant_ops_cash_movements', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('location_id');
            $table->string('type', 24);
            $table->decimal('amount', 15, 4);
            $table->string('reason_code', 64);
            $table->text('reason_text')->nullable();
            $table->string('reference_type', 100)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('occurred_at');
            $table->timestamp('reversed_at')->nullable();
            $table->unsignedBigInteger('reversed_by')->nullable();
            $table->text('reversal_reason')->nullable();
            $table->string('idempotency_key', 100)->nullable();
            $table->timestamps();
            $table->foreign('shift_id', 'rops_movement_shift_fk')->references('id')->on('naxas_restaurant_ops_cashier_shifts')->cascadeOnDelete();
            $table->index(['shift_id', 'type', 'reversed_at'], 'rops_movement_summary');
            $table->index(['location_id', 'occurred_at'], 'rops_movement_location_time');
            $table->unique(['shift_id', 'idempotency_key'], 'rops_movement_idempotency');
        });

        Schema::create('naxas_restaurant_ops_shift_submissions', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedInteger('revision');
            $table->decimal('opening_cash', 15, 4);
            $table->decimal('expected_cash', 15, 4);
            $table->decimal('counted_cash', 15, 4);
            $table->decimal('variance', 15, 4);
            $table->json('payment_summary');
            $table->json('cash_movement_summary');
            $table->json('order_summary');
            $table->json('open_order_warnings')->nullable();
            $table->string('reconciliation_hash', 64);
            $table->unsignedBigInteger('submitted_by');
            $table->timestamp('submitted_at');
            $table->string('manager_decision', 16)->nullable();
            $table->unsignedBigInteger('decided_by')->nullable();
            $table->timestamp('decided_at')->nullable();
            $table->text('decision_reason')->nullable();
            $table->timestamps();
            $table->foreign('shift_id', 'rops_submission_shift_fk')->references('id')->on('naxas_restaurant_ops_cashier_shifts')->cascadeOnDelete();
            $table->unique(['shift_id', 'revision'], 'rops_submission_revision_unique');
            $table->index('submitted_at', 'rops_submission_time');
        });

        Schema::create('naxas_restaurant_ops_shift_denominations', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shift_submission_id');
            $table->decimal('denomination', 15, 4);
            $table->unsignedInteger('quantity');
            $table->decimal('total', 15, 4);
            $table->timestamps();
            $table->foreign('shift_submission_id', 'rops_denom_submission_fk')->references('id')->on('naxas_restaurant_ops_shift_submissions')->cascadeOnDelete();
            $table->unique(['shift_submission_id', 'denomination'], 'rops_denom_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('naxas_restaurant_ops_shift_denominations');
        Schema::dropIfExists('naxas_restaurant_ops_shift_submissions');
        Schema::dropIfExists('naxas_restaurant_ops_cash_movements');
        Schema::dropIfExists('naxas_restaurant_ops_cashier_shifts');
    }
};

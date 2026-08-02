<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('naxas_restaurant_ops_snapshot_failures', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('order_menu_id')->unique('rops_snapshot_failure_item_unique');
            $table->json('snapshot');
            $table->text('last_error');
            $table->unsignedSmallInteger('attempts')->default(1);
            $table->timestamp('last_attempt_at')->useCurrent();
            $table->timestamps();
            $table->index(['order_id', 'last_attempt_at'], 'rops_snapshot_failure_retry');
        });

        Schema::create('naxas_restaurant_ops_cart_idempotency', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('scope_hash', 64);
            $table->string('key_hash', 64);
            $table->string('request_hash', 64);
            $table->string('status', 16)->default('pending');
            $table->json('response')->nullable();
            $table->timestamp('expires_at');
            $table->timestamps();
            $table->unique(['scope_hash', 'key_hash'], 'rops_cart_idempotency_unique');
            $table->index('expires_at', 'rops_cart_idempotency_expiry');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('naxas_restaurant_ops_cart_idempotency');
        Schema::dropIfExists('naxas_restaurant_ops_snapshot_failures');
    }
};

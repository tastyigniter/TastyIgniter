<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('igniter_automation_rules', function(Blueprint $table): void {
            $table->unsignedBigInteger('id', true)->change();
        });

        Schema::table('igniter_automation_rule_actions', function(Blueprint $table): void {
            $table->unsignedBigInteger('id', true)->change();
        });

        Schema::table('igniter_automation_rule_conditions', function(Blueprint $table): void {
            $table->unsignedBigInteger('id', true)->change();
        });

        Schema::table('igniter_automation_logs', function(Blueprint $table): void {
            $table->unsignedBigInteger('id', true)->change();
        });
    }

    public function down(): void {}
};

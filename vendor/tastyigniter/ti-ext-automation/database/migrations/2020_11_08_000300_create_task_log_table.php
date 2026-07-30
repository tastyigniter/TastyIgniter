<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('igniter_automation_jobs')) {
            Schema::drop('igniter_automation_jobs');
        }

        if (Schema::hasTable('igniter_automation_logs')) {
            return;
        }

        Schema::create('igniter_automation_logs', function(Blueprint $table): void {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('automation_rule_id')->unsigned();
            $table->integer('rule_action_id')->unsigned();
            $table->boolean('is_success');
            $table->text('message');
            $table->text('params')->nullable();
            $table->text('exception')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('igniter_automation_logs');
    }
};

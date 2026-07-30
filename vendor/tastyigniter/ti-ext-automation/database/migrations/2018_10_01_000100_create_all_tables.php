<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('igniter_automation_rules', function(Blueprint $table): void {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->string('description');
            $table->text('event_class')->nullable();
            $table->text('config_data')->nullable();
            $table->boolean('is_custom')->default(0);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        Schema::create('igniter_automation_rule_actions', function(Blueprint $table): void {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('automation_rule_id');
            $table->string('class_name');
            $table->text('options');
            $table->timestamps();
        });

        Schema::create('igniter_automation_rule_conditions', function(Blueprint $table): void {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('automation_rule_id');
            $table->string('class_name');
            $table->text('options');
            $table->timestamps();
        });

        Schema::create('igniter_automation_jobs', function(Blueprint $table): void {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('event_class');
            $table->morphs('eventible', 'automation_jobs_eventible');
            $table->mediumText('payload');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('igniter_automation_rules');
        Schema::dropIfExists('igniter_automation_rule_actions');
        Schema::dropIfExists('igniter_automation_rule_conditions');
        Schema::dropIfExists('igniter_automation_jobs');
    }
};

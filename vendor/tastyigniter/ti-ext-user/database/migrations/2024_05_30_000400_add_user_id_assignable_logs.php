<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assignable_logs', function(Blueprint $table): void {
            $table->unsignedInteger('user_id')->nullable()->after('assignee_group_id');
        });
    }
};

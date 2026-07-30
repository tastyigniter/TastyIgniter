<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_users', function(Blueprint $table): void {
            $table->string('password')->nullable()->change();
        });

        Schema::table('customers', function(Blueprint $table): void {
            $table->string('password')->nullable()->change();
        });
    }
};

<?php

declare(strict_types=1);

namespace Igniter\Pages\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function(Blueprint $table): void {
            $table->mediumText('content')->change();
        });
    }

    public function down(): void {}
};

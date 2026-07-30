<?php

declare(strict_types=1);

namespace Igniter\Frontend\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('igniter_frontend_banners', function(Blueprint $table): void {
            $table->dropForeignKeyIfExists('language_id');
            $table->dropIndexIfExists('igniter_frontend_banners_language_id_foreign');
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void {}
};

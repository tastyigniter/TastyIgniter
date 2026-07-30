<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('menus', 'menu_description')) {
            Schema::table('menus', function(Blueprint $table): void {
                $table->text('menu_description')->nullable()->change();
            });
        }
    }

    public function down(): void {}
};

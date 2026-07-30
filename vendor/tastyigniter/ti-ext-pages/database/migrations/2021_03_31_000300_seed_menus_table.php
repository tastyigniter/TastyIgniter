<?php

declare(strict_types=1);

use Igniter\Pages\Models\Menu;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Menu::syncAll();
    }

    public function down(): void {}
};

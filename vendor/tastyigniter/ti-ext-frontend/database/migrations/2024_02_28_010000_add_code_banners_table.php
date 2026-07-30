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
        Schema::table('igniter_frontend_banners', function(Blueprint $table): void {
            $table->string('code')->nullable()->after('name');
        });
    }
};

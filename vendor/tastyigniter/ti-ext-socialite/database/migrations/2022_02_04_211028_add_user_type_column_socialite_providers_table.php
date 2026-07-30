<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('igniter_socialite_providers', function(Blueprint $table): void {
            $table->string('user_type')->nullable();
        });

        DB::table('igniter_socialite_providers')->update([
            'user_type' => 'customers',
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('igniter_socialite_providers');
    }
};

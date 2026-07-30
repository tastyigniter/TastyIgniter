<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('igniter_api_access_tokens', function(Blueprint $table): void {
            $table->bigIncrements('id');
            $table->morphs('tokenable', 'api_access_tokens_tokenable');
            $table->string('name');
            $table->string('token', 64)->unique('api_access_tokens_token_unique');
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('igniter_api_access_tokens');
    }
};

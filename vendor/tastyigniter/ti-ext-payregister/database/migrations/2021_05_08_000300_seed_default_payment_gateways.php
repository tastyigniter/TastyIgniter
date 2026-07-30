<?php

declare(strict_types=1);

use Igniter\PayRegister\Models\Payment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('payments') || DB::table('payments')->count()) {
            return;
        }

        rescue(fn() => Payment::syncAll());
    }
};

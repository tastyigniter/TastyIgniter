<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stocks', function(Blueprint $table): void {
            if (!Schema::hasColumn('stocks', 'out_of_stock_type')) {
                $table->string('out_of_stock_type')->nullable()->after('is_tracked');
            }

            if (!Schema::hasColumn('stocks', 'out_of_stock_until')) {
                $table->dateTime('out_of_stock_until')->nullable()->after('out_of_stock_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('stocks', function(Blueprint $table): void {
            $columns = [];

            if (Schema::hasColumn('stocks', 'out_of_stock_type')) {
                $columns[] = 'out_of_stock_type';
            }

            if (Schema::hasColumn('stocks', 'out_of_stock_until')) {
                $columns[] = 'out_of_stock_until';
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};

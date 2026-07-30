<?php

declare(strict_types=1);

use Igniter\Local\Models\ReviewSettings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('reviews')) {
            Schema::rename('reviews', 'igniter_reviews');
        }

        if (!Schema::hasTable('igniter_reviews')) {
            Schema::create('igniter_reviews', function(Blueprint $table): void {
                $table->engine = 'InnoDB';
                $table->integer('review_id', true);
                $table->integer('customer_id');
                $table->integer('sale_id');
                $table->string('sale_type', 32)->default('');
                $table->string('author', 32);
                $table->integer('location_id');
                $table->integer('quality');
                $table->integer('delivery');
                $table->integer('service');
                $table->text('review_text');
                $table->dateTime('date_added');
                $table->boolean('review_status');
                $table->index(['review_id', 'sale_type', 'sale_id'], 'reviews_sale_id_type_index');  // was unique
            });
        }

        ReviewSettings::set([
            'allow_reviews' => setting('allow_reviews', '1'),
            'approve_reviews' => setting('approve_reviews', '1'),
            'ratings' => setting('ratings', ['ratings' => [
                'Bad', 'Worse', 'Good', 'Average', 'Excellent',
            ]]),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('igniter_reviews');
    }
};

<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pages')) {
            Schema::create('pages', function(Blueprint $table): void {
                $table->engine = 'InnoDB';
                $table->integer('page_id', true);
                $table->integer('language_id');
                $table->string('name');
                $table->string('title');
                $table->string('permalink_slug');
                $table->string('heading')->nullable();
                $table->text('content');
                $table->string('meta_description')->nullable();
                $table->string('meta_keywords')->nullable();
                $table->integer('layout_id')->nullable();
                $table->text('navigation')->nullable();
                $table->dateTime('date_added');
                $table->dateTime('date_updated');
                $table->boolean('status');
            });
        }

        $this->seedPages();
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }

    protected function seedPages(): void
    {
        if (DB::table('pages')->count()) {
            return;
        }

        $now = Carbon::now();
        $language = DB::table('languages')->where('code', 'en')->first();

        DB::table('pages')->insert([
            [
                'language_id' => $language?->language_id,
                'name' => 'About Us',
                'title' => 'About Us',
                'permalink_slug' => 'about-us',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'meta_description' => '',
                'meta_keywords' => '',
                'date_added' => $now,
                'date_updated' => $now,
                'status' => 1,
            ],
            [
                'language_id' => $language?->language_id,
                'name' => 'Policy',
                'title' => 'Policy',
                'permalink_slug' => 'policy',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'meta_description' => '',
                'meta_keywords' => '',
                'date_added' => $now,
                'date_updated' => $now,
                'status' => 1,
            ],
            [
                'language_id' => $language?->language_id,
                'name' => 'Terms and Conditions',
                'title' => 'Terms and Conditions',
                'permalink_slug' => 'terms-and-conditions',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'meta_description' => '',
                'meta_keywords' => '',
                'date_added' => $now,
                'date_updated' => $now,
                'status' => 1,
            ],
        ]);
    }
};

<?php

declare(strict_types=1);

use Igniter\Api\ApiResources\Categories;
use Igniter\Api\ApiResources\Locations;
use Igniter\Api\ApiResources\Menus;
use Igniter\Api\ApiResources\Transformers\CategoryTransformer;
use Igniter\Api\ApiResources\Transformers\LocationTransformer;
use Igniter\Api\ApiResources\Transformers\MenuTransformer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('igniter_api_resources')
            ->where('controller', 'Igniter\Local\Resources\Menus')
            ->orWhere('controller', 'Igniter\Local\ApiResources\Menus')
            ->update(['controller' => Menus::class]);

        DB::table('igniter_api_resources')
            ->where('transformer', 'Igniter\Local\Resources\Transformers\MenuTransformer')
            ->orWhere('transformer', 'Igniter\Local\ApiResources\Transformers\MenuTransformer')
            ->update(['transformer' => MenuTransformer::class]);

        DB::table('igniter_api_resources')
            ->where('controller', 'Igniter\Local\Resources\Categories')
            ->orWhere('controller', 'Igniter\Local\ApiResources\Categories')
            ->update(['controller' => Categories::class]);

        DB::table('igniter_api_resources')
            ->where('transformer', 'Igniter\Local\Resources\Transformers\CategoryTransformer')
            ->orWhere('transformer', 'Igniter\Local\ApiResources\Transformers\CategoryTransformer')
            ->update(['transformer' => CategoryTransformer::class]);

        DB::table('igniter_api_resources')
            ->where('controller', 'Igniter\Local\Resources\Locations')
            ->orWhere('controller', 'Igniter\Local\ApiResources\Locations')
            ->update(['controller' => Locations::class]);

        DB::table('igniter_api_resources')
            ->where('transformer', 'Igniter\Local\Resources\Transformers\LocationTransformer')
            ->orWhere('transformer', 'Igniter\Local\ApiResources\Transformers\LocationTransformer')
            ->update(['transformer' => LocationTransformer::class]);
    }

    public function down(): void {}
};

<?php

use Igniter\Cart\Models\Category;
use Igniter\Cart\Models\Menu;
use Igniter\Local\Models\Location;
use Igniter\Main\Classes\MediaLibrary;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('media_attachments', function(Blueprint $table) {
            $table->increments('id');
            $table->string('disk');
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type');
            $table->integer('size')->unsigned();
            $table->string('tag')->index()->nullable();
            $table->nullableMorphs('attachment', 'media_attachments_attachment');
            $table->boolean('is_public')->default(1);
            $table->text('custom_properties')->nullable();
            $table->integer('priority')->unsigned()->nullable();
            $table->nullableTimestamps();
        });

        $this->seedAttachmentsFromExistingModels();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('media_attachments');
    }

    protected function seedAttachmentsFromExistingModels()
    {
        DB::table('menus')->select('menu_photo', 'menu_id')->get()->each(function($model) {
            if (!empty($model->menu_photo)) {
                $this->createMediaAttachment($model->menu_photo, 'thumb', Menu::class);
            }
        });

        DB::table('categories')->select('image', 'category_id')->get()->each(function($model) {
            if (!empty($model->image)) {
                $this->createMediaAttachment($model->image, 'thumb', Category::class);
            }
        });

        DB::table('locations')->select('location_image', 'options', 'location_id')->get()->each(function($model) {
            if (!empty($model->location_image)) {
                $this->createMediaAttachment($model->location_image, 'thumb', Location::class);
            }

            if (!empty($images = array_get($model->options, 'gallery.images'))) {
                foreach ($images as $image) {
                    $this->createMediaAttachment($image, 'gallery', Location::class);
                }
            }
        });
    }

    protected function createMediaAttachment($path, $tagName, $modelClass)
    {
        try {
            $mediaLibrary = resolve(MediaLibrary::class);
            $path = $mediaLibrary->getMediaRelativePath($path);

            $model = new $modelClass;
            $media = $model->newMediaInstance();
            $media->addFromFile(url($mediaLibrary->getMediaPath($path)), $tagName);

            $media->save();
            $model->media()->save($media);
        } catch (Exception $ex) {
            Log::debug($ex);
        }
    }
};

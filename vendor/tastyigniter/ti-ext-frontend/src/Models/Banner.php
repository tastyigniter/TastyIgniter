<?php

declare(strict_types=1);

namespace Igniter\Frontend\Models;

use Igniter\Flame\Database\Model;
use Igniter\Main\Helpers\ImageHelper;
use Igniter\System\Models\Concerns\Switchable;
use Igniter\System\Models\Language;

/**
 * Banners Model Class
 *
 * @property int $banner_id
 * @property string $name
 * @property string|null $code
 * @property string $type
 * @property string|null $click_url
 * @property int|null $language_id
 * @property string|null $alt_text
 * @property mixed|null $image_code
 * @property string|null $custom_code
 * @property bool $status
 * @property-read mixed $type_label
 * @mixin Model
 */
class Banner extends Model
{
    use Switchable;

    /**
     * @var string The database table name
     */
    protected $table = 'igniter_frontend_banners';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'banner_id';

    protected $fillable = ['name', 'code', 'type', 'click_url', 'language_id', 'alt_text', 'image_code', 'custom_code', 'status'];

    public $relation = [
        'belongsTo' => [
            'language' => Language::class,
        ],
    ];

    protected $casts = [
        'image_code' => 'serialize',
        'language_id' => 'integer',
        'status' => 'boolean',
    ];

    //
    // Accessors & Mutators
    //

    public function getTypeLabelAttribute(): string
    {
        return ucwords($this->type);
    }

    //
    // Helpers
    //

    public function getLanguageIdOptions()
    {
        return $this->dropdown('name');
    }

    public function getImageThumb(array $options = []): array
    {
        $defaults = ['name' => 'no_photo.png', 'path' => 'data/no_photo.png', 'url' => $options['no_photo']];

        if (empty($this->image_code)) {
            return $defaults;
        }

        $image = unserialize($this->image_code);

        if (empty($image['path'])) {
            return $defaults;
        }

        return $this->getThumbArray($image['path']);
    }

    public function getCarouselThumbs($options = []): array
    {
        $images = [];

        if (empty($this->image_code)) {
            return $images;
        }

        $image = unserialize($this->image_code);

        if (!is_array($image['paths'])) {
            return $images;
        }

        foreach ($image['paths'] as $path) {
            $images[] = $this->getThumbArray($path, 120, 120);
        }

        return $images;
    }

    public function getThumbArray(string $file_path, int|array $width = 120, int $height = 120): array
    {
        return [
            'name' => basename($file_path),
            'path' => $file_path,
            'url' => ImageHelper::resize($file_path, $width, $height),
        ];
    }
}

<?php namespace Admin\Models;

use Model;

/**
 * Banners Model Class
 *
 * @package Admin
 */
class Banners_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'banners';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'banner_id';

    protected $fillable = ['name', 'type', 'click_url', 'language_id', 'alt_text', 'image_code', 'custom_code', 'status'];

    public $relation = [
        'belongsTo' => [
            'language' => 'System\Models\Languages_model',
        ],
    ];

    public $casts = [
        'image_code' => 'serialize',
    ];

    //
    // Accessors & Mutators
    //

    public function getTypeLabelAttribute()
    {
        return ucwords($this->type);
    }

    //
    // Scopes
    //

    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Filter database records
     *
     * @param $query
     * @param array $filter an associative array of field/value pairs
     *
     * @return $this
     */
    public function scopeFilter($query, $filter = [])
    {
        if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
            $query->search($filter['filter_search'], ['name']);
        }

        if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
            $query->where('status', $filter['filter_status']);
        }

        return $query;
    }

    //
    // Helpers
    //

    public function getLanguageIdOptions()
    {
        return $this->dropdown('name');
    }

    public function getImageThumb($options = [])
    {
        $defaults = ['name' => 'no_photo.png', 'path' => 'data/no_photo.png', 'url' => $options['no_photo']];

        if (empty($this->image_code))
            return $defaults;

        $image = unserialize($this->image_code);

        if (empty($image['path']))
            return $defaults;

        return $this->getThumbArray($image['path'], 120, 120);
    }

    public function getCarouselThumbs($options = [])
    {
        $defaults = [];

        if (empty($this->image_code))
            return $defaults;

        $image = unserialize($this->image_code);

        if (!is_array($image['paths']))
            return $defaults;

        foreach ($image['paths'] as $path) {
            $images[] = $this->getThumbArray($path, 120, 120);
        }

        return $images;
    }

    public function getThumbArray($file_path, $width = 120, $height = 120)
    {
        return [
            'name' => basename($file_path),
            'path' => $file_path,
            'url'  => Image_tool_model::resize($file_path, $width, $height),
        ];
    }
}
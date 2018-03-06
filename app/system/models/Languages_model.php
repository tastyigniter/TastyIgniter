<?php namespace System\Models;

use Igniter\Flame\Database\Traits\Purgeable;
use Model;

/**
 * Languages Model Class
 * @package System
 */
class Languages_model extends Model
{
    use Purgeable;

    /**
     * @var string The database table name
     */
    protected $table = 'languages';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'language_id';

    public $purgeable = ['clone_language', 'language_to_clone', 'file'];

    public static function getDropdownOptions()
    {
        return static::isEnabled()->dropdown('name', 'code');
    }

    public static function listCloneableLanguages()
    {
        return static::isEnabled()->whereNull('original_id')->dropdown('name', 'idiom');
    }

    //
    // Scopes
    //

    /**
     * Scope a query to only include enabled language
     *
     * @param $query
     *
     * @return $this
     */
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
            $query->search($filter['filter_search'], ['name', 'code']);
        }

        if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
            $query->where('status', $filter['filter_status']);
        }

        return $query;
    }

    //
    // Events
    //

    public function beforeCreate()
    {
        $this->restorePurgedValues();

        $this->setOriginalLanguageBeforeCreate();

        $this->purgeAttributes();
    }

    public function afterSave()
    {
        $this->restorePurgedValues();

//        $domain = get('domain');
//        $filename = get('file');
//        if (is_string($filename) AND is_string($domain) AND is_array($this->file))
//            save_lang_file($filename, $this->idiom, $domain, $this->file);
    }

    public function setOriginalLanguageBeforeCreate()
    {
        if (!isset($this->attributes['clone_language']) OR !isset($this->attributes['language_to_clone'])
            OR !in_array($this->attributes['clone_language'], ['clone', 'import'])
        ) return FALSE;

        $original = $this->attributes['language_to_clone'];
        if (is_numeric($original)) {
            $originalModel = $this->newQuery()->find($original);
        }
        else {
            $originalModel = $this->newQuery()->whereName($original)->first();
        }

        if (!$this->idiom OR !$originalModel OR $this->idiom == $originalModel)
            return FALSE;

        if (clone_language($this->idiom, $originalModel->idiom))
            $this->original_id = $originalModel->getKey();
    }

    public function beforeDelete()
    {
        delete_language($this->idiom);
    }

    //
    // Helpers
    //

    public static function syncAll()
    {
    }

    public function listAllFiles()
    {
        $result = [];
        if (!$this->idiom)
            return $result;

        if ($langFiles = list_lang_files($this->idiom)) {
            foreach ($langFiles as $location => $files) {
                if (!count($files)) continue;
                foreach ($files as $file) {
                    $result[$location][] = [
                        'id'   => $this->language_id,
                        'name' => $file,
                        'path' => $location,
                    ];
                }
            }
        }

        return $result;
    }

    public function isDefault()
    {
        return ($this->language_id == 11);
    }
}
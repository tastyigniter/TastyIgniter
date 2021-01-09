<?php

namespace Main\Template;

use Igniter\Flame\Mail\Markdown;
use Igniter\Flame\Support\Facades\File;

class Content extends Model
{
    /**
     * @var string The directory name associated with the model
     */
    protected $dirName = '_content';

    public static function initCacheItem(&$item)
    {
        $item['parsedMarkup'] = (new static($item))->parseMarkup();
    }

    public function getParsedMarkupAttribute()
    {
        if (array_key_exists('parsedMarkup', $this->attributes)) {
            return $this->attributes['parsedMarkup'];
        }

        return $this->attributes['parsedMarkup'] = $this->parseMarkup();
    }

    /**
     * Parses the content markup according to the file type.
     * @return string
     */
    public function parseMarkup()
    {
        $extension = strtolower(File::extension($this->fileName));

        switch ($extension) {
            case 'txt':
                $result = htmlspecialchars($this->markup);
                break;
            case 'md':
                $result = Markdown::parse($this->markup)->toHtml();
                break;
            default:
                $result = $this->markup;
        }

        return $result;
    }
}

<?php

declare(strict_types=1);

namespace Igniter\Main\Template;

use Igniter\Flame\Mail\Markdown;
use Igniter\Flame\Pagic\Model;
use Igniter\Flame\Support\Facades\File;
use Override;

class Content extends Model
{
    /** The directory name associated with the model */
    public const string DIR_NAME = '_content';

    #[Override]
    public static function initCacheItem(array &$item): void
    {
        $item['parsedMarkup'] = (new static($item))->parseMarkup();
    }

    /**
     * Parses the content markup according to the file type.
     */
    public function parseMarkup(): ?string
    {
        $extension = strtolower(File::extension($this->fileName));

        return match ($extension) {
            'txt' => htmlspecialchars((string)$this->markup),
            'md' => Markdown::parse($this->markup)->toHtml(),
            default => $this->markup,
        };
    }
}

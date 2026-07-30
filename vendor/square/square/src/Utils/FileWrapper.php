<?php

declare(strict_types=1);

namespace Square\Utils;

use Core\Types\Sdk\CoreFileWrapper;

/**
 * Wraps file with mime-type and filename to be sent as part of an HTTP request.
 */
class FileWrapper extends CoreFileWrapper
{
    /**
     * Create FileWrapper instance from a file on disk
     */
    public static function createFromPath(string $realFilePath, ?string $mimeType = null, ?string $filename = ''): self
    {
        return new self($realFilePath, $mimeType, $filename);
    }
}

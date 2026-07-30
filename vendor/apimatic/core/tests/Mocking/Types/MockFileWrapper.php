<?php

declare(strict_types=1);

namespace Core\Tests\Mocking\Types;

use Core\Types\Sdk\CoreFileWrapper;

class MockFileWrapper extends CoreFileWrapper
{
    public static function createFromPath(string $realFilePath, ?string $mimeType = null, ?string $filename = ''): self
    {
        return new self($realFilePath, $mimeType, $filename);
    }
}

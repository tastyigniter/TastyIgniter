<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Exception;

use RuntimeException;

class InvalidExtensionException extends RuntimeException
{
    public function __construct(string $fileName, string $allowedExtension)
    {
        parent::__construct(sprintf(
            'The file "%s" has an invalid extension. Allowed extensions are: %s',
            $fileName, $allowedExtension
        ));
    }
}

<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Exception;

use RuntimeException;

class CreateFileException extends RuntimeException
{
    /**
     * Name of the affected file path.
     */
    protected string $invalidPath;

    /**
     * Set the affected file path.
     */
    public function setInvalidPath(string $path): self
    {
        $this->invalidPath = $path;

        $this->message = sprintf('Error creating file [%s]. Please check write permissions.', $path);

        return $this;
    }
}

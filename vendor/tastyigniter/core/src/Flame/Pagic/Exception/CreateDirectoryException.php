<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Exception;

use RuntimeException;

class CreateDirectoryException extends RuntimeException
{
    /**
     * Name of the affected directory path.
     */
    protected string $invalidPath;

    /**
     * Set the affected directory path.
     */
    public function setInvalidPath(string $path): self
    {
        $this->invalidPath = $path;

        $this->message = sprintf('Error creating directory [%s]. Please check write permissions.', $path);

        return $this;
    }
}

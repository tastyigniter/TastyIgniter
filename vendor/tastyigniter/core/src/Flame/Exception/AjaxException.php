<?php

declare(strict_types=1);

namespace Igniter\Flame\Exception;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AjaxException extends Exception
{
    protected array $contents;

    public function __construct(string|array $contents, int $code = 406)
    {
        if (is_string($contents)) {
            $contents = ['result' => $contents];
        }

        $this->contents = $contents;

        parent::__construct(json_encode($contents), $code);
    }

    /**
     * Returns invalid fields.
     */
    public function getContents(): array
    {
        return $this->contents;
    }

    public function report(): bool
    {
        return false;
    }

    public function render(Request $request): Response
    {
        return response($this->getContents(), $this->code);
    }
}

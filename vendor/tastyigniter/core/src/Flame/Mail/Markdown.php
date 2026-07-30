<?php

declare(strict_types=1);

namespace Igniter\Flame\Mail;

use Igniter\Flame\Support\Facades\File;
use Illuminate\Support\HtmlString;

class Markdown extends \Illuminate\Mail\Markdown
{
    public static function parseFile(string $path): HtmlString
    {
        return self::parse(File::get($path));
    }
}

<?php

declare(strict_types=1);

namespace Igniter\Main\Template;

use Igniter\Flame\Pagic\Model;
use Igniter\Main\Template\Code\PartialCode;

class Partial extends Model
{
    /** The directory name associated with the model */
    public const string DIR_NAME = '_partials';

    public array $settings = [];

    /**
     * Returns name of a PHP class to use as parent
     * for the PHP class created for the template's PHP section.
     */
    public function getCodeClassParent(): string
    {
        return PartialCode::class;
    }
}

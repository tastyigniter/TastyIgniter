<?php

declare(strict_types=1);

namespace Igniter\Main\Template;

use Igniter\Flame\Pagic\Model;
use Igniter\Main\Template\Code\LayoutCode;
use Igniter\Main\Template\Concerns\HasComponents;
use Igniter\Main\Template\Concerns\HasViewBag;

/**
 * Layout Template Class
 */
class Layout extends Model
{
    use HasComponents;
    use HasViewBag;

    /** The directory name associated with the model, eg: pages. */
    public const string DIR_NAME = '_layouts';

    public static function initFallback(string $source): self
    {
        $model = self::on($source);
        $model->markup = '<?= page(); ?>';
        $model->fileName = 'default';

        return $model;
    }

    /**
     * Returns name of a PHP class to use as parent
     * for the PHP class created for the template's PHP section.
     */
    public function getCodeClassParent(): string
    {
        return LayoutCode::class;
    }
}

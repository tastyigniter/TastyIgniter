<?php

declare(strict_types=1);

namespace Igniter\Main\Components;

use Igniter\Flame\Pagic\TemplateCode;
use Igniter\System\Classes\BaseComponent;
use Override;

class BlankComponent extends BaseComponent
{
    /** This component is hidden from the admin UI. */
    public bool $isHidden = true;

    public function __construct(
        ?TemplateCode $page,
        array $properties,
        /** Error message that is shown with this error component. */
        protected ?string $errorMessage = null,
    ) {
        parent::__construct($page, $properties);
    }

    #[Override]
    public function onRender(): string
    {
        return $this->errorMessage;
    }
}

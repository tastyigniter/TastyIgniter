<?php

declare(strict_types=1);

namespace Igniter\Admin\Classes;

use Override;

class BaseMainMenuWidget extends BaseWidget
{
    /**
     * Constructor
     *
     * @param $controller \Illuminate\Routing\Controller Active controller object.
     * @param $menuItem \Igniter\Admin\Classes\MainMenuItem Object containing general form field information.
     * @param $config array Configuration the relates to this widget.
     */
    public function __construct(AdminController $controller, protected MainMenuItem $menuItem, array $config = [])
    {
        $this->config = $this->makeConfig($config);

        parent::__construct($controller, $config);
    }

    /**
     * Returns a unique ID for this widget. Useful in creating HTML markup.
     */
    #[Override]
    public function getId(?string $suffix = null): string
    {
        $id = parent::getId($suffix);
        $id .= '-'.$this->menuItem->getId();

        return name_to_id($id);
    }
}

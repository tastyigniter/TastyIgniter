<?php

declare(strict_types=1);

namespace Igniter\Main\Template\Concerns;

use Igniter\Main\Components\ViewBag;

trait HasViewBag
{
    /**
     * Contains the view bag properties.
     * This property is used by the page editor internally.
     */
    public array $viewBag = [];

    /** Cache store for the getViewBag method. */
    protected ?ViewBag $viewBagCache = null;

    /**
     * Boot the sortable trait for this model.
     */
    public static function bootHasViewBag(): void
    {
        static::retrieved(function(self $model) {
            $model->fillViewBagArray();
        });
    }

    /**
     * Returns the configured view bag component.
     * This method is used only in the back-end and for internal system needs when
     * the standard way to access components is not an option.
     */
    public function getViewBag(): ?ViewBag
    {
        if ($this->viewBagCache !== null) {
            return $this->viewBagCache;
        }

        $componentName = 'viewBag';

        if (!isset($this->settings['components'][$componentName])) {
            $viewBag = new ViewBag(null, []);
            $viewBag->name = $componentName;

            return $this->viewBagCache = $viewBag;
        }

        /** @var ViewBag $viewBag */
        $viewBag = $this->getComponent($componentName);

        return $this->viewBagCache = $viewBag;
    }

    /**
     * Copies view bag properties to the view bag array.
     * This is required for the back-end editors.
     * @return void
     */
    protected function fillViewBagArray()
    {
        $viewBag = $this->getViewBag();
        foreach ($viewBag?->getProperties() ?? [] as $name => $value) {
            $this->viewBag[$name] = $value;
        }

        $this->fireEvent('templateModel.fillViewBagArray');
    }
}

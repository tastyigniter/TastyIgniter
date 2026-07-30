<?php

declare(strict_types=1);

namespace Igniter\Admin\Widgets;

use Igniter\Admin\Classes\BaseWidget;
use Illuminate\Http\RedirectResponse;
use Override;

class SearchBox extends BaseWidget
{
    /** Search placeholder text. */
    public string $prompt = '';

    /** Defines the search mode. Commonly passed to the search() query. */
    public ?string $mode = null;

    /** Custom scope method name. Commonly passed to the query. */
    public ?string $scope = null;

    protected string $defaultAlias = 'search';

    /** Active search term pulled from session data. */
    protected ?string $activeTerm = null;

    /** List of CSS classes to apply to the list container element. */
    public array $cssClasses = [];

    /**
     * Initialize the widget, called by the constructor and free from its parameters.
     */
    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'prompt',
            'scope',
            'mode',
        ]);
    }

    /**
     * Renders the widget.
     */
    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('searchbox/searchbox');
    }

    /**
     * Prepares the view data
     */
    public function prepareVars(): void
    {
        $this->vars['searchBox'] = $this;
        $this->vars['cssClasses'] = implode(' ', $this->cssClasses);
        $this->vars['placeholder'] = lang($this->prompt);
        $this->vars['value'] = $this->getActiveTerm();
    }

    /**
     * Search field has been submitted.
     */
    public function onSubmit(...$params): RedirectResponse|array|null
    {
        // Save or reset search term in session
        $this->setActiveTerm(post($this->getName()));

        // Trigger class event, merge results as viewable array
        $result = $this->fireEvent('search.submit', [$params]);
        if ($result && is_array($result)) {
            [$redirect] = $result;

            return ($redirect instanceof RedirectResponse) ?
                $redirect : array_merge(...$result);
        }

        return null;
    }

    /**
     * Returns an active search term for this widget instance.
     */
    public function getActiveTerm(): string
    {
        return $this->activeTerm = $this->getSession('term', '');
    }

    /**
     * Sets an active search term for this widget instance.
     */
    public function setActiveTerm(?string $term): void
    {
        if ($term) {
            $this->putSession('term', $term);
        } else {
            $this->resetSession();
        }

        $this->activeTerm = $term;
    }

    /**
     * Returns a value suitable for the field name property.
     */
    public function getName(): string
    {
        return $this->alias;
    }
}

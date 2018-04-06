<?php

namespace Admin\Widgets;

use Admin\Classes\BaseWidget;
use Illuminate\Http\RedirectResponse;

class SearchBox extends BaseWidget
{
    /**
     * @var string Search placeholder text.
     */
    public $prompt;

    /**
     * @var string Defines the search mode. Commonly passed to the search() query.
     */
    public $mode;

    /**
     * @var string Custom scope method name. Commonly passed to the query.
     */
    public $scope;

    protected $defaultAlias = 'search';

    /**
     * @var string Active search term pulled from session data.
     */
    protected $activeTerm;

    /**
     * @var array List of CSS classes to apply to the list container element.
     */
    public $cssClasses = [];

    /**
     * Initialize the widget, called by the constructor and free from its parameters.
     */
    public function initialize()
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
    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('searchbox/searchbox');
    }

    /**
     * Prepares the view data
     */
    public function prepareVars()
    {
        $this->vars['searchBox'] = $this;
        $this->vars['cssClasses'] = implode(' ', $this->cssClasses);
        $this->vars['placeholder'] = lang($this->prompt);
        $this->vars['value'] = $this->getActiveTerm();
    }

    /**
     * Search field has been submitted.
     */
    public function onSubmit()
    {
        // Save or reset search term in session
        $this->setActiveTerm(post($this->getName()));

        // Trigger class event, merge results as viewable array
        $params = func_get_args();
        $result = $this->fireEvent('search.submit', [$params]);
        if ($result && is_array($result)) {
            list($redirect) = $result;

            return ($redirect instanceof RedirectResponse) ?
                $redirect : call_user_func_array('array_merge', $result);
        }
    }

    /**
     * Returns an active search term for this widget instance.
     */
    public function getActiveTerm()
    {
        return $this->activeTerm = $this->getSession('term', '');
    }

    /**
     * Sets an active search term for this widget instance.
     *
     * @param $term
     */
    public function setActiveTerm($term)
    {
        if (strlen($term)) {
            $this->putSession('term', $term);
        }
        else {
            $this->resetSession();
        }

        $this->activeTerm = $term;
    }

    /**
     * Returns a value suitable for the field name property.
     * @return string
     */
    public function getName()
    {
        return $this->alias;
    }
}

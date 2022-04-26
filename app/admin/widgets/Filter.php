<?php

namespace Admin\Widgets;

use Admin\Classes\BaseWidget;
use Admin\Classes\FilterScope;
use Admin\Facades\AdminAuth;
use Admin\Traits\LocationAwareWidget;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class Filter
 */
class Filter extends BaseWidget
{
    use LocationAwareWidget;

    /**
     * @var array|string Search widget configuration or partial name, optional.
     */
    public $search;

    /**
     * @var BaseWidget Reference to the search widget object.
     */
    protected $searchWidget;

    /**
     * @var array Scope definition configuration.
     */
    public $scopes;

    /**
     * @var string The context of this filter, scopes that do not belong
     * to this context will not be shown.
     */
    public $context;

    protected $defaultAlias = 'filter';

    /**
     * @var bool Determines if scope definitions have been created.
     */
    protected $scopesDefined = FALSE;

    /**
     * @var array Collection of all scopes used in this filter.
     */
    protected $allScopes = [];

    /**
     * @var array Collection of all scopes models used in this filter.
     */
    protected $scopeModels = [];

    /**
     * @var array List of CSS classes to apply to the filter container element
     */
    public $cssClasses = [];

    public function loadAssets()
    {
        $this->addJs('~/app/admin/assets/src/js/vendor/moment.min.js', 'moment-js');

        // daterange picker
        $this->addJs('~/app/admin/dashboardwidgets/charts/assets/vendor/daterange/daterangepicker.js', 'daterangepicker-js');
        $this->addCss('~/app/admin/dashboardwidgets/charts/assets/vendor/daterange/daterangepicker.css', 'daterangepicker-css');

        // date picker
        $this->addJs('js/datepicker.js', 'datepicker-js');

        // selectlist
        $this->addJs('~/app/admin/widgets/form/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js', 'bootstrap-multiselect-js');
        $this->addCss('~/app/admin/widgets/form/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css', 'bootstrap-multiselect-css');
        $this->addJs('~/app/admin/widgets/form/assets/js/selectlist.js', 'selectlist-js');
        $this->addCss('~/app/admin/widgets/form/assets/css/selectlist.css', 'selectlist-css');
    }

    public function initialize()
    {
        $this->fillFromConfig([
            'search',
            'scopes',
            'context',
        ]);

        if (isset($this->search)) {
            $searchConfig = $this->search;
            $searchConfig['alias'] = $this->alias.'Search';
            $this->searchWidget = $this->makeWidget('Admin\Widgets\SearchBox', $searchConfig);
            $this->searchWidget->bindToController();
        }
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('filter/filter');
    }

    public function prepareVars()
    {
        $this->defineFilterScopes();
        $this->vars['filterAlias'] = $this->alias;
        $this->vars['filterId'] = $this->getId();
        $this->vars['cookieStoreName'] = $this->getCookieKey();
        $this->vars['onSubmitHandler'] = $this->getEventHandler('onSubmit');
        $this->vars['onClearHandler'] = $this->getEventHandler('onClear');
        $this->vars['cssClasses'] = implode(' ', $this->cssClasses);
        $this->vars['search'] = $this->searchWidget ? $this->searchWidget->render() : '';
        $this->vars['scopes'] = $this->getScopes();
    }

    /**
     * @return \Admin\Widgets\SearchBox
     */
    public function getSearchWidget()
    {
        return $this->searchWidget;
    }

    /**
     * Renders the HTML element for a scope
     *
     * @param $scope
     *
     * @return
     */
    public function renderScopeElement($scope)
    {
        $params = ['scope' => $scope];

        return $this->makePartial('filter/scope_'.$scope->type, $params);
    }

    /**
     * Update a filter scope value.
     * @return array
     */
    public function onSubmit()
    {
        $this->defineFilterScopes();

        if (!$scopes = post($this->alias))
            return;

        foreach ($scopes as $scope => $value) {
            $scope = $this->getScope($scope);

            switch ($scope->type) {
                case 'select':
                case 'selectlist':
                    $active = $value;
                    $this->setScopeValue($scope, $active);
                    break;

                case 'checkbox':
                    $checked = $value == '1' ? TRUE : FALSE;
                    $this->setScopeValue($scope, $checked);
                    break;

                case 'switch':
                    $this->setScopeValue($scope, $value);
                    break;

                case 'date':
                    $date = $value ? make_carbon($value)->format('Y-m-d') : null;
                    $this->setScopeValue($scope, $date);
                    break;

                case 'daterange':
                    $format = array_get($scope->config, 'showTimePicker', FALSE) ? 'Y-m-d H:i:s' : 'Y-m-d';
                    $dateRange = (is_array($value) && count($value) === 2 && $value[0] != '') ? [
                        make_carbon($value[0])->format($format),
                        make_carbon($value[1])->format($format),
                    ] : null;
                    $this->setScopeValue($scope, $dateRange);
                    break;
            }
        }

        // Trigger class event, merge results as viewable array
        $params = func_get_args();
        $result = $this->fireEvent('filter.submit', [$params]);
        if ($result && is_array($result)) {
            [$redirect] = $result;

            return ($redirect instanceof RedirectResponse) ? $redirect : $result;
        }
    }

    public function onClear()
    {
        $this->defineFilterScopes();

        $this->resetSession();
        $this->searchWidget->resetSession();

        $params = func_get_args();
        $result = $this->fireEvent('filter.submit', [$params]);
        if ($result && is_array($result)) {
            [$redirect] = $result;

            return ($redirect instanceof RedirectResponse) ? $redirect : $result;
        }
    }

    public function getSelectOptions($scopeName)
    {
        $this->defineFilterScopes();

        $scope = $this->getScope($scopeName);
        $activeKey = $scope->value ? $scope->value : null;

        return [
            'available' => $this->getAvailableOptions($scope),
            'active' => $activeKey,
        ];
    }

    //
    // Internals
    //

    /**
     * Returns the available options a scope can use, either from the
     * model relation or from a supplied array. Optionally apply a search
     * constraint to the options.
     *
     * @param string $scope
     * @param string $searchQuery
     *
     * @return array
     */
    protected function getAvailableOptions($scope)
    {
        if ($scope->options) {
            return $this->getOptionsFromArray($scope);
        }

        $available = [];
        $nameColumn = $this->getScopeNameFrom($scope);
        $options = $this->getOptionsFromModel($scope);
        foreach ($options as $option) {
            $available[$option->getKey()] = $option->{$nameColumn};
        }

        return $available;
    }

    /**
     * Looks at the model for defined scope items.
     *
     * @param $scope
     *
     * @return Collection
     */
    protected function getOptionsFromModel($scope)
    {
        $model = $this->getScopeModel($scope->scopeName);
        $query = $model->newQuery();

        $this->locationApplyScope($query);

        // Extensibility
        $this->fireSystemEvent('admin.filter.extendQuery', [$query, $scope]);

        return $query->get();
    }

    /**
     * Look at the defined set of options for scope items, or the model method.
     *
     * @param $scope
     *
     * @return array
     */
    protected function getOptionsFromArray($scope)
    {
        // Load the data
        $options = $scope->options;

        if (is_scalar($options)) {
            $model = $this->getScopeModel($scope->scopeName);
            $methodName = $options;

            if (!$model->methodExists($methodName)) {
                throw new Exception(sprintf(lang('admin::lang.list.filter_missing_definitions'),
                    get_class($model), $methodName, $scope->scopeName
                ));
            }

            $options = $model->$methodName();
        }
        elseif (is_callable($options)) {
            return $options();
        }
        elseif (!is_array($options)) {
            $options = [];
        }

        return $options;
    }

    /**
     * Creates a flat array of filter scopes from the configuration.
     */
    protected function defineFilterScopes()
    {
        if ($this->scopesDefined)
            return;

        $this->fireSystemEvent('admin.filter.extendScopesBefore');

        if (!isset($this->scopes) || !is_array($this->scopes)) {
            $this->scopes = [];
        }

        $this->addScopes($this->scopes);

        $this->fireSystemEvent('admin.filter.extendScopes', [$this->scopes]);

        $this->scopesDefined = TRUE;
    }

    /**
     * Programatically add scopes, used internally and for extensibility.
     *
     * @param array $scopes
     */
    public function addScopes(array $scopes)
    {
        foreach ($scopes as $name => $config) {
            $scopeObj = $this->makeFilterScope($name, $config);

            // Check if admin has permissions to show this column
            $permissions = array_get($config, 'permissions');
            if (!empty($permissions) && !AdminAuth::getUser()->hasPermission($permissions, FALSE)) {
                continue;
            }

            // Check that the filter scope matches the active context
            if ($scopeObj->context !== null) {
                $context = (array)$scopeObj->context;
                if (!in_array($this->getContext(), $context)) {
                    continue;
                }
            }

            // Check that the filter scope matches the active location context
            if ($this->isLocationAware($config)) continue;

            // Validate scope model
            if (isset($config['modelClass'])) {
                $class = $config['modelClass'];
                $model = new $class;
                $this->scopeModels[$name] = $model;
            }

            // Ensure dates options are set
            if (!isset($config['minDate'])) {
                $scopeObj->minDate = '2000-01-01';
                $scopeObj->maxDate = '2099-12-31';
            }

            $this->allScopes[$name] = $scopeObj;
        }
    }

    /**
     * Creates a filter scope object from name and configuration.
     *
     * @param $name
     * @param $config
     *
     * @return \Admin\Classes\FilterScope
     */
    protected function makeFilterScope($name, $config)
    {
        $label = $config['label'] ?? null;
        $scopeType = $config['type'] ?? null;

        $scope = new FilterScope($name, $label);
        $scope->displayAs($scopeType, $config);

        // Set scope value
        $scope->value = $this->getScopeValue($scope);

        return $scope;
    }

    //
    // Filter query logic
    //

    /**
     * Applies all scopes to a DB query.
     *
     * @param \Igniter\Flame\Database\Builder $query
     *
     * @return \Igniter\Flame\Database\Builder
     */
    public function applyAllScopesToQuery($query)
    {
        $this->defineFilterScopes();

        foreach ($this->allScopes as $scope) {
            $this->applyScopeToQuery($scope, $query);
        }

        return $query;
    }

    /**
     * Applies a filter scope constraints to a DB query.
     *
     * @param string $scope
     * @param \Igniter\Flame\Database\Builder $query
     *
     * @return \Igniter\Flame\Database\Builder
     */
    public function applyScopeToQuery($scope, $query)
    {
        if (is_string($scope)) {
            $scope = $this->getScope($scope);
        }

        if ($scope->disabled || ($scope->value !== '0' && !$scope->value)) {
            return;
        }

        switch ($scope->type) {
            case 'date':
                $value = $scope->value;

                if ($scopeConditions = $scope->conditions) {
                    $date = make_carbon($scope->value);
                    $query->whereRaw(strtr($scopeConditions, [
                        ':filtered' => $date->format('Y-m-d'),
                        ':year' => $date->format('Y'),
                        ':month' => $date->format('m'),
                        ':day' => $date->format('d'),
                    ]));
                } // Scope
                elseif ($scopeMethod = $scope->scope) {
                    $query->$scopeMethod($value);
                }

                break;

            case 'daterange':
                $value = $scope->value;

                if ($scopeConditions = $scope->conditions) {
                    $startDate = make_carbon($value[0]);
                    $endDate = make_carbon($value[1]);
                    $query->whereRaw(strtr($scopeConditions, [
                        ':filtered_start' => '"'.$startDate->format('Y-m-d').'"',
                        ':year_start' => $startDate->format('Y'),
                        ':month_start' => $startDate->format('m'),
                        ':day_start' => $startDate->format('d'),
                        ':filtered_end' => '"'.$endDate->format('Y-m-d').'"',
                        ':year_end' => $endDate->format('Y'),
                        ':month_end' => $endDate->format('m'),
                        ':day_end' => $endDate->format('d'),
                    ]));
                } // Scope
                elseif ($scopeMethod = $scope->scope) {
                    $query->$scopeMethod($value);
                }

                break;

            default:
                $value = is_array($scope->value) ? array_values($scope->value) : $scope->value;

                if ($scopeConditions = $scope->conditions) {
                    // Switch scope: multiple conditions, value either 1 or 2
                    if (is_array($scopeConditions)) {
                        $conditionNum = is_array($value) ? 0 : $value - 1;
                        [$scopeConditions] = array_slice($scopeConditions, $conditionNum);
                    }

                    if (is_array($value)) {
                        $filtered = implode(',', array_map(function ($key) {
                            return DB::getPdo()->quote($key);
                        }, $value));
                    }
                    else {
                        $filtered = DB::getPdo()->quote($value);
                    }

                    $query->whereRaw(strtr($scopeConditions, [':filtered' => $filtered]));
                }
                elseif ($scopeMethod = $scope->scope) {
                    $query->$scopeMethod($value);
                }

                break;
        }

        return $query;
    }

    //
    // Access layer
    //

    public function getScopeName($scope)
    {
        if (is_string($scope)) {
            $scope = $this->getScope($scope);
        }

        return $this->alias.'['.$scope->scopeName.']';
    }

    /**
     * Returns a scope value for this widget instance.
     *
     * @param $scope
     * @param null $default
     *
     * @return string
     */
    public function getScopeValue($scope, $default = null)
    {
        if (is_string($scope)) {
            $scope = $this->getScope($scope);
        }

        $cacheKey = 'scope-'.$scope->scopeName;

        return $this->getSession($cacheKey, $default);
    }

    /**
     * Sets an scope value for this widget instance.
     *
     * @param $scope
     * @param $value
     */
    public function setScopeValue($scope, $value)
    {
        if (is_string($scope)) {
            $scope = $this->getScope($scope);
        }

        $cacheKey = 'scope-'.$scope->scopeName;
        $this->putSession($cacheKey, $value);

        $scope->value = $value;
    }

    /**
     * Get all the registered scopes for the instance.
     * @return array
     */
    public function getScopes()
    {
        return $this->allScopes;
    }

    /**
     * Get a specified scope object
     *
     * @param string $scope
     *
     * @return mixed
     */
    public function getScope($scope)
    {
        if (!isset($this->allScopes[$scope])) {
            throw new Exception(sprintf(lang('admin::lang.list.filter_missing_scope_definitions'),
                $scope
            ));
        }

        return $this->allScopes[$scope];
    }

    /**
     * Returns the display name column for a scope.
     *
     * @param string $scope
     *
     * @return string
     */
    public function getScopeNameFrom($scope)
    {
        if (is_string($scope)) {
            $scope = $this->getScope($scope);
        }

        return $scope->nameFrom;
    }

    /**
     * Returns the active context for displaying the filter.
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    public function isActiveState()
    {
        $cookieKey = $this->getCookieKey();

        return (bool)@json_decode(array_get($_COOKIE, $cookieKey));
    }

    public function getCookieKey()
    {
        return 'ti_displayListFilter';
    }

    /**
     * @param $scope
     *
     * @return mixed
     */
    protected function getScopeModel($scope)
    {
        if (!isset($this->scopeModels[$scope]))
            return null;

        return $this->scopeModels[$scope];
    }
}

<?php

declare(strict_types=1);

namespace Igniter\Admin\Widgets;

use Igniter\Admin\Classes\BaseWidget;
use Igniter\Admin\Classes\FilterScope;
use Igniter\Flame\Exception\SystemException;
use Igniter\Local\Traits\LocationAwareWidget;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Override;

/**
 * Class Filter
 */
class Filter extends BaseWidget
{
    use LocationAwareWidget;

    /** string Search widget configuration or partial name, optional. */
    public ?array $search = null;

    /** Scope definition configuration. */
    public ?array $scopes = null;

    /** The context of this filter, scopes that do not belong * to this context will not be shown.
     */
    public ?string $context = null;

    /** Reference to the search widget object. */
    protected ?SearchBox $searchWidget = null;

    protected string $defaultAlias = 'filter';

    /** Determines if scope definitions have been created. */
    protected bool $scopesDefined = false;

    /** Collection of all scopes used in this filter. */
    protected array $allScopes = [];

    /** Collection of all scopes models used in this filter. */
    protected array $scopeModels = [];

    /** List of CSS classes to apply to the filter container element */
    public array $cssClasses = [];

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('js/vendor.datetime.js', 'vendor-datetime-js');
        $this->addJs('widgets/daterangepicker.js', 'daterangepicker-js');
        $this->addCss('formwidgets/datepicker.css', 'datepicker-css');
    }

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'search',
            'scopes',
            'context',
        ]);

        if (isset($this->search)) {
            $searchConfig = $this->search;
            $searchConfig['alias'] = $this->alias.'Search';
            /** @var SearchBox $searchWidget */
            $searchWidget = $this->makeWidget(SearchBox::class, $searchConfig);
            $searchWidget->bindToController();
            $this->searchWidget = $searchWidget;
        }
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('filter/filter');
    }

    public function prepareVars(): void
    {
        $this->defineFilterScopes();
        $this->vars['filterAlias'] = $this->alias;
        $this->vars['filterId'] = $this->getId();
        $this->vars['onSubmitHandler'] = $this->getEventHandler('onSubmit');
        $this->vars['onClearHandler'] = $this->getEventHandler('onClear');
        $this->vars['cssClasses'] = implode(' ', $this->cssClasses);
        $this->vars['search'] = $this->searchWidget instanceof SearchBox ? $this->searchWidget->render() : '';
        $this->vars['scopes'] = $this->getScopes();
    }

    public function getSearchWidget(): ?SearchBox
    {
        return $this->searchWidget;
    }

    /**
     * Renders the HTML element for a scope
     */
    public function renderScopeElement($scope): mixed
    {
        $params = ['scope' => $scope];

        return $this->makePartial('filter/scope_'.$scope->type, $params);
    }

    /**
     * Update a filter scope value.
     */
    public function onSubmit(...$params)
    {
        $this->defineFilterScopes();

        $scopes = post($this->alias);
        foreach ($scopes ?? [] as $scope => $value) {
            $scope = $this->getScope($scope);

            switch ($scope->type) {
                case 'select':
                case 'selectlist':
                    $active = $value;
                    $this->setScopeValue($scope, $active);
                    break;

                case 'checkbox':
                    $checked = $value == '1';
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
                    $format = array_get($scope->config, 'showTimePicker', false) ? 'Y-m-d H:i:s' : 'Y-m-d';
                    $dateRange = (is_array($value) && count($value) === 2 && $value[0] != '') ? [
                        make_carbon($value[0])->format($format),
                        make_carbon($value[1])->format($format),
                    ] : null;
                    $this->setScopeValue($scope, $dateRange);
                    break;
            }
        }

        // Trigger class event, merge results as viewable array
        $result = $this->fireEvent('filter.submit', [$params]);
        if ($result && is_array($result)) {
            [$redirect] = $result;

            return ($redirect instanceof RedirectResponse) ? $redirect : array_collapse($result);
        }

        return null;
    }

    public function onClear(...$params)
    {
        $this->resetSession();
        $this->searchWidget?->resetSession();

        $this->defineFilterScopes();

        $result = $this->fireEvent('filter.submit', [$params]);
        if ($result && is_array($result)) {
            [$redirect] = $result;

            return ($redirect instanceof RedirectResponse) ? $redirect : array_collapse($result);
        }

        return null;
    }

    public function getSelectOptions(string $scopeName): array
    {
        $this->defineFilterScopes();

        $scope = $this->getScope($scopeName);
        $activeKey = $scope->value ?: null;

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
     */
    protected function getAvailableOptions(FilterScope $scope): array|Collection
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
     */
    protected function getOptionsFromModel(FilterScope $scope): Collection
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
     */
    protected function getOptionsFromArray(FilterScope $scope): array|Collection
    {
        // Load the data
        $options = $scope->options;

        if (!is_numeric($options) && is_string($options)) {
            if (!$model = $this->getScopeModel($scope->scopeName)) {
                throw new SystemException(sprintf(lang('igniter::admin.list.filter_missing_scope_model'), $scope->scopeName));
            }

            $methodName = $options;

            if (!$model->methodExists($methodName)) {
                throw new SystemException(sprintf(lang('igniter::admin.list.filter_missing_definitions'),
                    $model::class, $methodName, $scope->scopeName,
                ));
            }

            $options = $model->$methodName();
        } elseif (is_callable($options)) {
            return $options();
        }

        return $options;
    }

    /**
     * Creates a flat array of filter scopes from the configuration.
     */
    protected function defineFilterScopes()
    {
        if ($this->scopesDefined) {
            return;
        }

        $this->fireSystemEvent('admin.filter.extendScopesBefore');

        $this->scopes ??= [];

        $this->addScopes($this->scopes);

        $this->fireSystemEvent('admin.filter.extendScopes', [$this->scopes]);

        $this->scopesDefined = true;
    }

    /**
     * Programatically add scopes, used internally and for extensibility.
     */
    public function addScopes(array $scopes): void
    {
        foreach ($scopes as $name => $config) {
            $scopeObj = $this->makeFilterScope($name, $config);

            // Check if admin has permissions to show this column
            $permissions = array_get($config, 'permissions');
            if (!empty($permissions) && !AdminAuth::getUser()?->hasPermission($permissions, false)) {
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
            if ($this->isLocationAware($config)) {
                continue;
            }

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
     */
    protected function makeFilterScope(string $name, array $config): FilterScope
    {
        $label = $config['label'] ?? '';
        $scopeType = $config['type'] ?? '';

        $scope = new FilterScope($name, $label);
        $scope->displayAs($scopeType, $config);

        // Set scope value
        $scope->value = $this->getScopeValue($scope, $config['default'] ?? null);

        return $scope;
    }

    //
    // Filter query logic
    //

    /**
     * Applies all scopes to a DB query.
     */
    public function applyAllScopesToQuery(Builder $query): Builder
    {
        $this->defineFilterScopes();

        foreach ($this->allScopes as $scope) {
            $this->applyScopeToQuery($scope, $query);
        }

        return $query;
    }

    /**
     * Applies a filter scope constraints to a DB query.
     */
    public function applyScopeToQuery(string|FilterScope $scope, Builder $query): Builder
    {
        if (is_string($scope)) {
            $scope = $this->getScope($scope);
        }

        if ($scope->disabled || ($scope->value !== '0' && !$scope->value)) {
            return $query;
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
                /** @var null|int|string|array $value */
                $value = is_array($scope->value) ? array_values($scope->value) : $scope->value;

                if ($scopeConditions = $scope->conditions) {
                    // Switch scope: multiple conditions, value either 1 or 2
                    if (!is_string($scopeConditions)) {
                        $conditionNum = is_array($value) ? 0 : $value - 1;
                        [$scopeConditions] = array_slice($scopeConditions, $conditionNum);
                    }

                    if (is_array($value)) {
                        $filtered = implode(',', array_map(fn($key): string => DB::getPdo()->quote($key), $value));
                    } else {
                        $filtered = DB::getPdo()->quote($value);
                    }

                    $query->whereRaw(strtr($scopeConditions, [':filtered' => $filtered]));
                } elseif ($scopeMethod = $scope->scope) {
                    $query->$scopeMethod($value);
                }

                break;
        }

        return $query;
    }

    //
    // Access layer
    //

    public function getScopeName(string|FilterScope $scope): string
    {
        if (is_string($scope)) {
            $scope = $this->getScope($scope);
        }

        return $this->alias.'['.$scope->scopeName.']';
    }

    /**
     * Returns a scope value for this widget instance.
     */
    public function getScopeValue(string|FilterScope $scope, mixed $default = null): mixed
    {
        if (is_string($scope)) {
            $scope = $this->getScope($scope);
        }

        $cacheKey = 'scope-'.$scope->scopeName;

        return $this->getSession($cacheKey, $default);
    }

    /**
     * Sets an scope value for this widget instance.
     */
    public function setScopeValue(string|FilterScope $scope, mixed $value): void
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
     */
    public function getScopes(): array
    {
        return $this->allScopes;
    }

    /**
     * Get a specified scope object
     */
    public function getScope(string $scope): FilterScope
    {
        if (!isset($this->allScopes[$scope])) {
            throw new SystemException(sprintf(lang('igniter::admin.list.filter_missing_scope_definitions'), $scope));
        }

        return $this->allScopes[$scope];
    }

    /**
     * Returns the display name column for a scope.
     */
    public function getScopeNameFrom(string|FilterScope $scope): string
    {
        if (is_string($scope)) {
            $scope = $this->getScope($scope);
        }

        return $scope->nameFrom;
    }

    /**
     * Returns the active context for displaying the filter.
     */
    public function getContext(): string
    {
        return $this->context;
    }

    protected function getScopeModel($scope): mixed
    {
        return $this->scopeModels[$scope] ?? null;
    }
}

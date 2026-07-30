<?php

declare(strict_types=1);

namespace Igniter\Admin\Http\Actions;

use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;
use Igniter\Admin\Traits\ListExtendable;
use Igniter\Admin\Widgets\Filter;
use Igniter\Admin\Widgets\Lists;
use Igniter\Admin\Widgets\Toolbar;
use Igniter\System\Classes\ControllerAction;
use Illuminate\Support\Facades\DB;

/**
 * List Controller Class
 */
class ListController extends ControllerAction
{
    use ListExtendable;

    /** The primary list alias to use. */
    protected string $primaryAlias = 'list';

    /**
     * Define controller list configuration array.
     *  $listConfig = [
     *      'list'  => [
     *          'title'         => 'lang:text_title',
     *          'emptyMessage' => 'lang:igniter::admin.text_empty',
     *          'configFile'   => null,
     *          'showSetup'         => TRUE,
     *          'showSorting'       => TRUE,
     *          'showCheckboxes'    => TRUE,
     *          'defaultSort'  => [
     *              'primary_key', 'DESC'
     *          ],
     *      ],
     *  ];
     */
    public array $listConfig;

    /**
     * @var Lists[] Reference to the list widget objects
     */
    protected array $listWidgets = [];

    protected array $toolbarWidgets = [];

    protected array $filterWidgets = [];

    protected array $requiredProperties = ['listConfig'];

    /** Required controller configuration array keys */
    protected array $requiredConfig = ['model', 'configFile'];

    public function __construct($controller)
    {
        parent::__construct($controller);

        $this->listConfig = $controller->listConfig;
        $this->primaryAlias = key($controller->listConfig) ?? $this->primaryAlias;

        // Build configuration
        $this->setConfig($controller->listConfig[$this->primaryAlias] ?? [], $this->requiredConfig);

        $this->hideAction([
            'index_onDelete',
            'renderList',
            'refreshList',
            'getListWidget',
            'listExtendColumns',
            'listExtendModel',
            'listExtendQueryBefore',
            'listExtendQuery',
            'listFilterExtendQuery',
            'listOverrideColumnValue',
            'listOverrideHeaderValue',
        ]);
    }

    public function index(): void
    {
        $pageTitle = lang($this->getConfig('title', 'No title'));
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);

        if ($backUrl = $this->getConfig('back')) {
            AdminMenu::setPreviousUrl($backUrl);
        }

        $this->makeLists();
    }

    public function index_onDelete(): array
    {
        $checkedIds = post('checked');
        if (!is_array($checkedIds) || empty($checkedIds)) {
            flash()->success(lang('igniter::admin.list.delete_empty'));

            return $this->controller->refreshList();
        }

        if (!$alias = post('alias')) {
            $alias = $this->primaryAlias;
        }

        $listConfig = $this->makeConfig($this->listConfig[$alias], $this->requiredConfig);

        $modelClass = $listConfig['model'];
        $model = new $modelClass;
        $model = $this->controller->listExtendModel($model, $alias);

        $query = $model->newQuery();
        $this->controller->listExtendQueryBefore($query, $alias);

        $query->whereIn($model->getKeyName(), $checkedIds);
        $records = $query->get();

        // Delete records
        if ($count = $records->count()) {
            DB::transaction(function() use ($records) {
                foreach ($records as $record) {
                    $record->delete();
                }
            });

            $prefix = ($count > 1) ? ' records' : 'record';
            flash()->success(sprintf(lang('igniter::admin.alert_success'), '['.$count.']'.$prefix.' '.lang('igniter::admin.text_deleted')));
        } else {
            flash()->warning(sprintf(lang('igniter::admin.alert_error_nothing'), lang('igniter::admin.text_deleted')));
        }

        return $this->controller->refreshList($alias);
    }

    /**
     * Creates all the widgets based on the model config.
     */
    public function makeLists(): array
    {
        $this->listWidgets = [];

        foreach (array_keys($this->listConfig) as $alias) {
            $this->listWidgets[$alias] = $this->makeList($alias);
        }

        return $this->listWidgets;
    }

    /**
     * Prepare the widgets used by this action
     */
    public function makeList(?string $alias = null): Lists
    {
        $alias ??= $this->primaryAlias;

        $listConfig = $this->controller->getListConfig($alias);

        $modelClass = $listConfig['model'];
        $model = new $modelClass;
        unset($listConfig['model']);
        $model = $this->controller->listExtendModel($model, $alias);

        // Prep the list widget config
        $requiredConfig = [$alias];
        $configFile = $listConfig['configFile'];
        $modelConfig = $this->loadConfig($configFile, $requiredConfig, $alias);

        $columnConfig['bulkActions'] = $modelConfig['bulkActions'] ?? [];
        $columnConfig['columns'] = $modelConfig['columns'];
        $columnConfig['model'] = $model;
        $columnConfig['alias'] = $alias;

        /** @var Lists $widget */
        $widget = $this->makeWidget(Lists::class, array_merge($columnConfig, $listConfig));

        $widget->bindEvent('list.extendColumns', function() use ($widget) {
            $this->controller->listExtendColumns($widget);
        });

        $widget->bindEvent('list.extendQueryBefore', function($query) use ($alias) {
            $this->controller->listExtendQueryBefore($query, $alias);
        });

        $widget->bindEvent('list.extendQuery', function($query) use ($alias) {
            $this->controller->listExtendQuery($query, $alias);
        });

        $widget->bindEvent('list.extendRecords', fn($records) => $this->controller->listExtendRecords($records, $alias));

        $widget->bindEvent('list.overrideColumnValue', fn($record, $column, $value) => $this->controller->listOverrideColumnValue($record, $column, $alias));

        $widget->bindEvent('list.overrideHeaderValue', fn($column, $value) => $this->controller->listOverrideHeaderValue($column, $alias));

        $widget->bindToController();

        // Prep the optional toolbar widget
        if (isset($this->controller->widgets['toolbar']) && (isset($listConfig['toolbar']) || isset($modelConfig['toolbar']))) {
            $this->toolbarWidgets[$alias] = clone $this->controller->widgets['toolbar'];
            if ($this->toolbarWidgets[$alias] instanceof Toolbar) {
                $this->toolbarWidgets[$alias]->reInitialize($listConfig['toolbar'] ?? $modelConfig['toolbar']);
                $this->toolbarWidgets[$alias]->bindToController();
            }
        }

        // Prep the optional filter widget
        if (array_get($modelConfig, 'filter')) {
            $filterConfig = $modelConfig['filter'];
            $filterConfig['alias'] = $widget->alias.'_filter';
            /** @var Filter $filterWidget */
            $filterWidget = $this->makeWidget(Filter::class, $filterConfig);
            $filterWidget->bindToController();

            if ($searchWidget = $filterWidget->getSearchWidget()) {
                $searchWidget->bindEvent('search.submit', function() use ($widget, $searchWidget) {
                    $widget->setSearchTerm($searchWidget->getActiveTerm());

                    return $widget->onRefresh();
                });

                $widget->setSearchOptions([
                    'mode' => $searchWidget->mode,
                    'scope' => $searchWidget->scope,
                ]);

                // Find predefined search term
                $widget->setSearchTerm($searchWidget->getActiveTerm());
            }

            $filterWidget->bindEvent('filter.submit', fn() => $widget->onRefresh());

            $filterWidget->bindEvent('filter.extendScopesBefore', function() use ($filterWidget) {
                $this->controller->listFilterExtendScopesBefore($filterWidget);
            });

            $filterWidget->bindEvent('filter.extendScopes', function($scopes) use ($filterWidget) {
                $this->controller->listFilterExtendScopes($filterWidget, $scopes);
            });

            $filterWidget->bindEvent('filter.extendQuery', function($query, $scope) {
                $this->controller->listFilterExtendQuery($query, $scope);
            });

            // Apply predefined filter values
            $widget->addFilter($filterWidget->applyAllScopesToQuery(...));

            $this->filterWidgets[$alias] = $filterWidget;
        }

        return $widget;
    }

    public function renderList(?string $alias = null, bool $listOnly = false): string
    {
        if (is_null($alias) || !isset($this->listConfig[$alias])) {
            $alias = $this->primaryAlias;
        }

        $list = [];

        if (!$listOnly && isset($this->toolbarWidgets[$alias])) {
            $list[] = $this->toolbarWidgets[$alias]->render();
        }

        if (!$listOnly && isset($this->filterWidgets[$alias])) {
            $list[] = $this->filterWidgets[$alias]->render();
        }

        $list[] = $this->listWidgets[$alias]->render();

        return implode(PHP_EOL, $list);
    }

    public function refreshList(?string $alias = null): array
    {
        if (!$this->listWidgets) {
            $this->makeLists();
        }

        if (!$alias || !isset($this->listConfig[$alias])) {
            $alias = $this->primaryAlias;
        }

        return $this->listWidgets[$alias]->onRefresh();
    }

    public function renderListToolbar(?string $alias = null): mixed
    {
        $alias ??= $this->primaryAlias;

        return isset($this->toolbarWidgets[$alias]) ? $this->toolbarWidgets[$alias]->render() : null;
    }

    public function renderListFilter(?string $alias = null): mixed
    {
        $alias ??= $this->primaryAlias;
        if (isset($this->filterWidgets[$alias])) {
            return $this->filterWidgets[$alias]->render();
        }

        return null;
    }

    /**
     * Returns the widget used by this behavior.
     */
    public function getListWidget(?string $alias = null): ?Lists
    {
        if (!$alias) {
            $alias = $this->primaryAlias;
        }

        return array_get($this->listWidgets, $alias);
    }

    /**
     * Returns the configuration used by this behavior.
     */
    public function getListConfig(?string $alias = null): array
    {
        if (!$alias) {
            $alias = $this->primaryAlias;
        }

        return array_get($this->listConfig, $alias, []);
    }
}

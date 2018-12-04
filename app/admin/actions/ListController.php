<?php

namespace Admin\Actions;

use Admin\Traits\ListExtendable;
use System\Classes\BaseController;
use System\Classes\ControllerAction;
use Template;

/**
 * List Controller Class
 *
 * @package Admin
 */
class ListController extends ControllerAction
{
    use ListExtendable;

    /**
     * @var string The primary list alias to use.
     */
    protected $primaryAlias = 'list';

    /**
     * Define controller list configuration array.
     *  $listConfig = [
     *      'list'  => [
     *          'title'         => 'lang:text_title',
     *          'emptyMessage' => 'lang:admin::lang.text_empty',
     *          'configFile'   => null,
     *          'showSetup'         => TRUE,
     *          'showSorting'       => TRUE,
     *          'showCheckboxes'    => TRUE,
     *          'defaultSort'  => [
     *              'primary_key', 'DESC'
     *          ],
     *      ],
     *  ];
     * @var array
     */
    public $listConfig;

    /**
     * @var \Admin\Widgets\Lists[] Reference to the list widget objects
     */
    protected $listWidgets;

    /**
     * @var \Admin\Widgets\Toolbar[] Reference to the toolbar widget objects.
     */
    protected $toolbarWidget;

    /**
     * @var \Admin\Widgets\Filter[] Reference to the filter widget objects.
     */
    protected $filterWidgets = [];

    protected $requiredProperties = ['listConfig'];

    /**
     * @var array Required controller configuration array keys
     */
    protected $requiredConfig = ['model', 'configFile'];

    /**
     * List_Controller constructor.
     *
     * @param BaseController $controller
     *
     * @throws \Exception
     */
    public function __construct($controller)
    {
        parent::__construct($controller);

        $this->listConfig = $controller->listConfig;
        $this->primaryAlias = key($controller->listConfig);

        // Build configuration
        $this->setConfig($controller->listConfig[$this->primaryAlias], $this->requiredConfig);

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

    public function index()
    {
        $pageTitle = lang($this->getConfig('title', 'lang:text_title'));
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);

        $this->makeLists();
    }

    public function index_onDelete()
    {
        $checkedIds = post('checked');
        if (!$checkedIds OR !is_array($checkedIds) OR !count($checkedIds)) {
            flash()->success(lang('admin::lang.list.delete_empty'));

            return $this->controller->refreshList();
        }

        if (!$alias = post('alias'))
            $alias = $this->primaryAlias;

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
            foreach ($records as $record) {
                $record->delete();
            }

            $prefix = ($count > 1) ? ' records' : 'record';
            flash()->success(sprintf(lang('admin::lang.alert_success'), '['.$count.']'.$prefix.' '.lang('admin::lang.text_deleted')));
        }
        else {
            flash()->warning(sprintf(lang('admin::lang.alert_error_nothing'), lang('admin::lang.text_deleted')));
        }

        return $this->controller->refreshList($alias);
    }

    /**
     * Creates all the widgets based on the model config.
     *
     * @return array List of Admin\Classes\BaseWidget objects
     */
    public function makeLists()
    {
        $this->listWidgets = [];

        foreach ($this->listConfig as $alias => $config) {
            $this->listWidgets[$alias] = $this->makeList($alias);
        }

        return $this->listWidgets;
    }

    /**
     * Prepare the widgets used by this action
     *
     * @param $alias
     *
     * @return \Admin\Classes\BaseWidget
     */
    public function makeList($alias)
    {
        if (!$alias OR !isset($this->listConfig[$alias]))
            $alias = $this->primaryAlias;

        $listConfig = $this->controller->getListConfig($alias);

        $modelClass = $listConfig['model'];
        $model = new $modelClass;
        unset($listConfig['model']);
        $model = $this->controller->listExtendModel($model, $alias);

        // Prep the list widget config
        $requiredConfig = ['list'];
        $configFile = $listConfig['configFile'];
        $modelConfig = $this->loadConfig($configFile, $requiredConfig, 'list');

        $columnConfig['columns'] = $modelConfig['columns'];
        $columnConfig['model'] = $model;
        $columnConfig['alias'] = $alias;

        $widget = $this->makeWidget('Admin\Widgets\Lists', array_merge($columnConfig, $listConfig));

        $widget->bindEvent('list.extendColumns', function () use ($widget) {
            $this->controller->listExtendColumns($widget);
        });

        $widget->bindEvent('list.extendQueryBefore', function ($query) use ($alias) {
            $this->controller->listExtendQueryBefore($query, $alias);
        });

        $widget->bindEvent('list.extendQuery', function ($query) use ($alias) {
            $this->controller->listExtendQuery($query, $alias);
        });

        $widget->bindEvent('list.overrideColumnValue', function ($record, $column, $value) use ($alias) {
            return $this->controller->listOverrideColumnValue($record, $column, $alias);
        });

        $widget->bindEvent('list.overrideHeaderValue', function ($column, $value) use ($alias) {
            return $this->controller->listOverrideHeaderValue($column, $alias);
        });

        $widget->bindToController();

        // Prep the optional toolbar widget
        if (isset($modelConfig['toolbar']) AND isset($this->controller->widgets['toolbar'])) {
            $this->toolbarWidget = $this->controller->widgets['toolbar'];
            if ($this->toolbarWidget instanceof \Admin\Widgets\Toolbar)
                $this->toolbarWidget->addButtons(array_get($modelConfig['toolbar'], 'buttons', []));
        }

        // Prep the optional filter widget
        if (isset($modelConfig['filter'])) {
            $filterConfig = $modelConfig['filter'];
            $filterConfig['alias'] = "{$widget->alias}_filter";
            $filterWidget = $this->makeWidget('Admin\Widgets\Filter', $filterConfig);
            $filterWidget->bindToController();

            if ($searchWidget = $filterWidget->getSearchWidget()) {
                $searchWidget->bindEvent('search.submit', function () use ($widget, $searchWidget) {
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

            $filterWidget->bindEvent('filter.submit', function () use ($widget, $filterWidget) {
                return $widget->onRefresh();
            });

            $filterWidget->bindEvent('filter.extendQuery', function ($query, $scope) {
                $this->controller->listFilterExtendQuery($query, $scope);
            });

            // Apply predefined filter values
            $widget->addFilter([$filterWidget, 'applyAllScopesToQuery']);

            $this->filterWidgets[$alias] = $filterWidget;
        }

        return $widget;
    }

    public function renderList($alias = null)
    {
        if (is_null($alias) OR !isset($this->listConfig[$alias]))
            $alias = $this->primaryAlias;

        $list = [];

        if (!is_null($this->toolbarWidget)) {
            $list[] = $this->toolbarWidget->render();
        }

        if (isset($this->filterWidgets[$alias])) {
            $list[] = $this->filterWidgets[$alias]->render();
        }

        $list[] = $this->listWidgets[$alias]->render();

        return implode(PHP_EOL, $list);
    }

    public function refreshList($alias = null)
    {
        if (!$this->listWidgets) {
            $this->makeLists();
        }

        if (!$alias OR !isset($this->listConfig[$alias])) {
            $alias = $this->primaryAlias;
        }

        return $this->listWidgets[$alias]->onRefresh();
    }

    /**
     * Returns the widget used by this behavior.
     *
     * @param string $alias
     *
     * @return \Admin\Classes\BaseWidget
     */
    public function getListWidget($alias = null)
    {
        if (!$alias) {
            $alias = $this->primaryAlias;
        }

        return array_get($this->listWidgets, $alias);
    }

    /**
     * Returns the configuration used by this behavior.
     *
     * @param null $alias
     *
     * @return \Admin\Classes\BaseWidget
     */
    public function getListConfig($alias = null)
    {
        if (!$alias) {
            $alias = $this->primaryAlias;
        }

        if (!$listConfig = array_get($this->listConfig, $alias)) {
            $listConfig = $this->listConfig[$alias] = $this->makeConfig($this->listConfig[$alias], $this->requiredConfig);
        }

        return $listConfig;
    }
}

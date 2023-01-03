<?php

namespace Admin\Widgets;

use Admin\Classes\BaseWidget;
use Admin\Widgets\Table\Source\DataSource;
use Exception;
use Igniter\Flame\Html\HtmlFacade;
use Illuminate\Support\Facades\Request;

class Table extends BaseWidget
{
    protected $defaultAlias = 'table';

    /**
     * @var array Table columns
     */
    protected $columns = [];

    /**
     * @var bool Show data table header
     */
    protected $showHeader = true;

    /**
     * @var \Admin\Widgets\Table\Source\DataSource
     */
    protected $dataSource = null;

    /**
     * @var string Field name used for request data.
     */
    protected $fieldName = null;

    /**
     * @var string
     */
    protected $recordsKeyFrom;

    protected $dataSourceAliases = 'Admin\Widgets\Table\Source\DataSource';

    public $showPagination = true;

    public $useAjax = false;

    public $pageLimit = 10;

    /**
     * Initialize the widget, called by the constructor and free from its parameters.
     */
    public function initialize()
    {
        $this->columns = $this->getConfig('columns', []);
        $this->fieldName = $this->getConfig('fieldName', $this->alias);
        $this->recordsKeyFrom = $this->getConfig('keyFrom', 'rows');

        $dataSourceClass = $this->getConfig('dataSource');
        if (!strlen($dataSourceClass)) {
            throw new Exception(lang('admin::lang.tables.error_table_widget_data_not_specified'));
        }

        $dataSourceClass = $this->dataSourceAliases;

        if (!class_exists($dataSourceClass)) {
            throw new Exception(sprintf(lang('admin::lang.tables.error_table_widget_data_class_not_found'), $dataSourceClass));
        }

        $this->dataSource = new $dataSourceClass($this->recordsKeyFrom);

        if (Request::method() == 'post' && $this->isClientDataSource()) {
            if (strpos($this->fieldName, '[') === false) {
                $requestDataField = $this->fieldName.'TableData';
            }
            else {
                $requestDataField = $this->fieldName.'[TableData]';
            }

            if (post($requestDataField)) {
                // Load data into the client memory data source on POST
                $this->dataSource->purge();
                $this->dataSource->initRecords(input($requestDataField));
            }
        }
    }

    /**
     * Returns the data source object.
     * @return \Admin\Widgets\Table\Source\DataSource
     */
    public function getDataSource()
    {
        return $this->dataSource;
    }

    /**
     * Renders the widget.
     */
    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('table/table');
    }

    /**
     * Prepares the view data
     */
    public function prepareVars()
    {
        $this->vars['tableId'] = $this->getId();
        $this->vars['tableAlias'] = $this->alias;
        $this->vars['columns'] = $this->prepareColumnsArray();
        $this->vars['recordsKeyFrom'] = $this->recordsKeyFrom;

        $this->vars['showPagination'] = $this->getConfig('showPagination', $this->showPagination);
        $this->vars['pageLimit'] = $this->getConfig('pageLimit', $this->pageLimit);
        $this->vars['toolbar'] = $this->getConfig('toolbar', true);
        $this->vars['height'] = $this->getConfig('height', 'undefined');
        $this->vars['dynamicHeight'] = $this->getConfig('dynamicHeight', false);
        $this->vars['useAjax'] = $this->getConfig('useAjax', false);

        $isClientDataSource = $this->isClientDataSource();
        $this->vars['clientDataSourceClass'] = $isClientDataSource ? 'client' : 'server';
        $this->vars['data'] = json_encode($isClientDataSource
            ? $this->processRecords($this->dataSource->getAllRecords()) : []
        );
    }

    public function loadAssets()
    {
        $this->addCss('vendor/bootstrap-table/bootstrap-table.min.css', 'bootstrap-table-css');
        $this->addCss('css/table.css', 'table-css');

        $this->addJs('vendor/bootstrap-table/bootstrap-table.min.js', 'bootstrap-table-js');
        $this->addJs('js/table.js', 'table-js');
    }

    public function prepareColumnsArray()
    {
        $result = [];

        foreach ($this->columns as $key => $data) {
            $data['field'] = $key;

            if (isset($data['title']))
                $data['title'] = lang($data['title']);

            if (isset($data['partial'])) {
                unset($data['partial']);
            }

            $result[] = $data;
        }

        return $result;
    }

    public function getAttributes()
    {
        return HtmlFacade::attributes($this->getConfig('attributes', []));
    }

    protected function isClientDataSource()
    {
        return $this->dataSource instanceof DataSource;
    }

    public function onGetRecords()
    {
        $search = Request::post('search');
        $offset = Request::post('offset');
        $limit = Request::post('limit', $this->getConfig('pageLimit', $this->pageLimit));

        $eventResults = $this->fireEvent('table.getRecords', [$offset, $limit, $search], true);

        $records = $eventResults->getCollection()->toArray();

        return [
            'rows' => $this->processRecords($records),
            'total' => $eventResults->total(),
        ];
    }

    public function onGetDropdownOptions()
    {
        $columnName = Request::get('column');
        $rowData = Request::get('rowData');

        $eventResults = $this->fireEvent('table.getDropdownOptions', [$columnName, $rowData]);

        $options = [];
        if (count($eventResults)) {
            $options = $eventResults[0];
        }

        return [
            'options' => $options,
        ];
    }

    public function processRecords($records)
    {
        foreach ($records as $index => $record) {
            $records[$index] = $this->processRecord($record);
        }

        return $records;
    }

    protected function processRecord($record)
    {
        foreach ($this->columns as $key => $column) {
            if (isset($record[$key], $column['partial'])) {
                $record[$key] = $this->makePartial($column['partial'], [
                    'column' => $column,
                    'record' => $record,
                    'item' => $record[$key],
                ]);
            }
        }

        return $record;
    }
}

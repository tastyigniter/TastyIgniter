<?php

namespace Admin\Widgets;

use Admin\Classes\BaseWidget;
use Admin\Widgets\Table\Source\DataSource;
use Exception;
use Input;
use Request;

class Table extends BaseWidget
{
    protected $defaultAlias = 'table';

    /**
     * @var array Table columns
     */
    protected $columns = [];

    /**
     * @var boolean Show data table header
     */
    protected $showHeader = TRUE;

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

    public $showPagination = TRUE;

    public $pageLimit = 20;

    /**
     * Initialize the widget, called by the constructor and free from its parameters.
     */
    public function initialize()
    {
        $this->columns = $this->getConfig('columns', []);
        $this->fieldName = $this->getConfig('fieldName', $this->alias);
        $this->recordsKeyFrom = $this->getConfig('keyFrom', 'id');

        $dataSourceClass = $this->getConfig('dataSource');
        if (!strlen($dataSourceClass)) {
            throw new Exception('The Table widget data source is not specified in the configuration.');
        }

        $dataSourceClass = $this->dataSourceAliases;

        if (!class_exists($dataSourceClass)) {
            throw new Exception(sprintf('The Table widget data source class "%s" could not be found.', $dataSourceClass));
        }

        $this->dataSource = new $dataSourceClass($this->recordsKeyFrom);

        if (Request::method() == 'post' AND $this->isClientDataSource()) {
            if (strpos($this->fieldName, '[') === FALSE) {
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

        $this->vars['showPagination'] = $this->showPagination;
        $this->vars['pageLimit'] = $this->getConfig('pageLimit', $this->pageLimit);
        $this->vars['toolbar'] = $this->getConfig('toolbar', TRUE);
        $this->vars['height'] = $this->getConfig('height', FALSE) ?: 'false';
        $this->vars['dynamicHeight'] = $this->getConfig('dynamicHeight', FALSE) ?: 'false';

        $isClientDataSource = $this->isClientDataSource();
        $this->vars['clientDataSourceClass'] = $isClientDataSource ? 'client' : 'server';
        $this->vars['data'] = json_encode($isClientDataSource
            ? $this->dataSource->getAllRecords() : []
        );
    }

    public function loadAssets()
    {
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

            $result[] = $data;
        }

        return $result;
    }

    protected function isClientDataSource()
    {
        return $this->dataSource instanceof DataSource;
    }

    public function onGetDropdownOptions()
    {
        $columnName = Input::get('column');
        $rowData = Input::get('rowData');

        $eventResults = $this->fireEvent('table.getDropdownOptions', [$columnName, $rowData]);

        $options = [];
        if (count($eventResults)) {
            $options = $eventResults[0];
        }

        return [
            'options' => $options,
        ];
    }
}

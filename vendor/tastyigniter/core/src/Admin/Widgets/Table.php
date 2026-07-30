<?php

declare(strict_types=1);

namespace Igniter\Admin\Widgets;

use Igniter\Admin\Classes\BaseWidget;
use Igniter\Admin\Classes\TableDataSource;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Html\HtmlFacade;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Support\Facades\Request;
use Override;

class Table extends BaseWidget
{
    protected string $defaultAlias = 'table';

    /** Table columns */
    protected array $columns = [];

    /** Show data table header */
    protected bool $showHeader = true;

    protected ?TableDataSource $dataSource = null;

    /** Field name used for request data. */
    protected ?string $fieldName = null;

    protected ?string $recordsKeyFrom = null;

    protected string $dataSourceAliases = TableDataSource::class;

    public bool $showPagination = true;

    public bool $useAjax = false;

    public int $pageLimit = 10;

    /**
     * Initialize the widget, called by the constructor and free from its parameters.
     */
    #[Override]
    public function initialize(): void
    {
        $this->columns = $this->getConfig('columns', []);
        $this->fieldName = $this->getConfig('fieldName', $this->alias);
        $this->recordsKeyFrom = $this->getConfig('keyFrom', 'rows');

        $dataSourceClass = $this->dataSourceAliases;
        if (!class_exists($dataSourceClass)) {
            throw new SystemException(sprintf(lang('igniter::admin.error_table_widget_data_class_not_found'), $dataSourceClass));
        }

        $this->dataSource = new $dataSourceClass($this->recordsKeyFrom);

        if (strtolower(request()->method()) === 'post' && $this->isClientDataSource()) {
            if (!str_contains((string)$this->fieldName, '[')) {
                $requestDataField = $this->fieldName.'TableData';
            } else {
                $requestDataField = $this->fieldName.'[TableData]';
            }

            if (post($requestDataField)) {
                // Load data into the client memory data source on POST
                $this->dataSource->purge();
                $this->dataSource->initRecords(post($requestDataField));
            }
        }
    }

    /**
     * Returns the data source object.
     */
    public function getDataSource(): TableDataSource
    {
        return $this->dataSource;
    }

    /**
     * Renders the widget.
     */
    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('table/table');
    }

    /**
     * Prepares the view data
     */
    public function prepareVars(): void
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
            ? $this->processRecords($this->dataSource->getAllRecords()) : [],
        );
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addCss('table.css', 'table-css');
        $this->addJs('table.js', 'table-js');
    }

    public function prepareColumnsArray(): array
    {
        $result = [];

        foreach ($this->columns as $key => $data) {
            $data['field'] = $key;

            if (isset($data['title'])) {
                $data['title'] = lang($data['title']);
            }

            if (isset($data['partial'])) {
                unset($data['partial']);
            }

            $result[] = $data;
        }

        return $result;
    }

    public function getAttributes(): string
    {
        return HtmlFacade::attributes($this->getConfig('attributes', []));
    }

    protected function isClientDataSource(): bool
    {
        return $this->dataSource instanceof TableDataSource;
    }

    public function onGetRecords(): array
    {
        $search = Request::post('search', '');
        $offset = Request::post('offset', '1');
        $limit = Request::post('limit', $this->getConfig('pageLimit', $this->pageLimit));

        /** @var null|array|LengthAwarePaginatorContract $eventResults */
        $eventResults = $this->fireEvent('table.getRecords', [$offset, $limit, $search], true);

        throw_unless($eventResults instanceof LengthAwarePaginatorContract, new SystemException(
            'table.getRecords event must return a '.LengthAwarePaginatorContract::class.' instance.',
        ));

        $records = $eventResults->getCollection()->toArray();

        return [
            'rows' => $this->processRecords($records),
            'total' => $eventResults->total(),
        ];
    }

    public function onGetDropdownOptions(): array
    {
        $columnName = Request::get('column');
        $rowData = Request::get('rowData');

        $options = [];
        $eventResults = $this->fireEvent('table.getDropdownOptions', [$columnName, $rowData]);
        if (count($eventResults) > 0) {
            $options = $eventResults[0];
        }

        return [
            'options' => $options,
        ];
    }

    public function processRecords(array $records): array
    {
        foreach ($records as $index => $record) {
            $records[$index] = $this->processRecord($record);
        }

        return $records;
    }

    protected function processRecord(array $record): array
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

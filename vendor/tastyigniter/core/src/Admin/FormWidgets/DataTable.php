<?php

declare(strict_types=1);

namespace Igniter\Admin\FormWidgets;

use Exception;
use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Traits\FormModelWidget;
use Igniter\Admin\Widgets\Table;
use Igniter\Flame\Exception\SystemException;
use Igniter\Local\Traits\LocationAwareWidget;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Override;

/**
 * Data Table
 * Renders a table field.
 *
 * Adapted from october\backend\classes\DataTable
 */
class DataTable extends BaseFormWidget
{
    use FormModelWidget;
    use LocationAwareWidget;

    //
    // Configurable properties
    //

    /**
     * @var string Table size
     */
    public string $size = 'large';

    public null|string|array $defaultSort = null;

    public array $searchableFields = [];

    public bool $showRefreshButton = false;

    public bool $useAjax = false;

    //
    // Object properties
    //

    protected string $defaultAlias = 'datatable';

    protected ?Table $table = null;

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'size',
            'defaultSort',
            'searchableFields',
            'showRefreshButton',
            'attributes',
            'useAjax',
        ]);

        if ($this->searchableFields) {
            $this->config['attributes']['data-search'] = array_get($this->config, 'attributes.data-search', 'true');
        }

        if ($this->showRefreshButton) {
            $this->config['attributes']['data-show-refresh'] = 'true';
        }

        if ($this->useAjax) {
            $this->config['attributes']['data-side-pagination'] = 'server';
            $this->config['attributes']['data-silent-sort'] = 'false';
        }

        $this->table = $this->makeTableWidget();
        $this->table->bindToController();
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('datatable/datatable');
    }

    #[Override]
    public function getLoadValue(): mixed
    {
        $value = parent::getLoadValue();
        if ($value instanceof Collection) {
            return $value->toArray();
        }

        // Sync the array keys as the ID to make the
        // table widget happy!
        foreach ((array)$value as $key => $_value) {
            $value[$key] = ['id' => $key] + (array)$_value;
        }

        return $value;
    }

    #[Override]
    public function getSaveValue(mixed $value): mixed
    {
        $dataSource = $this->table->getDataSource();

        $result = [];
        while ($records = $dataSource->readRecords()) {
            $result = array_merge($result, $records);
        }

        // We should be dealing with a simple array, so
        // strip out the id columns in the final array.
        foreach (array_keys($result) as $key) {
            unset($result[$key]['id']);
        }

        return $result ?: FormField::NO_SAVE_DATA;
    }

    public function getTable(): Table
    {
        return $this->table;
    }

    /**
     * Prepares the list data
     */
    public function prepareVars(): void
    {
        $this->populateTableWidget();
        $this->vars['table'] = $this->table;
        $this->vars['dataTableId'] = $this->getId();
        $this->vars['size'] = $this->size;
    }

    public function getDataTableRecords(int $offset, int $limit, string $search): LengthAwarePaginator
    {
        $relationObject = $this->getRelationObject();
        $query = $relationObject->newQuery();

        $this->locationApplyScope($query);

        if ($search !== '' && $search !== '0') {
            $query->search($search, $this->searchableFields);
        }

        if (is_array($this->defaultSort)) {
            [$sortColumn, $sortBy] = $this->defaultSort;
            $query->orderBy($sortColumn, $sortBy);
        }

        $page = ($offset / $limit) + 1;

        return $query->paginate($limit, ['*'], 'page', $page);
    }

    /**
     * Looks at the model for getXXXDataTableOptions or getDataTableOptions methods
     * to obtain values for autocomplete field types.
     *
     * @param string $field Table field name
     * @param array $data Data for the entire table
     *
     * @throws Exception
     */
    public function getDataTableOptions(string $field, array $data): array
    {
        $methodName = 'get'.studly_case($this->fieldName).'DataTableOptions';

        if (!$this->model->methodExists($methodName) && !$this->model->methodExists('getDataTableOptions')) {
            throw new SystemException(sprintf(lang('igniter::admin.alert_missing_method'), 'getDataTableOptions', $this->model::class));
        }

        if ($this->model->methodExists($methodName)) {
            $result = $this->model->$methodName($field, $data);
        } else {
            $result = $this->model->getDataTableOptions($this->fieldName, $field, $data);
        }

        return is_array($result) ? $result : [];
    }

    /**
     * Populate data
     */
    protected function populateTableWidget()
    {
        $dataSource = $this->table->getDataSource();

        $records = [];
        if (!$this->useAjax) {
            $records = $this->getLoadValue() ?: [];
        }

        $dataSource->purge();
        $dataSource->initRecords($records);
    }

    protected function makeTableWidget(): Table
    {
        $config = $this->config;

        $config['dataSource'] = 'client';
        $config['alias'] = studly_case(name_to_id($this->fieldName)).'datatable';
        $config['fieldName'] = $this->fieldName;

        /** @var Table $table */
        $table = $this->makeWidget(Table::class, $config);

        $table->bindEvent('table.getRecords', $this->getDataTableRecords(...));
        $table->bindEvent('table.getDropdownOptions', $this->getDataTableOptions(...));

        return $table;
    }
}

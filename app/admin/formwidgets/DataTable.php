<?php namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Widgets\Table;
use Exception;
use Illuminate\Database\Eloquent\Collection;

/**
 * Data Table
 * Renders a table field.
 *
 * Adapted from october\backend\classes\DataTable
 *
 * @package Admin
 */
class DataTable extends BaseFormWidget
{
    //
    // Configurable properties
    //

    /**
     * @var string Table size
     */
    public $size = 'large';

    /**
     * @var bool Allow rows to be sorted
     */
    public $rowSorting = FALSE;

    //
    // Object properties
    //

    protected $defaultAlias = 'datatable';

    /**
     * @var \Admin\Widgets\Table Table widget
     */
    protected $table;

    public function initialize()
    {
        $this->fillFromConfig([
            'size',
            'rowSorting',
        ]);

        $this->table = $this->makeTableWidget();
        $this->table->bindToController();
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('datatable/datatable');
    }

    public function getLoadValue()
    {
        $value = parent::getLoadValue();
        if ($value instanceof Collection)
            return $value->toArray();

        // Sync the array keys as the ID to make the
        // table widget happy!
        foreach ((array)$value as $key => $_value) {
            $value[$key] = ['id' => $key] + (array)$_value;
        }

        return $value;
    }

    public function getSaveValue($value)
    {
        $dataSource = $this->table->getDataSource();

        $result = [];
        while ($records = $dataSource->readRecords()) {
            $result = array_merge($result, $records);
        }

        // We should be dealing with a simple array, so
        // strip out the id columns in the final array.
        foreach ($result as $key => $_result) {
            unset($result[$key]['id']);
        }

        return -1;
    }

    /**
     * @return \Admin\Widgets\Table   The table to be displayed.
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Prepares the list data
     */
    public function prepareVars()
    {
        $this->populateTableWidget();
        $this->vars['table'] = $this->table;
        $this->vars['dataTableId'] = $this->getId();
        $this->vars['size'] = $this->size;
        $this->vars['rowSorting'] = $this->rowSorting;
    }

    /**
     * Looks at the model for getXXXDataTableOptions or getDataTableOptions methods
     * to obtain values for autocomplete field types.
     *
     * @param  string $field Table field name
     * @param  string $data Data for the entire table
     *
     * @return array
     * @throws \Exception
     */
    public function getDataTableOptions($field, $data)
    {
        $methodName = 'get'.studly_case($this->fieldName).'DataTableOptions';

        if (!$this->model->methodExists($methodName) AND !$this->model->methodExists('getDataTableOptions')) {
            throw new Exception(sprintf('Missing method [%s] in %s', 'getDataTableOptions', get_class($this->model)));
        }

        if ($this->model->methodExists($methodName)) {
            $result = $this->model->$methodName($field, $data);
        }
        else {
            $result = $this->model->getDataTableOptions($this->fieldName, $field, $data);
        }

        if (!is_array($result)) {
            $result = [];
        }

        return $result;
    }

    /**
     * Populate data
     */
    protected function populateTableWidget()
    {
        $dataSource = $this->table->getDataSource();

        $records = $this->getLoadValue() ?: [];

        $dataSource->purge();
        $dataSource->initRecords($records);
    }

    protected function makeTableWidget()
    {
        $config = $this->config;

        $config['dataSource'] = 'client';
        $config['alias'] = studly_case(name_to_id($this->fieldName)).'datatable';
        $config['fieldName'] = $this->fieldName;

        $table = new Table($this->getController(), $config);

        $table->bindEvent('table.getDropdownOptions', [$this, 'getDataTableOptions']);

        return $table;
    }
}
